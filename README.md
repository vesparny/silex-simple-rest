# Silex Simple REST [![Build Status](https://secure.travis-ci.org/vesparny/silex-simple-rest.png)](http://travis-ci.org/vesparny/silex-simple-rest)

A simple silex skeleton application for writing RESTful API. Developed and maintained by [Alessandro Arnodo](https://alessandro.arnodo.net).

Continuous Integration is provided by [Travis-CI](http://travis-ci.org/).

## Setup

Install as a project via composer:

    curl -s http://getcomposer.org/installer | php
    php composer.phar create-project vesparny/silex-simple-rest
    
or just download the tarball from github and install dependencies via composer:

    php composer.phar install

## Configuration

- Configure `RewriteBase /path/to/app` in `/web/.htaccess`
- Create a database (an example mysql database is provided in `/docs/` folder).
- Configure database access information in `/app/config/dev.json`.

## Features

Take a look to `/src/boot.php` to see how does it works.

Every files in the project follows [PSR-0 standards](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md).

In order to don't screw up autoloading it's important naming and declaring classes in `StudlyCaps`.

- Every route file place in `/app/Classes/Routes/` is automatically loaded. (an example Api.php Route class is provided)
- Same thing for file places in `/app/Classes/Business/`.
- `/app/config/default.json` is overwritten by any configuration you place in `/app/config/$env.json`.
- A logging file is created in `/app/logs/`, every day a new file is created (logging level is configurable).

## Run tests

phpunit is required for the tests, place your own in `/tests/` folder, following the namespace structure.

	phpunit

## Used packages

Refer to single package documentation for more accurate support.

	"silex/silex": "1.0.*",
    "symfony/browser-kit": "2.1.*",
    "symfony/css-selector": "2.1.*",
    "symfony/finder": "2.1.*",
    "symfony/process": "2.1.*",
    "monolog/monolog": "1.2.*",
    "symfony/validator": "2.1.*",
    "igorw/config-service-provider": "1.0",
	"doctrine/dbal": "2.2.*"

## Contributing

Fell free to contribute, fork, pull request, hack. Thanks!

## Author

####Alessandro Arnodo

+	[@vesparny](https://twitter.com/vesparny)

+	[http://alessandro.arnodo.net](http://alessandro.arnodo.net)

+	<mailto:alessandro@arnodo.net>

## License

see LICENSE file.