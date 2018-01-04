# Modus Vehicles API 

Modus Vehicles api to get list and counts of vehicles from NHTSA Api

## Requirements
* PHP >= 5.6.4

PHP 7.01 used in this assignment

## Installation
The system utilizes [Composer](https://getcomposer.org/download/) to manage its dependencies. So, before using the system, make sure you have `Composer` installed on your machine.

* Clone repository via git 
```
https://github.com/abdul-soft/modus-api
```
* Download vendors and Install 
```
composer install
```
* Start Server 
```
php -S localhost:8080 -t ./public
```

A secure connection is used while developing this app.

## API Documentation
http://localhost:8080/api/documentation

## Assignment Test

### Requirement 1

Can we visit the following Requirement 1 URLs and get meaningful JSON output from them:

* `GET http://localhost:8080/vehicles/2015/Audi/A3`
* `GET http://localhost:8080/vehicles/2015/Toyota/Yaris`
* `GET http://localhost:8080/vehicles/2015/Ford/Crown Victoria`
* `GET http://localhost:8080/vehicles/undefined/Ford/Fusion`

### Requirement 2

The Requirement 2 URL when sending each of the following JSON request bodies and get meaninful JSON output from each:

```
POST http://localhost:8080/vehicles
```

```
{
    "modelYear": 2015,
    "manufacturer": "Audi",
    "model": "A3"
}
```

```
{
    "modelYear": 2015,
    "manufacturer": "Toyota",
    "model": "Yaris"
}
```
```
{
    "manufacturer": "Honda",
    "model": "Accord"
}
```

### Requirement 3

Can we visit the following Requirement 2 URLs and get meaningful JSON output from them:

* `GET http://localhost:8080/vehicles/<MODEL YEAR>/<MANUFACTURER>/<MODEL>?withRating=true`
* `GET http://localhost:8080/vehicles/<MODEL YEAR>/<MANUFACTURER>/<MODEL>?withRating=false` (should return the same output as Requirement 1)
* `GET http://localhost:8080/vehicles/<MODEL YEAR>/<MANUFACTURER>/<MODEL>?withRating=bananas` (should return the same output as Requirement 1)
* `GET http://localhost:8080/vehicles/<MODEL YEAR>/<MANUFACTURER>/<MODEL>` (should return the same output as Requirement 1)
