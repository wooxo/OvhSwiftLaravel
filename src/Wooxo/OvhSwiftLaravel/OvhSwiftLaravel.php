<?php
namespace Wooxo\OvhSwiftLaravel;
use OpenStack\OpenStack;
use GuzzleHttp\Psr7\Stream;
use Guzzle\Http\Exception\BadResponseException;
use Illuminate\Support\Facades\Config;

/**
 * Library OvhSwiftLaravel
 *
 * @package Wooxo\OvhSwiftLaravel
 */
class OvhSwiftLaravel {
    /**
     * URL of OVH PCI Endpoint
     * @var string
     */
    private $url = 'https://auth.cloud.ovh.net/v3/';

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
                $params = [
            'authUrl' => $this->url,
            'region'  => Config::get('ovh-swift-laravel::config.region'),
            'user'    => [
                'name' => Config::get('ovh-swift-laravel::config.username'),
                'domain'   => [ 'id' => Config::get('ovh-swift-laravel::config.domainId') ],
                'password' => Config::get('ovh-swift-laravel::config.password'),
            ]
        ];
        //Cache file path        
        $cacheFile = storage_path() . '/.opencloud_token';
        //de basse on part en password
        $params['methods'] = ['password'];
        //Si le token existe 
        if(file_exists($cacheFile)) {
            $token = json_decode(file_get_contents($cacheFile));
            //on verifie s'il est expiré ou pas
            if ((new \DateTimeImmutable($token->expires->date)) > (new \DateTimeImmutable('now'))) {
                $params['tokenId'] = $token->id;
                $params['methods'] = ['token'];
            } else {
                // s'il est expiré on le detruit
                unlink($cacheFile);
            }
        }
        //On se connecte
        $this->client = new OpenStack($params);

        //Si le token n'existait pas ou expiré on le genere
        if(!file_exists($cacheFile)) {
             $identity = $this->client->identityV3();
             $thetoken = $identity->generateToken($params);
             //On le sauvegarde
             file_put_contents($cacheFile, json_encode($thetoken));
        }

        $this->service = $this->client->ObjectStoreV1();
        $this->container = $this->service->getContainer(Config::get('ovh-swift-laravel::config.container'));
    }

    /**
     * Get a file
     * @param $filename
     *
     * @return \OpenCloud\ObjectStore\Resource\DataObject
     */
    public function fileGet($filename)
    {
        $object = $this->container->getObject($filename);
        $object->retrieve();
        return $object;
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

        if($isString)
            $getPath = $file;
        else
            $getPath = $file->getRealPath();

        if($filename == null) {
            if($isString) {
                $explodePath = explode('/', $file);
                $filename = $explodePath[count($explodePath)-1];
            }
            else
                $filename = $file->getClientOriginalName();
        }

        $options = [
            'name'   => $filename,
            'stream' => new Stream(fopen($getPath, 'r')),
        ];

        //on cree
        $this->container->createObject($options) != null;
        return $this->fileExists($filename); 
    }

    /**
     * Test the file existence
     * @param string $filename
     *
     * @return bool
     */
    public function fileExists($filename){
        return $this->container->objectExists($filename);
    }

    /**
     * Get file list
     * @return \OpenCloud\Common\Collection
     */
    public function fileList(){
        return $this->container->listObjects();
    }

    /**
     * Delete a file
     * @param string $filename
     * @return bool
     */
    public function fileDelete($filename){
        $object = $this->container->getObject($filename);
        $object->delete();
        return !$this->fileExists($filename);
    }
}
