<?php
namespace YPHP\Factory;

use YPHP\Entity;
use YPHP\FilterInputInterface;
use YPHP\SortingInputInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpClient\HttpClient;
use YPHP\Storage\EntityStorage;
use Laminas\Hydrator\ClassMethodsHydrator;
use Laminas\Authentication\Adapter\Http;
use Laminas\ApiTools\MvcAuth\Authentication\OAuth2Adapter;
use YPHP\EntityInterface;
use Laminas\Hydrator\HydratorInterface;
use Laminas\Hydrator\Strategy\StrategyInterface;
use Laminas\Http\PhpEnvironment\Request;

class ApiEntityFactory extends EntityFactory{

    const ENTITY = Entity::class;
    const STORAGE = EntityStorage::class;
    const ENDPOINT = "entitys";

    /**
     * @var array
     */
    protected $config = [
        "host" => "http://localhost:8080",
        "authorizations" => [
            [
                "type" => Http::class,
                "username" => "",
                "password" => "",
            ],
            [
                "type" => OAuth2Adapter::class,
                "client_id" => "",
                "client_secret" => "",
            ]
        ],
    ];

    /**
     * @var HttpClientInterface
     */
    protected $client;

    /**
     * @var HydratorInterface
     */
    protected $hydrator;

        /**
     * @var StrategyInterface[]
     */
    protected $strategys = [];

    /**
     * @var string
     */
    protected $host;

    /**
     * @var array
     */
    protected $authorizations;

        /**
     * @var EntityInterface
     */
    protected $_entity;

    public function __construct(HttpClientInterface $client = null,HydratorInterface $hydrator = null,array $config = [],EntityInterface $_entity = null)
    {
        if(!$client) $client = HttpClient::create();
        if(!$hydrator) $hydrator = new ClassMethodsHydrator();
        if(!$_entity){
            $class = $this::ENTITY;
            $_entity = new $class;
        } 
        $config = array_replace_recursive($this->config,$config);
        $this->client = $client;
        $this->hydrator = $hydrator;
        $this->host = $config["host"];
        $this->authorizations = $config["authorizations"];
        $this->_entity = $_entity;
        $this->strategys = $this->getStrategys();
    }

    public function prepareHeaders(){
        $headers = [
            'Content-Type' => 'text/plain',
            'Content-Type' => 'application/json',
        ];
        foreach ($this->authorizations as $key => $value) {
            switch ($value['type']) {
                case Http::class:
                    $headers['Authorization'] = "Basic ".base64_encode($value['username'].":".$value['password']);
                    break;
                default:
                    # code...
                    break;
            }
        }
        return $headers;
    }

    public function getEndPoint(){
        return $this->host."/".$this::ENDPOINT;
    }
    
    /**
     * 
     *
     * @param string $id Identifier of the entry to look for.
     *
     * @throws NotFoundExceptionInterface  No entry was found for **this** identifier.
     * @throws ContainerExceptionInterface Error while retrieving the entry.
     *
     * @return Entity.
     */
    public function get($id){
        $result = $this->client->request("GET",$this->getEndPoint()."/".$id,['headers' => $this->prepareHeaders(),])->getContent(false);
        $result = \json_decode($result,true);
        return $this->hydrate($result);
    }

    protected function hydrate(array $data){
        $object = \hydrate($data,clone $this->_entity,$this->hydrator,true,$this->hydrator,$this->strategys);
        if(is_a($object,$this::ENTITY)){
            return $object;
        }
    }

    protected function extract(object $object){
        return \hydrator_extract($object,$this->hydrator,true,$this->strategys,1);
    }

            /**
     * @param int $first
     * @param string $after
     * @param int $last
     * @param string $before
     * @param FilterInputInterface $filter
     * @param SortingInputInterface $sort
     * @return mixed
     */
    public function list(int $first = 0,string $after = "",int $last = -1,string $before = "",FilterInputInterface $filter = null,SortingInputInterface $sort = null){
        $result = $this->client->request("GET",$this->getEndPoint(),['headers' => $this->prepareHeaders(),])->getContent(false);
        $result = \json_decode($result,true);
        $results = $result["_embedded"][$this::ENDPOINT];
        foreach ($results as $key => $value) {
            try {
                $results[$key] = $this->hydrate($value);
            } catch (\Throwable $th) {
                throw $th;
            }
        }
        return $results;
    }

    /**
     * @param string $id Identifier of the entry to look for.
     *
     * @return bool
     */
    public function has($id){
        return true;
    }

        /**
     * @param string $id Identifier of the entry to look for.
     *
     * @return bool
     */
    public function delete($id){
        $result = $this->client->request(Request::METHOD_DELETE,$this->getEndPoint()."/".$id,['headers' => $this->prepareHeaders(),])->getContent(false);
        var_dump($result);
        return true;
    }

    /**
     * @param string $id Identifier of the entry to look for.
     * @param Entity $entity
     * @return bool
     */
    public function update($id,$entity){
        $_entity = \hydrator_extract($entity,$this->hydrator,true,$this->strategys,1);
        $_entity = \index_value_array($_entity,"_");
        $_entity[Entity::ID] = $id;
        $result = $this->client->request(Request::METHOD_PUT,$this->getEndPoint()."/".$id,[
            'headers' => $this->prepareHeaders(),
            'json' => $_entity,
        ])->getContent(false);
        $result = \json_decode($result,true);
        return $this->hydrate($result);
    }

    /**
     * @param string $id Identifier of the entry to look for.
     * @param Entity $entity
     * @return bool
     */
    public function create($entity){
        $_entity = $this->extract($entity);
        $url = $this->getEndPoint();
        $_entity = \index_value_array($_entity,"_");
        $result = $this->client->request(Request::METHOD_POST,trim($url,"/"),[
            'headers' => $this->prepareHeaders(),
            'json' => $_entity,
        ])->getContent(false);
        var_dump($result);
    }

    /**
     * Get the value of client
     *
     * @return  HttpClientInterface
     */ 
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set the value of client
     *
     * @param  HttpClientInterface  $client
     *
     * @return  self
     */ 
    public function setClient(HttpClientInterface $client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get the value of strategys
     *
     * @return  StrategyInterface[]
     */ 
    public function getStrategys()
    {
        return [
            
        ];
    }
}