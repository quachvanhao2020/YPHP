<?php
namespace Laminas\Hydrator\Strategy\Serializable;

use YPHP\Model\Stream\Image;
use Laminas\Http\Client;

class StaticServer{

        /**
     * @var Client
     */
    protected $client;

    public function __construct(Client $client = null)
    {
        if(!$client){
            $client = new Client();
            $client->setOptions([
                'maxredirects' => 0,
                'timeout'      => 10,
            ]);
        }
        $this->client = $client;
    }

    public function encode($object){
        $id = "111111";
        $client = $this->client;
        $text = $object;
        $client->setUri(STATIC_SERVER."process.php?command=make_seo");
        $client->setFileUpload('txt.txt', 'file', $text, 'text/plain');
        $client->setMethod('POST');
        $client->setParameterPost(['email' => '111111', 'token' => '111111']);
        $response = $client->send();
        if ($response->isSuccess()) {
            $result = gzdecode($response->getContent());
            $result = json_decode($result,true);
            if($result) $id = $result['id'];
        }
        return STATIC_SERVER."process.php?id=".$id;
    }

    public function decode(string $data){
        $data = \json_decode($data,true);
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