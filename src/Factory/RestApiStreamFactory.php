<?php
namespace YPHP\Factory;

use YPHP\Factory\RestApiEntityFactory;
use YPHP\Model\Media\EntityMedia;
use YPHP\Model\Media\Image;
use YPHP\Model\Media\Video;


class RestApiStreamFactory extends RestApiEntityFactory{
    const ENTITY = EntityMedia::class;
    const STORAGE = StreamStorage::class;
    const ENDPOINT = "streams";

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

    protected function extract(object $object){
        $dtype = "stream";
        switch (get_class($object)) {
            case EntityMedia::class:

                break;
            case Image::class:
                $dtype = "image";
                break;
            case Video::class:
                $dtype = "video";
                break;
            default:
                # code...
                break;
        }
        $data = parent::extract($object);
        $data["dtype"] = $dtype;
        var_dump($data);
        return $data;
    }
}