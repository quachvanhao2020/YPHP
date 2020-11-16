<?php
namespace YPHP;

class SEOEntity extends Entity{
    use SearchInject;
    const KEYWORDS = "keywords";

    public function __toArray(){
        return array_merge([
            self::KEYWORDS => $this->getKeywords(),
        ],parent::__toArray());
    }
}