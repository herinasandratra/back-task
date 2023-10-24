# PHP-fullstack application back-end 

This repository contains test php-fullstack without any framework. 
But it may contain some libraries for example firebase authentication if I can deliver it.


## Disclaimer

Watch out, this project is meant to show how to build an application from scratch.

Improvements and pull requests are welcome.

## Environments

Change as your environment configuration : db mysql connection configuration the following file:
[src/SuperBlog/Persistence/DbConf.php](/src/SuperBlog/Persistence/DbConf.php)

## Run

To run this test, you need to clone it and install dependencies:

```
composer install
```

You can then run the web application using PHP's built-in server:

```
php -S 0.0.0.0:8000 -t web/
```

The web application is running at [http://localhost:8000](http://localhost:8000/).

