# New Kalalake LGU Local Project

This project is a PHP-based web application for a local government unit (LGU) in New Kalalake. It appears to be a case management system for "Lupon" and "Office" entities.

## Technologies Used

*   **Backend:** PHP
*   **Database:** MySQL
*   **Web Server:** Apache (inferred from `.htaccess`)
*   **Frontend:** HTML, CSS, and likely some JavaScript (though not explicitly seen yet).

## Project Structure

The project follows a Model-View-Controller (MVC) like pattern:

*   `backend/`: Contains the business logic.
    *   `controllers/`: Handles user requests.
    *   `models/`: Interacts with the database.
    *   `helpers/`: Utility functions.
    *   `config/`: Database configuration.
*   `client/`: Contains the view files and frontend logic.
    *   `lupon/`: Views for the Lupon department.
    *   `office/`: Views for the Office department.
*   `public/`: The web server's document root.
    *   `api.php`: Handles API requests.
    *   `login.php`: The login page.
    *   `assets/`: CSS, images, and fonts.
*   `.env`: Environment variables (database credentials, etc.).
*   `index.php`: The main entry point of the application.

## Setup

1.  **Prerequisites:**
    *   A web server with PHP (like XAMPP or WAMP).
    *   MySQL database.

2.  **Installation:**
    *   Clone this repository into your web server's document root (e.g., `htdocs` for XAMPP).
    *   Create a MySQL database.
    *   Create a `.env` file in the project root by copying `.env.example` (if it exists) or by creating it manually.
    *   Update the `.env` file with your database credentials:
        ```
        DB_HOST=localhost
        DB_NAME=your_database_name
        DB_USER=your_database_user
        DB_PASS=your_database_password
        ```
    *   Access the project through your web browser (e.g., `http://localhost/newkalalake.lgu.local`).

## How it Works

*   The application is bootstrapped through `backend/bootstrap.php`.
*   It uses a custom autoloader for backend classes.
*   Database connections are handled by a `Connection` class using PDO.
*   The `client/views.php` file likely handles rendering the different views.
