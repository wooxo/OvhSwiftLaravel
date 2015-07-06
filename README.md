# OVHSwiftLaravel

Library to use OVH PCI Object Storage API with Laravel
Based on work from : https://github.com/drauta/runabove-laravel.

Installation
------------

Install using composer:
```bash
composer require lflaszlo/ovh-swift-laravel "0.1.*"
```

Publish config and complete informations (use OVH API to get Credentials)
```bash
php artisan config:publish lflaszlo/ovh-swift-laravel
```

Add provider in config.app
```bash
'providers' = array(
    [...],
    'Lflaszlo\OvhSwiftLaravel\OvhSwiftLaravelServiceProvider'
);
```

Add alias in config.app
```bash
'aliases' = array(
    [...],
    'OvhSwiftLaravel' => 'Lflaszlo\OvhSwiftLaravel\Facades\OvhSwiftLaravel'
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

Get content of an uploaded file
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