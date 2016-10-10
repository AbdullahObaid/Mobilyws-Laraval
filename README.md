# Description

A Laraval Package to send SMS using mobily.ws by using it's API and cURL.

## Table of Contents

- [Features](#features)
- [Installation](#installation)
- [Usage](#usage)
- [License](#License)
- [Essentials](#essentials)

## Features

* Supports Laravel 5.*
* Requires an active http://mobily.ws account 
* cURL 
* php >=5.3.0

## Installation

Install with composer by running  `composer require abdullahobaid/mobilywslaraval:dev-master`  
Composer will download and install the package. After the package is downloaded, 
open `app/config/app.php` and add the service provider and alias as below:

    'providers' => array(
        ...
        Abdullahobaid\Mobilywslaraval\MobilywsProvider::class,
    ),
    .
    .
    .
    'aliases' => array(
        ...
        'Mobily'    => Abdullahobaid\Mobilywslaraval\Mobily::class,
    ),


Publish the configuration file by running the following Artisan command.

```php
$ php artisan vendor:publish
```
Finally, you need to edit the configuration file at  `config/mobilysms.php` with your own mobily.ws account info
```php 
return [
	'sender'  =>'', // Mobily.ws Sender Name
	'mobile'  =>'', // Mobily.ws Account Mobile (Username)
	'password'=>'', // Mobily.ws Password
	'deleteKey'=>541235, 
	'resultType'=>1,
	'viewResult'=>1, 
	'MsgID'=>rand(00000,99999), 
];

```


## Usage
### Send SMS message directly
Will send the message directly to the number
```php 
Mobily::send(966555555555,'Your Message Here ');
```
Returns `true` if the message is sent, `false` if not.
### Send SMS message at a certain date/time
Will send the message in a desired date and time
```php 
Mobily::send(966555555555,'Your Message Here ',$date,$time);
```
Returns `true` if the message is sent, `false` if not.
##### note
* Date format `mm/dd/yyyy`
* Time format `hh:mm:ss`
### Check the current Balance
Will send the message in a desired date and time
```php 
Mobily::Balance();
```
Returns user's balance.
## License

Waqf General Public Licens

## Essentials
* [Laravel](https://laravel.com)
* [Mobily.ws API Refrence](https://www.mobily.ws/en/api-scripts.html)
* Follow me on Twitter [@mobde3](https://twitter.com/mobde3/)
* This repo was originally a Fork of [this package](https://github.com/arabnewscms/mobilysms).