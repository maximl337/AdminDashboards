<?php

namespace App\Services;

use App\Contracts\FileStorage;
use OpenCloud\Rackspace;

class RackspaceService implements FileStorage 
{

    protected $client;

    protected $container;

    protected $objectService;

    protected $object;

    public function __construct(Rackspace $client)
    {
        $this->client = $client;

        $this->objectStoreService = $this->client->objectStoreService(null, 'IAD');

        $this->container = $this->objectStoreService->getContainer(env('RACKSPACE_CONTAINER'));
        
    }

    public function put($fileDestination, $file)
    {   

        $handle = fopen($file, 'r');

        $this->object = $this->container->uploadObject($fileDestination, $handle);

        return $this->object;

    }

    public function getTempUrl($remoteFilePath)
    {
    
        try {

            $this->object = $this->container->getObject($remoteFilePath);

            $account = $this->objectStoreService->getAccount();

            $account->setTempUrlSecret();

            // Get a temporary URL that will expire in 3600 seconds (1 hour) from now
            // and only allow GET HTTP requests to it.
            return $this->object->getTemporaryUrl(3600, 'GET');
            
        } catch(\Exception $e) {

            return $e->getMessage();
        }     
        
    }

    public function getPublicUrl($filePath)
    {
        # code...
    }


}