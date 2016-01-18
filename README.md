# OvhSwiftLaravel

[![Build Status](https://travis-ci.org/wooxo/OvhSwiftLaravel.svg?branch=master)](https://travis-ci.org/wooxo/OvhSwiftLaravel)
[![Latest Stable Version](https://poser.pugx.org/wooxo/ovh-swift-laravel/v/stable.png)](https://packagist.org/packages/wooxo/ovh-swift-laravel) [![Total Downloads](https://poser.pugx.org/wooxo/ovh-swift-laravel/downloads.png)](https://packagist.org/packages/wooxo/ovh-swift-laravel)

It's a library for Laravel 5.2.

Library to use OVH PCI Object Storage API with Laravel
Based on work from : https://github.com/drauta/runabove-laravel.

Installation
------------

Install using composer:
```bash
composer require wooxo/ovh-swift-laravel "~0.1"
```

Publish config and complete informations (use OVH API to get Credentials)
```bash
php artisan config:publish wooxo/ovh-swift-laravel
```

Add provider in config.app
```bash
'providers' = array(
    [...],
    'Wooxo\OvhSwiftLaravel\OvhSwiftLaravelServiceProvider'
);
```

Usage
------------

Get file list
```bash
$client = new OvhSwiftLaravel();
$client->fileList();
```

Upload a file
```bash
$client = new OvhSwiftLaravel();
$client->filePut('path/to/the/file');
```

Get an uploaded file
```bash
$client = new OvhSwiftLaravel();
$client->fileGet('hello_world.txt');
```

Delete an uploaded file
```bash
$client = new OvhSwiftLaravel();
$client->fileDelete('hello_world.txt');
```

Check if a file exists
```bash
$client = new OvhSwiftLaravel();
$client->fileExists('hello_world.txt');
```
