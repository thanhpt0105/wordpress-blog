# WordPress Personal Blog README

## Overview
This project is a fully functional WordPress personal blog with a custom theme and plugin. It includes full CRUD (Create, Read, Update, Delete) functionality for managing blog posts and pages. The blog is designed to be hosted on GoDaddy and is compatible with their hosting environment.

## Project Structure
The project is organized as follows:

```
wordpress-blog
├── wp-content
│   ├── themes
│   │   └── my-custom-theme
│   │       ├── style.css
│   │       ├── functions.php
│   │       ├── index.php
│   │       ├── header.php
│   │       ├── footer.php
│   │       ├── single.php
│   │       ├── page.php
│   │       └── archive.php
│   ├── plugins
│   │   └── my-custom-plugin
│   │       ├── my-custom-plugin.php
│   │       ├── uninstall.php
│   │       └── README.md
├── .htaccess
├── wp-config.php
├── README.md
└── index.php
```

## Requirements
- A GoDaddy hosting account with WordPress support.
- PHP version 7.4 or higher.
- MySQL version 5.6 or higher.

## Setup Instructions

1. **Download WordPress:**
   - Download the latest version of WordPress from [wordpress.org](https://wordpress.org/download/).

2. **Upload Files:**
   - Upload the contents of the `wordpress-blog` directory to your GoDaddy hosting account using an FTP client.

3. **Create a Database:**
   - Log in to your GoDaddy account and create a new MySQL database.
   - Note down the database name, username, and password.

4. **Configure wp-config.php:**
   - Open the `wp-config.php` file in the root directory.
   - Update the following lines with your database details:
     ```php
     define('DB_NAME', 'database_name_here');
     define('DB_USER', 'username_here');
     define('DB_PASSWORD', 'password_here');
     ```

5. **Set Up .htaccess:**
   - Ensure that the `.htaccess` file is present in the root directory. This file is crucial for URL rewriting.

6. **Install WordPress:**
   - Navigate to your domain in a web browser. You should see the WordPress installation page.
   - Follow the on-screen instructions to complete the installation.

7. **Activate the Custom Theme:**
   - Log in to your WordPress admin dashboard.
   - Go to Appearance > Themes and activate the "My Custom Theme".

8. **Activate the Custom Plugin:**
   - Go to Plugins > Installed Plugins and activate "My Custom Plugin".

## Deployment Steps
- After completing the setup, you can start creating blog posts and pages using the WordPress admin dashboard.
- Use the custom plugin to add any additional functionality as needed.

## Troubleshooting Tips
- If you encounter any issues during installation, ensure that your PHP and MySQL versions meet the requirements.
- Check file permissions to ensure that WordPress can read and write files as needed.
- Review the server error logs for any specific error messages.

## Conclusion
This README provides a comprehensive guide to setting up and deploying your WordPress personal blog on GoDaddy hosting. Enjoy blogging!