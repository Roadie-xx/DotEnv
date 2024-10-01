# DotEnv
Just another (simple) DotEnv project

Loads environment variables from .env file to getenv(), $_ENV and $_SERVER.

## Usage

Now we create a file named .env
```shell
APP_ENV=dev
DATABASE_DNS=mysql:host=localhost;dbname=test;
DATABASE_USER=root
DATABASE_PASSWORD=root
```

```php
<?php
use RoadieXX\DotEnv;

(new DotEnv(dirname(__DIR__) . '/.env'))->load();

echo getenv('APP_ENV');
// dev
echo getenv('DATABASE_DNS');
// mysql:host=localhost;dbname=test;
```

## Installation

To install PHP-DotEnv, you can use [Composer](https://getcomposer.org/), the dependency manager for PHP.

### Composer Require
```bash
composer require roadie-xx/dotenv
```

### Run tests
```bash
docker run -ti -v LOCAL_PROJECT_DIR:/var/www/composer ghcr.io/devgine/composer-php:latest sh
# For  example
docker run -ti -v ${pwd}:/var/www/composer ghcr.io/devgine/composer-php:v2-php7.4-alpine sh

# Updrade global packages in docker
    composer global upgrade

# Install packages
    composer install

# Available tests in this docker (@see https://github.com/devgine/composer-php) 
    # PHP Copy Past Detector
    phpcpd ./src

    # PHP Coding Standards Fixer
    php-cs-fixer check -v ./src

    # PHPStan
    phpstan analyze --level=9 ./src

    # PHP Unit
    simple-phpunit --bootstrap=vendor/autoload.php ./tests
    simple-phpunit --coverage-text --whitelist=./src  --bootstrap=vendor/autoload.php ./tests

    # Rector
    rector #first run will create rector.php in root as config file
    ## To see preview of suggested changed
    rector process --dry-run
    ## To make changes happen
    rector process
```

## Requirements
* PHP version 7.4 or higher

## Todo
* Tests!

## Contributing
Feel free to fork and send me pull requests, I try and keep the tool really basic, if you want to start adding tons of features, I'd recommend creating your own project.

## Inspiration
I basically started copying [php-dotenv](https://github.com/phpdevcommunity/php-dotenv) and start updating from there. Why ? Because I wanted to learn how to create my _"own"_ packages and include them in another project.

## Copyright
[php-dotenv](https://github.com/phpdevcommunity/php-dotenv) is copyright [F.R Michel](https://dev.to/fadymr/php-create-your-own-php-dotenv-3k2i). Everything I haven't copied from anyone else is Copyleft (&#127279;) 2024.

## Issues
Please report issues to [Github Issue Tracker](https://github.com/Roadie-xx/DotEnv/issues).

