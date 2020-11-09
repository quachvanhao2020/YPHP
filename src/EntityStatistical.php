<?php
namespace YPHP;
use YPHP\EntityLife;
use YPHP\Filter\AwareDateTimeInterface;

class EntityStatistical extends EntityLife implements AwareDateTimeInterface{
    const TOTALCREATED = "totalCreated";
    const TOTALCHANGED = "totalChanged";
    const TOTALDELETED = "totalDeleted";

    public function __toArray(){
        return array_merge([
            self::TOTALCHANGED => $this->getTotalChanged(),
            self::TOTALCREATED => $this->getTotalCreated(),
            self::TOTALDELETED => $this->getTotalDeleted(),
        ],parent::__toArray());
    }

    public function getDateTime(){
        return $this->getDateCreated();
    }

    /**
     * @var int
     */
    protected $totalCreated = 0;

    /**
     * @var int
     */
    protected $totalChanged = 0;

    /**
     * @var int
     */
    protected $totalDeleted = 0;


    /**
     * Get the value of totalCreated
     *
     * @return  int
     */ 
    public function getTotalCreated()
    {
        return $this->totalCreated;
    }

    /**
     * Set the value of totalCreated
     *
     * @param  int  $totalCreated
     *
     * @return  self
     */ 
    public function setTotalCreated(int $totalCreated = null)
    {
        $this->totalCreated = $totalCreated;

        return $this;
    }

    /**
     * Get the value of totalChanged
     *
     * @return  int
     */ 
    public function getTotalChanged()
    {
        return $this->totalChanged;
    }

    /**
     * Set the value of totalChanged
     *
     * @param  int  $totalChanged
     *
     * @return  self
     */ 
    public function setTotalChanged(int $totalChanged = null)
    {
        $this->totalChanged = $totalChanged;

        return $this;
    }

    /**
     * Get the value of totalDeleted
     *
     * @return  int
     */ 
    public function getTotalDeleted()
    {
        return $this->totalDeleted;
    }

    /**
     * Set the value of totalDeleted
     *
     * @param  int  $totalDeleted
     *
     * @return  self
     */ 
    public function setTotalDeleted(int $totalDeleted = null)
    {
        $this->totalDeleted = $totalDeleted;

        return $this;
    }
}