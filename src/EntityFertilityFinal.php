<?php
namespace YPHP;
use YPHP\SEOEntity;
use YPHP\Storage\AttributeStorage;

class EntityFertilityFinal extends EntityFertility{

    const SEO = "seo";
    const ATTRIBUTES = "attributes";

    public function __toArray(){
        return array_merge([
            self::SEO => $this->getSeo(),
            self::ATTRIBUTES => $this->getAttributes(),
        ],parent::__toArray());
    }

    public function __arrayTo($array)
    {
        parent::__arrayTo($array);
        $this->setSeo(@$array[self::SEO]);
        $attributes = @$array[self::ATTRIBUTES];
        if(is_array($attributes)){
            $attributes = \tran($attributes,AttributeStorage::class);
        }
        $this->setAttributes($attributes);
    }

    /**
     * @var SEOEntity
     */
    protected $seo;
    /**
     * @var AttributeStorage
     */
    protected $attributes;

    /**
     * Get the value of attributes
     *
     * @return  AttributeStorage
     */ 
    public function getAttributes()
    {
        if(!$this->attributes) $this->attributes = new AttributeStorage();
        return $this->attributes;
    }

    /**
     * Set the value of attributes
     *
     * @param  AttributeStorage  $attributes
     *
     * @return  self
     */ 
    public function setAttributes(AttributeStorage $attributes = null)
    {
        $this->attributes = $attributes;

        return $this;
    }

    /**
     * Get the value of seo
     *
     * @return  SEOEntity
     */ 
    public function getSeo()
    {
        if(!$this->seo) $this->seo = new SEOEntity();
        return $this->seo;
    }

    /**
     * Set the value of seo
     *
     * @param  SEOEntity  $seo
     *
     * @return  self
     */ 
    public function setSeo(SEOEntity $seo = null)
    {
        $this->seo = $seo;

        return $this;
    }
}