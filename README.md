# Laravel Password Manager

This is a Laravel-based password manager application that allows users to securely store and manage their passwords using cli commands.

## Features

- User authentication and registration
- Create, edit, and delete password records
- View all password records
- View password details
- Search for password records
- Secure storage of passwords
- Command-line interface for managing passwords


## Requirements

- PHP 8.2 or higher
- Composer
- Node.js and npm

## Installation

1. Clone the repository:
    ```sh
    git clone https://github.com/Volodymyr0587/laravel-console-app-passwords-manager
    cd laravel-console-app-passwords-manager
    ```

2. Install PHP dependencies:
    ```sh
    composer install
    ```

3. Install JavaScript dependencies:
    ```sh
    npm install
    ```

4. Copy the example environment file and configure the environment variables:
    ```sh
    cp .env.example .env
    ```

5. Generate the application key:
    ```sh
    php artisan key:generate
    ```

6. Run the database migrations:
    ```sh
    php artisan migrate
    ```
7. Register a new user:
    ```sh
    php artisan user:register
    ```
8. Authenticate a user:
    ```sh
    php artisan user:login
    ```

## Usage

### Command-Line Interface

- Get help:
    ```sh
    php artisan password:help
    ```
- Register a new user:
    ```sh
    php artisan user:register
    ```
- Authenticate a user:
    ```sh
    php artisan user:login
    ```
- Logout a user:
    ```sh
    php artisan user:logout
    ```

- Create a new password record:
    ```sh
    php artisan password:create
    ```

- Edit an existing password record:
    ```sh
    php artisan password:edit
    ```

- List all password records:
    ```sh
    php artisan password:list
    ```

- Search password record:
    ```sh
    php artisan password:search
    ```

## Contributing

Contributions are welcome! Please open an issue or submit a pull request.

## License

This project is licensed under the MIT License. See the LICENSE file for details.
