# FUT Champions Ultimate Team Dashboard

A dynamic admin dashboard for managing FUT Champions Ultimate Team data, built with PHP and MySQLi.

## Features

- Complete CRUD operations for players, teams, and nationalities
- Interactive charts using Chart.js
- Multi-language support (English, French, Spanish)
- Responsive design using Bootstrap
- Secure authentication system
- AJAX-powered dynamic updates
- Data visualization of key statistics

## Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web server (Apache/Nginx)
- Modern web browser with JavaScript enabled

## Installation

1. Clone the repository to your web server directory:
   ```bash
   git clone git@github.com:protocol-404/FUT-champion_full_stack.git fut_champions_dashboard
   ```

2. Import the database structure:
   ```bash
   mysql -u your_username -p < database/init.sql
   ```

3. Configure the database connection:
   - Open `config/database.php`
   - Update the following constants with your database credentials:
     ```php
     define('DB_HOST', 'localhost');
     define('DB_USER', 'your_username');
     define('DB_PASS', 'your_password');
     define('DB_NAME', 'fut_champions');
     ```

4. Set up proper permissions:
   ```bash
   chmod 755 -R fut_champions_dashboard
   chmod 777 -R fut_champions_dashboard/logs
   ```

5. Access the dashboard through your web browser:
   ```
   http://your-domain.com/fut_champions_dashboard
   ```

## Security Considerations

- All user inputs are sanitized to prevent SQL injection
- Passwords are hashed using PHP's password_hash()
- CSRF protection is implemented for forms
- XSS prevention through proper output escaping
- Prepared statements for database queries

## Directory Structure

```
fut_champions_dashboard/
├── api/                   # API endpoints
├── assets/                # CSS, JS, and media files
├── config/                # Configuration files
├── database/              # Database scripts
├── includes/              # PHP includes
├── lang/                  # Language files
├── logs/                  # Error logs
└── README.md              # This file
```

## Contributing

1. Fork the repository
2. Create your feature branch
3. Commit your changes
4. Push to the branch
5. Create a new Pull Request

## License

This project is licensed under the MIT License - see the LICENSE file for details.
The full license text is available in the LICENSE file.
