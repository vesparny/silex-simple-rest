# Silex Simple REST
[![Latest Stable Version](https://poser.pugx.org/vesparny/silex-simple-rest/v/stable.png)](https://packagist.org/packages/nesbot/carbon) [![Total Downloads](https://poser.pugx.org/vesparny/silex-simple-rest/downloads.png)](https://packagist.org/packages/nesbot/carbon) [![Build Status](https://secure.travis-ci.org/vesparny/silex-simple-rest.png)](http://travis-ci.org/vesparny/silex-simple-rest)[![Dependencies Status](https://depending.in/vesparny/silex-simple-rest.png)](http://depending.in/vesparny/silex-simple-rest)

A simple silex skeleton application for writing RESTful API. Developed and maintained by [Alessandro Arnodo](http://alessandro.arnodo.net).

**This project wants to be a starting point to writing scalable and maintainable REST api in with Silex micro-framework**

Continuous Integration is provided by [Travis-CI](http://travis-ci.org/).


####How do I run it?
From this folder run the following commands to install the php and bower dependencies, import some data, and run a local php server.

You need at least php **5.4.*** with **SQLite extension** enabled and **Composer**
    
    composer install 
    sqlite3 app.db < resources/sql/schema.sql
    php -S 0:9001 -t web/
    
Your api is now available at http://localhost:9001/api/v1.

The requests will be proxied to this url from the connect middleware.

####Run tests
Some tests were written, and all CRUD operations are fully tested :)

From the root folder run the following command to run tests.
    
    vendor/bin/phpunit 


####How does it work
The api will respond to

	GET  ->   http://localhost:9001/api/v1/notes
	POST ->   http://localhost:9001/api/v1/notes/{id}
	POST ->   http://localhost:9001/api/v1/notes
	DELETE -> http://localhost:9001/api/v1/notes/{id}
	
Take a look at the source code, it's self explanatory :)

Under the resource folder you can find a .htaccess file to put the api in production.

####Contributing

Fell free to contribute, fork, pull request, hack. Thanks!

####Author


+	[@vesparny](https://twitter.com/vesparny)

+	[http://alessandro.arnodo.net](http://alessandro.arnodo.net)

+	<mailto:alessandro@arnodo.net>

## License

see LICENSE file.






