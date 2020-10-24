<?php
namespace YPHP;
use YPHP\Storage\TranslationStorage;

class TranslationService{

        /**
     * @var TranslationStorage
     */
    protected $translations;

    public function __construct()
    {
        $this->translations = new TranslationStorage();
    }

    public function translate(Translation $translationFlag,$result = null){
        try {
            /** @var Translation */
            $translation = $this->getTranslations()[$translationFlag->getId()];
            $result = $translation->getCallable()($translationFlag->getCurrentEntity(),$result);
            return $result;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    /**
     * Get the value of translations
     *
     * @return  TranslationStorage
     */ 
    public function getTranslations()
    {
        return $this->translations;
    }

    /**
     * Set the value of translations
     *
     * @param  TranslationStorage  $translations
     *
     * @return  self
     */ 
    public function setTranslations(TranslationStorage $translations)
    {
        $this->translations = $translations;

        return $this;
    }

    private static $instance = null;

    public static function getInstance()
    {
        if (self::$instance == null)
        {
            self::$instance = (new self());
        }
        return self::$instance;
    }
}