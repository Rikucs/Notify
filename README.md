# Notify - Web-Based Notification System

A PHP web application for managing notifications with LDAP authentication and SQL Server database integration.

## 🌐 Can This Be Hosted as a Website?

**YES!** This is a fully functional web application that can be hosted on any web server supporting PHP and SQL Server connectivity.

## 🚀 Quick Deployment

### Option 1: Automated Deployment (Ubuntu/Debian)
```bash
git clone https://github.com/Rikucs/Notify.git
cd Notify
chmod +x deploy.sh
./deploy.sh
```

### Option 2: Docker Deployment
```bash
git clone https://github.com/Rikucs/Notify.git
cd Notify
cp .env.example .env
# Edit .env with your settings
docker-compose up -d
```

### Option 3: Manual Installation
See the comprehensive [HOSTING_GUIDE.md](HOSTING_GUIDE.md) for detailed instructions.

## 📋 Requirements

- **PHP 7.0+** with extensions: PDO, SQLSRV, LDAP, Zlib, MBString
- **Web Server**: Apache 2.4+ or Nginx 1.18+
- **Database**: Microsoft SQL Server
- **Authentication**: LDAP/Active Directory server

## 🏗️ Architecture

- **Frontend**: Bootstrap-based responsive UI
- **Backend**: PHP with session-based authentication
- **Database**: SQL Server with PDO connectivity
- **Authentication**: LDAP integration
- **Features**: Notification management, PDF generation, multiple modules

## 🔧 Configuration

1. **Database**: Update connection settings in `notify/config/config.php`
2. **LDAP**: Configure server in `login/Auth.php`
3. **Environment**: Copy `.env.example` to `.env` and customize

## 📚 Hosting Options

### Shared Hosting
- Requires Windows hosting or Linux with SQL Server support
- PHP with SQLSRV extensions
- Cost: $5-50/month

### Cloud Hosting
- **AWS**: EC2 + RDS for SQL Server
- **Azure**: App Service + Azure SQL Database
- **Google Cloud**: Compute Engine + Cloud SQL
- **DigitalOcean**: Droplets + managed databases

### VPS/Dedicated
- Full control over configuration
- Install required PHP extensions
- Suitable for enterprise deployment

## 🔒 Security Features

- LDAP/Active Directory authentication
- Session management
- SQL injection prevention (PDO)
- HTTPS support
- Security headers via .htaccess
- Environment variable configuration

## 📁 Project Structure

```
Notify/
├── index.php              # Login page
├── notify/                # Main notification module
├── login/                 # Authentication system
├── ExternalLinks/         # External links module
├── vendedores/           # Sales module  
├── ttcs/                 # TTCS module
├── assets/               # Static assets (CSS, JS, images)
├── docker/               # Docker configuration
├── HOSTING_GUIDE.md      # Comprehensive hosting guide
└── deploy.sh             # Automated deployment script
```

## 🚀 Getting Started

1. **Clone the repository**
2. **Configure your environment** (database, LDAP)
3. **Deploy using one of the methods above**
4. **Access your application** via web browser
5. **Login with LDAP credentials**

## 📖 Documentation

- [Complete Hosting Guide](HOSTING_GUIDE.md) - Detailed setup instructions
- [Environment Configuration](.env.example) - Configuration template
- [Docker Setup](docker-compose.yml) - Container deployment

## 🆘 Support

For hosting-specific questions:
1. Check the [HOSTING_GUIDE.md](HOSTING_GUIDE.md)
2. Review Apache/PHP error logs
3. Verify database and LDAP connectivity
4. Ensure all PHP extensions are installed

## 📝 License

This project includes third-party libraries:
- FPDF/FPDI for PDF generation
- Bootstrap for UI components

---

**Ready to host your notification system? Follow the [HOSTING_GUIDE.md](HOSTING_GUIDE.md) for step-by-step instructions!**