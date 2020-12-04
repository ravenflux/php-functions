# Twig PHP Functions / Filters

[![Latest Stable Version](https://poser.pugx.org/ravenflux/php-functions/v/stable)](https://packagist.org/packages/ravenflux/php-functions) 
[![Latest Unstable Version](https://poser.pugx.org/ravenflux/php-functions/v/unstable)](https://packagist.org/packages/ravenflux/php-functions) 
[![License](https://poser.pugx.org/ravenflux/php-functions/license)](https://packagist.org/packages/ravenflux/php-functions) 
[![Total Downloads](https://poser.pugx.org/ravenflux/php-functions/downloads)](https://packagist.org/packages/ravenflux/php-functions)

<p align="center">
  <img src="https://github.com/ravenflux/ravenflux/raw/master/ravenflux.jpg">
</p>

Twig extension that implements a way to use native PHP functions and filters in Twig template.

### [Medium article](https://medium.com/@k0d3r1s/use-php-functions-in-twig-templates-4caf6e8f5ba7)

Installation
------------
The recommended way to install is via Composer:
```shell
composer require ravenflux/php-functions
```
This package requires at least PHP 8.0.0

For Symfony usage add it as a service and tag it:
```yaml
# config/services.yaml
services:
    ravenflux.twig.extension.php_functions:
        class: RavenFlux\Php\PhpFunctionsExtension
        arguments:
            - #first argument are functions
                - 'count'
            - #second argument are filters
                - 'nl2br'
        tags:
            -
                name: twig.extension
```
or without any arguments if you want to use dynamic function / filters:
```yaml
# config/services.yaml
services:
    ravenflux.twig.extension.php_functions:
        class: RavenFlux\Php\PhpFunctionsExtension
        tags:
            -
                name: twig.extension
```

Function VS Filter | [source](https://stackoverflow.com/a/18867285/9743366)
------------
A **function** is used when you need to compute things to render the result.  
A **filter** is a way to transform the displayed data.  

Usage
------------

Functions:
```twig
{{ count(users) }}
```
Filters:
```twig
{{ user.name|nl2br }}
```
#### or dynamically any php function:
Functions:
```twig
{{ raven_function('count', users) }}
```
Filters:
```twig
{{ user.name|raven_filter('nl2br') }}
```
