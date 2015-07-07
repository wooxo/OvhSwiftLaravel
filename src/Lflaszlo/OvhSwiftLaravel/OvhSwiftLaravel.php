<?php
namespace Lflaszlo\OvhSwiftLaravel;
use OpenCloud\OpenStack;
use Guzzle\Http\Exception\BadResponseException;
use Illuminate\Support\Facades\Config;

/**
 * Library OvhSwiftLaravel
 *
 * @package Lflaszlo\OvhSwiftLaravel
 */
class OvhSwiftLaravel {
    /**
     * URL of OVH PCI Endpoint
     * @var string
     */
    private $url = 'https://auth.cloud.ovh.net/v2.0';

    /**
     * OpenStack Connection Entity
     * @var OpenStack
     */
    private $client;

    /**
     * Object Storage Entity
     * @var \OpenCloud\ObjectStore\Service
     */
    private $service;

    /**
     * Container Entity
     * @var \OpenCloud\ObjectStore\Resource\Container
     */
    private $container;

    /**
     * Constructor
     */
    public function __construct(){
        $this->client = new OpenStack($this->url, array(
            'username' => Config::get('ovh-swift-laravel::config.username'),
            'password' => Config::get('ovh-swift-laravel::config.password'),
            'tenantId' => Config::get('ovh-swift-laravel::config.tenantId'),
        ));
        $this->service = $this->client->objectStoreService('swift', Config::get('ovh-swift-laravel::config.region'), 'publicURL');
        $this->container = $this->service->getContainer(Config::get('ovh-swift-laravel::config.container'));
    }

    /**
     * Get the content of a file
     * @param $filename
     * @return \Guzzle\Http\EntityBody
     */
    public function fileGet($filename)
    {
        $object = $this->container->getObject($filename);
        return $object->getContent();
    }

    /**
     * Upload a new file
     * @param $file
     * @param string $filename
     *
     * @return \OpenCloud\ObjectStore\Resource\DataObject
     */
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

        return $this->container->uploadObject($filename, fopen($getPath, 'r'));
    }

    /**
     * Test the file existence
     * @param string $filename
     *
     * @return bool
     */
    public function fileExists($filename){
        foreach($this->container->objectList() as $obj){
            if($obj->getName() == $filename){
                return true;
            }
        }
        return false;
    }

    /**
     * Get file list
     * @return \OpenCloud\Common\Collection
     */
    public function fileList(){
        return $this->container->objectList();
    }

    /**
     * Delete a file
     * @param string $filename
     * @return bool
     */
    public function fileDelete($filename){
        $object = $this->container->getObject($filename);
        return $object->delete();
    }
}