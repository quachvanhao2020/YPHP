<?php
namespace YPHP;

trait SearchInject{
    /**
     * @var string[]
     */
    protected $keywords = [];
    /**
     * Get the value of keywords
     *
     * @return  string[]
     */ 
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * Set the value of keywords
     *
     * @param  string[]  $keywords
     *
     * @return  self
     */ 
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;

        return $this;
    }
}