<?php
namespace Laminas\Hydrator\Strategy\Serializable;

use YPHP\Model\Stream\Image;

class StaticServer{

    public function encode($object){

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