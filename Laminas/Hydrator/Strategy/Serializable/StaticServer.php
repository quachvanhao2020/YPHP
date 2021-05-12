<?php
namespace Laminas\Hydrator\Strategy\Serializable;

use YPHP\Model\Stream\Image;
use Laminas\Http\Client;
use Laminas\Uri\Uri;
use YPHP\HttpStream;
use YPHP\Stream;

class StaticServer{

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var bool
     */
    protected $onlyId;

    public function __construct(Client $client = null,$onlyId = true)
    {
        if(!$client){
            $client = new Client();
            $client->setOptions([
                'maxredirects' => 0,
                'timeout'      => 10,
            ]);
        }
        $this->client = $client;
        $this->onlyId = $onlyId;
    }

    public function encode($object){
        $id = $this->upload($object);
        if($this->onlyId) return $id;
        return STATIC_SERVER."process.php?id=".$id;
    }

    public function read($uri){
        $client = $this->client;
        $client->setUri($uri);
        $response = $client->send();
        if ($response->isSuccess()) {
            $result = gzdecode($response->getContent());
            $result = json_decode($result,true);
            return $result;
        }
    }

    public function upload($object){
        //return "-";
        $name = 'txt.txt';
        $type = 'text/plain';
        $content = $object;
        if($object instanceof Stream){
            $content = $object->getContents();
            if($object instanceof HttpStream){
                $uri = $object->getMetadata('uri');
                $headers = $object->getHeaders();
                foreach ($headers as $key => $value) {
                    if($key == 'Content-Type'){
                        $type = $value;
                        break;
                    }
                }
                $s = explode('/',$uri);
                $name = end($s);
            }
        }
        if(empty($content)) return;
        $id = "111111";
        $client = $this->client;
        $client->setUri(STATIC_SERVER."process.php?command=make_seo");
        $client->setFileUpload($name, 'file', $content, $type);
        $client->setMethod('POST');
        $client->setParameterPost(['email' => '111111', 'token' => '111111']);
        $response = $client->send();
        if ($response->isSuccess()) {
            $result = gzdecode($response->getContent());
            $result = json_decode($result,true);
            if($result) $id = $result['id'];
        }
        return $id;
    }

    public function decode($data){
        $uri = new Uri($data);
        if($uri->isValid()){
            $data = $this->read($data);
        }else{
            if($this->onlyId){
                $data = $this->read(STATIC_SERVER."process.php?id=".$data);
            }
        }
        if($data){
            $file = $data["file"];
            $type = $file['type'];
            if($type == "text/html"){
                return \file_get_contents($file['url']);
            }
            $image = $this->fileDataToImage($file);
            $image->setId($data["id"]);
            return $image;
        }
    }

    public function fileDataToImage(array $data){
        $image = new Image();
        $image->setSrc($data["url"]);
        $image->setWidth(@$data["width"]);
        $image->setHeight(@$data["height"]);
        if(isset($data["thumb"])){
            $image->setThumb($this->fileDataToImage($data["thumb"]));
        }
        $relates = @$data["relates"];
        if(is_array($relates)){
            $storage = $image->getRelates();
            foreach ($relates as $key => $value) {
                $storage->append($this->fileDataToImage($value));
            }        
        }
        return $image;
    }

}