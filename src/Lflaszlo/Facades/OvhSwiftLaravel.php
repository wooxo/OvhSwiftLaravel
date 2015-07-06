 <?php
     namespace Lflaszlo\OvhSwiftLaravel\Facades;
     use Illuminate\Support\Facades\Facade;

     class OvhSwiftLaravel extends Facade {
         protected static function getFacadeAccessor()
         {
             return 'ovh-swift-laravel';
         }
     }