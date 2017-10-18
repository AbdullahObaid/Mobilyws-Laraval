# Description

A Laraval Package to send SMS using mobily.ws by using it's API and cURL. It uses UTF-8 endconding for the SMS.

## Table of Contents

- [Features](#features)
- [Installation](#installation)
- [Usage](#usage)
- [License](#License)
- [Essentials](#essentials)

## Features

* Supports Laravel 5.*
* Supports sending messages directly
* Supports sending messages at a certain date/time
* Supports sending messages to multiple numbers at once
* `new` Supports any number format see [Usage](#usage)
* Requires an active http://mobily.ws account 
* cURL 
* php >=5.3.0

## Installation

Install with composer by running  `composer require abdullahobaid/mobilywslaraval:dev-master`  
Composer will download and install the package. After the package is downloaded, 
open `config/app.php` and add the service provider and alias as below:

    'providers' => array(
        ...
        abdullahobaid\mobilywslaraval\MobilywsProvider::class,
    ),
    .
    .
    .
    'aliases' => array(
        ...
        'Mobily'    => abdullahobaid\mobilywslaraval\Mobily::class,
    ),


Publish the configuration file by running the following Artisan command.

```php
$ php artisan vendor:publish --provider="abdullahobaid\mobilywslaraval\MobilywsProvider"
```
Finally, you need to edit the configuration file at  `config/mobilysms.php` with your own mobily.ws account info
```php 
return [
    'sender'     => '', // Mobily.ws Sender Name
    'mobile'     => '', // Mobily.ws Account Mobile (Username)
    'password'   => '', // Mobily.ws Password
    'deleteKey'  => 541235, 
    'resultType' => 1,
    'viewResult' => 1, 
    'MsgID'      => rand(00000,99999), 
];

```


## Usage

### Use any number format
Mobily.ws requires the number to be formated as international number without trailing zeros, but this Package can handle differnt number formats.

You can pass a single number or array of numbers, see examples below:

* The number can be sent with trailing zeros 00966555555555 
* With trailing plus sign +966555555555 
* International number without trailing zeros 966555555555 
* Even you can use the mobile number without international code - for Saudi Mobile Numbers Only - 0555555555 , the package will take care of formatting the number.
### Send SMS message directly
Will send the message directly to the number
```php 
Mobily::send(966555555555, 'Your Message Here');
```
Returns `true` if the message is sent, `false` if not.
### Send SMS to Multiple Numbers
Pass an array of numbers instead of a single number to send to all of them
```php 
$numbers = array('966555555555','966545555555','966565555555');
Mobily::send($numbers, 'Your Message Here');
```
Returns `true` if the message is sent, `false` if not.
### Send SMS message at a certain date/time
Will send the message in a desired date and time
```php 
Mobily::send(966555555555, 'Your Message Here', $date, $time);
```
##### note
* Date format `mm/dd/yyyy`
* Time format `hh:mm:ss`
* Returns `true` if the message is sent, `false` if not.


### Check the current Balance
```php 
Mobily::Balance();
```
Returns user's balance.

### Get number of SMS messages a text requires

```php 
Mobily::count_messages($text);
```

### Override default sender name

```php 
Mobily::send(966555555555, 'Your Message Here', $date=0, $time=0,'Sender Name');
```
Note that the new sender should be registered and activate at mobily.ws website


## License

Waqf General Public Licens

## Essentials
* [Laravel](https://laravel.com)
* [Mobily.ws API Refrence](https://www.mobily.ws/en/api-scripts.html)
* Follow me on Twitter [@mobde3](https://twitter.com/mobde3/)
