#!/bin/bash

# Notify Application Deployment Script
# This script helps deploy the Notify application on Ubuntu/Debian systems

set -e

echo "================================================"
echo "      Notify Application Deployment Script     "
echo "================================================"

# Check if running as root
if [ "$EUID" -eq 0 ]; then
    echo "Error: Please do not run this script as root"
    echo "Run with: ./deploy.sh"
    exit 1
fi

# Function to check if command exists
command_exists() {
    command -v "$1" >/dev/null 2>&1
}

# Function to install packages
install_packages() {
    echo "Installing required packages..."
    sudo apt update
    sudo apt install -y apache2 php php-cli php-pdo php-ldap php-zlib php-mbstring php-json php-xml curl wget gnupg unixodbc-dev
}

# Function to install SQL Server ODBC driver
install_sqlserver_driver() {
    echo "Installing SQL Server ODBC driver..."
    
    # Add Microsoft repository
    curl -sSL https://packages.microsoft.com/keys/microsoft.asc | sudo apt-key add -
    
    # Detect Ubuntu version
    UBUNTU_VERSION=$(lsb_release -rs)
    curl -sSL https://packages.microsoft.com/config/ubuntu/${UBUNTU_VERSION}/prod.list | sudo tee /etc/apt/sources.list.d/msprod.list
    
    sudo apt update
    sudo ACCEPT_EULA=Y apt install -y msodbcsql17
    
    # Install PHP SQL Server extensions
    sudo pecl install sqlsrv pdo_sqlsrv
    
    # Add extensions to PHP configuration
    echo "extension=sqlsrv.so" | sudo tee /etc/php/$(php -r 'echo PHP_MAJOR_VERSION.".".PHP_MINOR_VERSION;')/apache2/conf.d/20-sqlsrv.ini
    echo "extension=pdo_sqlsrv.so" | sudo tee /etc/php/$(php -r 'echo PHP_MAJOR_VERSION.".".PHP_MINOR_VERSION;')/apache2/conf.d/30-pdo_sqlsrv.ini
}

# Function to configure Apache
configure_apache() {
    echo "Configuring Apache..."
    
    # Enable required modules
    sudo a2enmod rewrite headers expires deflate ssl
    
    # Copy application files
    if [ ! -d "/var/www/html/notify" ]; then
        sudo mkdir -p /var/www/html/notify
    fi
    
    sudo cp -r . /var/www/html/notify/
    sudo chown -R www-data:www-data /var/www/html/notify
    sudo chmod -R 755 /var/www/html/notify
    
    # Create temp directory with write permissions
    sudo mkdir -p /var/www/html/notify/temp
    sudo chmod 777 /var/www/html/notify/temp
    
    # Create virtual host if it doesn't exist
    if [ ! -f "/etc/apache2/sites-available/notify.conf" ]; then
        sudo tee /etc/apache2/sites-available/notify.conf > /dev/null <<EOL
<VirtualHost *:80>
    ServerName $(hostname -f)
    DocumentRoot /var/www/html/notify
    
    <Directory /var/www/html/notify>
        AllowOverride All
        Require all granted
    </Directory>
    
    ErrorLog \${APACHE_LOG_DIR}/notify_error.log
    CustomLog \${APACHE_LOG_DIR}/notify_access.log combined
</VirtualHost>
EOL
        
        sudo a2ensite notify.conf
        sudo a2dissite 000-default.conf 2>/dev/null || true
        sudo systemctl reload apache2
    fi
}

# Function to configure environment
configure_environment() {
    echo "Setting up environment configuration..."
    
    if [ ! -f "/var/www/html/notify/.env" ]; then
        if [ -f "/var/www/html/notify/.env.example" ]; then
            sudo cp /var/www/html/notify/.env.example /var/www/html/notify/.env
            echo "Environment file created from template."
            echo "Please edit /var/www/html/notify/.env with your database and LDAP settings."
        fi
    fi
}

# Function to setup firewall
setup_firewall() {
    if command_exists ufw; then
        echo "Configuring firewall..."
        sudo ufw allow 'Apache Full'
        sudo ufw --force enable
    fi
}

# Function to create systemd service (if needed)
create_service() {
    echo "Apache service is already managed by systemd."
    sudo systemctl enable apache2
    sudo systemctl start apache2
}

# Function to run tests
run_tests() {
    echo "Testing installation..."
    
    # Test Apache
    if sudo systemctl is-active --quiet apache2; then
        echo "✓ Apache is running"
    else
        echo "✗ Apache is not running"
        return 1
    fi
    
    # Test PHP
    if php -v >/dev/null 2>&1; then
        echo "✓ PHP is working"
    else
        echo "✗ PHP is not working"
        return 1
    fi
    
    # Test PHP extensions
    php -m | grep -q pdo && echo "✓ PDO extension loaded" || echo "✗ PDO extension missing"
    php -m | grep -q ldap && echo "✓ LDAP extension loaded" || echo "✗ LDAP extension missing"
    php -m | grep -q sqlsrv && echo "✓ SQLSRV extension loaded" || echo "✗ SQLSRV extension missing"
    
    echo "Installation test completed."
}

# Function to display final information
show_final_info() {
    echo ""
    echo "================================================"
    echo "           Deployment Completed!               "
    echo "================================================"
    echo ""
    echo "Your Notify application has been deployed to: /var/www/html/notify"
    echo ""
    echo "Next steps:"
    echo "1. Configure your database settings in: /var/www/html/notify/.env"
    echo "2. Update LDAP server settings in: /var/www/html/notify/login/Auth.php"
    echo "3. Access your application at: http://$(hostname -f)/"
    echo ""
    echo "Important files:"
    echo "- Main config: /var/www/html/notify/.env"
    echo "- Apache config: /etc/apache2/sites-available/notify.conf"
    echo "- Application logs: /var/log/apache2/notify_*.log"
    echo ""
    echo "For troubleshooting, check:"
    echo "- Apache status: sudo systemctl status apache2"
    echo "- Apache logs: sudo tail -f /var/log/apache2/notify_error.log"
    echo "- PHP errors: Check error_log in php.ini"
    echo ""
}

# Main deployment function
main() {
    echo "Starting deployment process..."
    echo ""
    
    # Check system requirements
    if ! command_exists apt; then
        echo "Error: This script is designed for Ubuntu/Debian systems"
        exit 1
    fi
    
    # Run deployment steps
    install_packages
    install_sqlserver_driver
    configure_apache
    configure_environment
    setup_firewall
    create_service
    
    echo ""
    run_tests
    
    show_final_info
}

# Script options
case "${1:-}" in
    --help|-h)
        echo "Usage: $0 [OPTIONS]"
        echo ""
        echo "Options:"
        echo "  --help, -h     Show this help message"
        echo "  --test         Run tests only"
        echo ""
        echo "This script will install and configure the Notify application"
        echo "on Ubuntu/Debian systems with Apache and PHP."
        ;;
    --test)
        run_tests
        ;;
    *)
        main
        ;;
esac