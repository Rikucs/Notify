# Website Hosting Guide for Notify Application

## Overview
This is a PHP-based web notification system that can be hosted on any web server supporting PHP and SQL Server connectivity.

## System Requirements

### Web Server
- **Apache 2.4+** or **Nginx 1.18+**
- **PHP 7.0+** (tested with PHP 8.3.6)
- SSL/TLS support recommended for production

### PHP Extensions Required
```
- php-pdo
- php-sqlsrv (SQL Server PDO driver)
- php-ldap
- php-zlib
- php-mbstring
- php-json
- php-xml
```

### Database
- **Microsoft SQL Server** 2012+
- Database: `webPortal`
- Network access to SQL Server instance

### Authentication
- **LDAP/Active Directory** server
- Network access to LDAP server

## Installation Steps

### 1. Server Preparation

#### For Ubuntu/Debian:
```bash
sudo apt update
sudo apt install apache2 php php-pdo php-ldap php-zlib php-mbstring php-json php-xml

# Install SQL Server ODBC driver and PHP extension
curl https://packages.microsoft.com/keys/microsoft.asc | sudo apt-key add -
curl https://packages.microsoft.com/config/ubuntu/20.04/prod.list | sudo tee /etc/apt/sources.list.d/msprod.list
sudo apt update
sudo apt install msodbcsql17 unixodbc-dev
sudo pecl install sqlsrv pdo_sqlsrv
```

#### For CentOS/RHEL:
```bash
sudo yum install httpd php php-pdo php-ldap php-zlib php-mbstring php-json php-xml
# Install SQL Server drivers (follow Microsoft documentation)
```

### 2. Web Server Configuration

#### Apache Configuration
Create virtual host file `/etc/apache2/sites-available/notify.conf`:
```apache
<VirtualHost *:80>
    ServerName your-domain.com
    DocumentRoot /var/www/html/notify
    
    <Directory /var/www/html/notify>
        AllowOverride All
        Require all granted
    </Directory>
    
    ErrorLog ${APACHE_LOG_DIR}/notify_error.log
    CustomLog ${APACHE_LOG_DIR}/notify_access.log combined
</VirtualHost>

# For HTTPS (recommended for production)
<VirtualHost *:443>
    ServerName your-domain.com
    DocumentRoot /var/www/html/notify
    
    SSLEngine on
    SSLCertificateFile /path/to/your/certificate.crt
    SSLCertificateKeyFile /path/to/your/private.key
    
    <Directory /var/www/html/notify>
        AllowOverride All
        Require all granted
    </Directory>
    
    ErrorLog ${APACHE_LOG_DIR}/notify_ssl_error.log
    CustomLog ${APACHE_LOG_DIR}/notify_ssl_access.log combined
</VirtualHost>
```

#### Nginx Configuration
Create file `/etc/nginx/sites-available/notify`:
```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /var/www/html/notify;
    index index.php index.html;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.ht {
        deny all;
    }
}

# HTTPS configuration (recommended)
server {
    listen 443 ssl http2;
    server_name your-domain.com;
    root /var/www/html/notify;
    index index.php index.html;

    ssl_certificate /path/to/your/certificate.crt;
    ssl_certificate_key /path/to/your/private.key;
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers ECDHE-RSA-AES256-GCM-SHA512:DHE-RSA-AES256-GCM-SHA512;
    
    # ... rest of the configuration same as HTTP
}
```

### 3. Application Deployment

1. **Clone/Upload the repository** to your web server:
```bash
sudo git clone https://github.com/Rikucs/Notify.git /var/www/html/notify
# OR upload files via FTP/SFTP
```

2. **Set proper permissions**:
```bash
sudo chown -R www-data:www-data /var/www/html/notify
sudo chmod -R 755 /var/www/html/notify
sudo chmod -R 777 /var/www/html/notify/temp  # If temp directory needs write access
```

### 4. Configuration

#### Database Configuration
Update the following files with your database credentials:
- `notify/config/config.php`
- `ExternalLinks/config/config.php`
- `ttcs/config/config.php`
- `vendedores/config/config.php`

Replace the hardcoded values:
```php
$server = "your-sql-server-ip";
$door = 1433;  // or your SQL Server port
$db = "webPortal";  // your database name
$user = "your-username";
$password = "your-password";
```

#### LDAP Configuration
Update `login/Auth.php`:
```php
$ldapconn = ldap_connect("your-ldap-server") or die("Could not connect to LDAP server.");
```

### 5. Security Considerations

#### Environment Variables (Recommended)
Instead of hardcoded credentials, use environment variables:

1. Create `.env` file (add to .gitignore):
```
DB_SERVER=your-sql-server
DB_PORT=1433
DB_NAME=webPortal
DB_USERNAME=your-username
DB_PASSWORD=your-password
LDAP_SERVER=your-ldap-server
```

2. Update config files to use environment variables:
```php
$server = $_ENV['DB_SERVER'] ?? 'localhost';
$door = $_ENV['DB_PORT'] ?? 1433;
$db = $_ENV['DB_NAME'] ?? 'webPortal';
$user = $_ENV['DB_USERNAME'] ?? '';
$password = $_ENV['DB_PASSWORD'] ?? '';
```

#### Additional Security Measures
- Enable HTTPS with valid SSL certificates
- Use strong database passwords
- Configure firewall rules
- Regular security updates
- Hide sensitive files from web access
- Enable PHP security features in php.ini

### 6. Testing the Installation

1. Access your domain in a web browser
2. You should see the login page
3. Test login functionality with valid LDAP credentials
4. Verify database connectivity by accessing notification pages

## Hosting Providers

### Suitable Hosting Options

#### Traditional Web Hosting
- **Requirements**: PHP support with SQL Server extensions
- **Providers**: Look for Windows-based hosting or Linux hosting with SQL Server support
- **Cost**: $5-50/month depending on requirements

#### Cloud Hosting
- **AWS**: EC2 with Windows Server or Linux + SQL Server RDS
- **Microsoft Azure**: App Service with Azure SQL Database
- **Google Cloud**: Compute Engine with Cloud SQL for SQL Server
- **DigitalOcean**: Droplets with managed databases

#### VPS/Dedicated Servers
- Full control over configuration
- Can install required PHP extensions
- Suitable for enterprise deployment

### Database Hosting Options
- **Managed SQL Server**: Azure SQL Database, AWS RDS for SQL Server
- **Self-hosted**: SQL Server on VPS/dedicated server
- **Hybrid**: Local SQL Server with VPN connection

## Troubleshooting

### Common Issues
1. **SQLSRV Extension Not Found**: Install Microsoft ODBC Driver and PHP SQLSRV extension
2. **LDAP Connection Failed**: Check network connectivity and LDAP server configuration
3. **Permission Denied**: Check file permissions and web server user
4. **Database Connection Failed**: Verify credentials and network connectivity

### Log Locations
- Apache: `/var/log/apache2/`
- Nginx: `/var/log/nginx/`
- PHP: Check `php.ini` for error_log location

## Support
For issues specific to this application, check the repository or contact the development team.