# Simple PHP Content Management System (CMS)

## Overview
The Simple PHP CMS is a lightweight, user-friendly content management system built with PHP and SQLite. It provides basic social networking features, allowing users to register, log in, add friends, create posts (with optional images), and comment on posts. The project is designed for simplicity and ease of use, making it an excellent starting point for developers learning PHP or building small-scale social platforms.

### Purpose
The goal of this project is to create a minimal CMS with core social features, demonstrating:
- User authentication (login/register) using secure password hashing.
- Social interactions (friend connections, posts, and comments).
- File uploads for post images.
- A responsive, modern user interface with a sleek design.

This project serves as an educational tool, a prototype for larger applications, or a foundation for custom CMS solutions.

### Features
- **User Authentication**: Secure registration and login with password hashing.
- **Friend System**: Users can add friends by username, enabling a social feed of posts.
- **Posts**: Users can create text posts with optional image uploads, displayed in a feed.
- **Comments**: Users can comment on posts, with comments displayed below each post.
- **Responsive Design**: A modern, professional UI with a clean layout, optimized for desktop and mobile.
- **SQLite Database**: Lightweight, file-based database for easy setup and portability.

## How It Works
The CMS follows a straightforward workflow:
1. **User Authentication**:
   - Users register via `register.php` with a username, email, and password (hashed using `password_hash()`).
   - Login is handled via `login.php`, with sessions managing user state.
2. **Dashboard**:
   - After logging in, users are redirected to `dashboard.php`, which shows a feed of their posts and friends' posts.
3. **Friends**:
   - Users can add friends via `add_friend.php` by searching for usernames.
   - Friend relationships are stored in a `friends` table, enabling a social feed.
4. **Posts**:
   - Users create posts (text and optional images) via `post.php`.
   - Images are uploaded to the `uploads` directory with unique filenames generated using `ramsey/uuid`.
5. **Comments**:
   - Users can view and add comments to posts via `comments.php`.
6. **Routing**:
   - `index.php` redirects unauthenticated users to `login.php` and authenticated users to `dashboard.php`.
   - Clean URLs are supported via `.htaccess` (Apache only).

The application uses SQLite for data storage, PDO for secure database interactions, and a modern CSS design for a sleek user experience.

## Project Directory Structure
```
PHP_CMS/
├── assets/
│   ├── css/
│   │   └── style.css           # Modern, responsive CSS styles
│   └── js/
│       └── script.js           # Placeholder for client-side JavaScript
├── database/
│   └── cms.db                  # SQLite database file (created automatically)
├── includes/
│   ├── functions.php           # Core PHP functions for authentication, posts, etc.
│   ├── header.php              # Common header template with navigation
│   └── footer.php              # Common footer template
├── pages/
│   ├── add_friend.php          # Page to add friends by username
│   ├── comments.php            # Page to view/add comments on posts
│   ├── dashboard.php           # User dashboard with post feed
│   ├── login.php               # Login page
│   ├── logout.php              # Logout script
│   ├── post.php                # Page to create/view posts
│   └── register.php            # Registration page
├── uploads/
│   └── (image files)           # Directory for uploaded post images
├── .env                        # Environment variables (e.g., DB_PATH)
├── .htaccess                   # Apache URL rewriting rules
├── composer.json               # Composer dependencies and autoloading
├── config.php                  # Database and environment configuration
└── index.php                   # Main entry point
```

## Prerequisites
- **PHP**: Version 7.4 or higher with `pdo_sqlite` extension enabled.
- **Composer**: For managing dependencies (`vlucas/phpdotenv`, `ramsey/uuid`).
- **Web Server**: Apache (with `mod_rewrite` for `.htaccess`) or PHP’s built-in server. Nginx is also supported with manual configuration.
- **Browser**: Any modern browser (Chrome, Firefox, Edge, etc.).

## Setup Instructions

### 1. Clone or Download the Project
- Place the project files in your web server’s root directory (e.g., `C:\xampp\htdocs\PHP_CMS` for XAMPP or `F:\PHP_CMS`).

### 2. Install Dependencies
- Install Composer if not already installed: [getcomposer.org](https://getcomposer.org/).
- Run the following command in the project root:
  ```bash
  composer install
  ```
- This installs `vlucas/phpdotenv` (for environment variables) and `ramsey/uuid` (for unique file names).

### 3. Create the `.env` File
- Create a `.env` file in the project root with:
  ```env
  DB_PATH=F:/PHP_CMS/database/cms.db
  ```
- Use forward slashes (`/`) in the path, even on Windows.

### 4. Set Up Directories
- Create the `database` and `uploads` directories:
  ```bash
  mkdir F:\PHP_CMS\database
  mkdir F:\PHP_CMS\uploads
  ```
- Grant write permissions:
  ```bash
  icacls F:\PHP_CMS\database /grant Everyone:(M)
  icacls F:\PHP_CMS\uploads /grant Everyone:(M)
  ```

### 5. Configure the Web Server
- **Apache (e.g., XAMPP)**:
  - Ensure `mod_rewrite` is enabled in `C:\xampp\apache\conf\httpd.conf`:
    ```apache
    LoadModule rewrite_module modules/mod_rewrite.so
    ```
  - Set `AllowOverride All` in the `<Directory>` block for your project:
    ```apache
    <Directory "F:/Coding_Projects/PHP_CMS">
        AllowOverride All
        Require all granted
    </Directory>
    ```
  - Restart Apache via the XAMPP Control Panel.
- **PHP Built-in Server**:
  - Run from the project root:
    ```bash
    cd F:\PHP_CMS
    php -S localhost:8000
    ```
  - Note: `.htaccess` is ignored with the built-in server.
- **Nginx**:
  - Configure a server block (e.g., in `/etc/nginx/sites-available/your_project`):
    ```nginx
    server {
        listen 80;
        server_name localhost;
        root /path/to/PHP_CMS;
        index index.php;
        location / {
            try_files $uri $uri/ /index.php?$args;
        }
        location ~ \.php$ {
            include fastcgi_params;
            fastcgi_pass 127.0.0.1:9000; # Adjust for your PHP-FPM setup
            fastcgi_index index.php;
            fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        }
        location ~* \.(css|js|jpg|png|gif|jpeg)$ {
            try_files $uri =404;
        }
    }
    ```
  - Restart Nginx: `sudo service nginx restart`.

### 6. Enable PHP Extensions
- Ensure the `pdo_sqlite` extension is enabled in `php.ini` (e.g., `C:\xampp\php\php.ini`):
  ```ini
  extension=pdo_sqlite
  ```
- Restart the web server after editing `php.ini`.

### 7. Access the Application
- Open `http://localhost/PHP_CMS` (Apache/XAMPP) or `http://localhost:8000` (PHP built-in server).
- Register a user, log in, and test features (add friends, create posts, comment).

## Troubleshooting
- **CSS Not Loading**:
  - Verify the `<link>` tag in `includes/header.php` uses the correct path: `<link rel="stylesheet" href="/PHP_CMS/assets/css/style.css">` (Apache) or `<link rel="stylesheet" href="/assets/css/style.css">` (PHP built-in server).
  - Check browser Developer Tools (F12 > Network) for 404/403 errors on `style.css`.
  - Ensure `assets/css/style.css` exists and is readable:
    ```bash
    icacls F:\PHP_CMS\assets\css /grant Everyone:(R)
    ```
- **Database Errors**:
  - If you see "could not find driver," ensure `pdo_sqlite` is enabled in `php.ini`.
  - Verify `database/cms.db` exists and is writable.
- **Error Logs**:
  - Check Apache logs (`C:\xampp\apache\logs\error.log`) or PHP logs (`C:\xampp\php\logs\php_error_log`).
  - For PHP’s built-in server, check terminal output.

## Security Considerations
- **Password Hashing**: Uses `password_hash()` for secure password storage.
- **SQL Injection**: Prevented using PDO prepared statements.
- **File Uploads**: Basic validation for image uploads; consider adding stricter checks (e.g., file size, MIME type).
- **CSRF Protection**: Not implemented; add CSRF tokens for production use.
- **HTTPS**: Use HTTPS in production to secure data transmission.

## Future Enhancements
- Add CSRF tokens to forms for enhanced security.
- Implement user profile pages and post deletion.
- Add pagination for the post feed.
- Enhance file upload validation (e.g., size limits, file type checks).
- Integrate a frontend framework (e.g., Bootstrap or Tailwind CSS) for advanced styling.

## Dependencies
- **PHP Packages** (via Composer):
  - `vlucas/phpdotenv`: Manages environment variables.
  - `ramsey/uuid`: Generates unique IDs for uploaded files.
- **External Fonts** (optional):
  - Google Fonts (`Inter`) included in `header.php` for typography.

## License
This project is open-source and licensed under the [MIT License](LICENSE).

## Contributing
Contributions are welcome! Please submit issues or pull requests via the project repository

## Contact
For questions or support, contact the project maintainer at abbasali1214313@gmail.com or open an issue in the repository.