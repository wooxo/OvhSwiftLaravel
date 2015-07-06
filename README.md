# OVHSwiftLaravel
Service provider to use OVH PCI Object Storage API. From work on : https://github.com/drauta/runabove-laravel.

Installation
------------

Install using composer:

```bash
composer require myjeux/OVHSwiftLaravel "dev-master"
```

add to config/app.php

```bash
'Myjeux\OVH\SwiftServiceProvider',
```

Add the following to the config/services.php
```bash
'ovh' => [
	'username' => 'yourUsername',
	'password' => 'yourPassword',	  
	'tenantId' => 'yourTeenantId',		
	'container'=> 'yourContainer',
],
```
Laravel
-------
This package provides an integration with OVH object container. 
