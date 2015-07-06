 <?php
     namespace Lflaszlo\OvhSwiftLaravel\Facades;
     use Illuminate\Support\Facades\Facade;

     /**
      * Facade of  OvhSwiftLaravel
      *
      * @package Lflaszlo\OvhSwiftLaravel\Facades
      */
     class OvhSwiftLaravel extends Facade {

         /**
          * Provide the name of the component
          * @return string
          */
         protected static function getFacadeAccessor()
         {
             return 'ovh-swift-laravel';
         }
     }