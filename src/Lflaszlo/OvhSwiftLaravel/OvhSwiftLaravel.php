<?php
namespace Lflaszlo\OvhSwiftLaravel;
use OpenCloud\OpenStack;
use Guzzle\Http\Exception\BadResponseException;
use Illuminate\Support\Facades\Config;


class OvhSwiftLaravel {
    private $url = 'https://auth.cloud.ovh.net/v2.0';
    private $client;
    private $service;
    private $container;

    public function __construct(){
        $this->client = new OpenStack($this->url, array(
            'username' => Config::get('ovh-swift-laravel::config.username'),
            'password' => Config::get('ovh-swift-laravel::config.password'),
            'tenantId' => Config::get('ovh-swift-laravel::config.tenantId'),
        ));
        $this->service = $this->client->objectStoreService('swift', 'SBG1', 'publicURL');
        $this->container = $this->service->getContainer(Config::get('ovh-swift-laravel::config.container'));
    }

    public function fileGet($filename)
    {
        $object = $this->container->getObject($filename);
        return $object->getContent();
    }

    public function filePut($file, $filename = null){

        $getPath = null;
        $isString = is_string($file);

        if($isString){
            $getPath = $file;

        }else{
            $getPath = $file->getRealPath();
        }

        if($filename == null){
            if($isString){
                $explodePath = explode("/", $file);
                $filename = $explodePath[count($explodePath)-1];
            }else{
                $filename = $file->getClientOriginalName();
            }
        }

        $this->container->uploadObject($filename, fopen($getPath, 'r'));
    }

    public function fileExists($filename){
        foreach($this->container->objectList() as $obj){
            if($obj->getName() == $filename){
                return true;
            }
        }
        return false;
    }

    public function fileList(){
        return $this->container->objectList();
    }

    public function fileDelete($filename){
        $object = $this->container->getObject($filename);
        return $object->delete();
    }
}