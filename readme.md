# CredPal

A full blown SPA built with Vue.js and Laravel for the CREDPAL online assessment

## Getting Started

-   Clone or download this repo
-   Run composer install
-   Edit .env to you database credentials
-   Serve the application

### Prerequisites

Install the following

```
Composer
 Node

```

### Installing

```
# Install Dependencies
composer install

# Run Migrations
php artisan migrate

# Import values
php artisan db:seed

# If you get an error about an encryption key
php artisan key:generate

# Passport
php artisan passport:install

# Clear cache
php artisan cache:clear

# Clear config
php artisan config:cache


# Install JS Dependencies
npm install

# Watch Files
npm run watch -- in development
npm run prod -- in production

# Serve application
php artisan serve

# Run cron job
## Please run this command below every minute using laravel scheduler or manually running the command everytime to simulate future transfer
php artisan transfer:cron
```

### Default users

Kindly find below the default admin and user account

```
Admin: (email: 'admin@credpal.com', password:'credpal')
User: (email: 'user@credpal.com', password:'credpal')

```

## Built With

-   [Laravel](https://laravel.com/) - The web framework used
-   [VueJs](https://vuejs.org/) - Used for front end functionality
-   [Bootstrap](https://getbootstrap.com/) - Used for the UI

## Versioning

We use [SemVer](http://semver.org/) for versioning. Current version is 1.0.0

## Authors

-   **Nwachukwu Chibuike** - [Website](https://chibuikenwa.com)

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE) file for details
