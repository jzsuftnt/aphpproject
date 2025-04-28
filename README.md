# PHP Project

A basic PHP project with MVC structure.

## Project Structure

```
├── public/              # Public-facing files
│   ├── index.php        # Entry point
│   ├── .htaccess        # URL rewriting rules
│   ├── css/             # CSS files
│   ├── js/              # JavaScript files
│   └── images/          # Image assets
├── src/                 # Application code
│   ├── controllers/     # Controller classes
│   ├── models/          # Model classes
│   └── views/           # View templates
└── composer.json        # Dependency management
```

## Setup Instructions

1. Make sure you have PHP 7.4 or higher installed
2. Install Composer (https://getcomposer.org/)
3. Run `composer install` to install dependencies
4. Configure your web server to point to the `public` directory
5. For development, you can use PHP's built-in server:
   ```
   php -S localhost:8000 -t public
   ```

## Usage

- The application follows a simple MVC pattern
- Add controllers in the `src/controllers` directory
- Add models in the `src/models` directory
- Add views in the `src/views` directory
- All public assets should go in the `public` directory