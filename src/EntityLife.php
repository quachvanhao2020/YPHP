<?php
namespace YPHP;

use YPHP\Entity;
use DateTime;
use YPHP\EntityStatusEnum as EntityStatus;
use Doctrine\ORM\Mapping as ORM;

class EntityLife extends Entity{
    const NAME = "name";
    const STATUS = "status";
    const DATECREATED = "dateCreated";
    const NOTE = "note";
    const REF = "ref";

    /**
     * 
     * @ORM\Column(type="string",nullable=true)
     * @var string
     */
    protected $name;

    /**
     * 
     * @ORM\Column(type="string",nullable=true)
     * @var string
     */
    protected $note;

    /**
     * 
     * \@ORM\Column(type="string",nullable=true)
     * @ORM\Embedded(class = "YPHP\EntityStatusEnum")
     * @var EntityStatus
     */
    protected $status;

    /**
     * 
     * @ORM\Column(type="datetime",nullable=true)
     * @var DateTime
     */
    protected $dateCreated;

    /**
     * 
     * @ORM\Column(type="string",nullable=true)
     * @var string
     */
    protected $ref;

    public function __toArray(){
        return array_merge([
            self::NAME => $this->getName(),
            self::STATUS => $this->getStatus(),
            self::NOTE => $this->getNote(),
            self::DATECREATED => $this->getDateCreated(),
            self::REF => $this->getRef(),
        ],parent::__toArray());
    }

    public function __arrayTo($array)
    {
        parent::__arrayTo($array);
        $this->setName(@$array[self::NAME]);
        $this->setStatus(@$array[self::STATUS]);
        $this->setNote(@$array[self::NOTE]);
        $this->setRef(@$array[self::REF]);
        $dateCreated = @$array[self::DATECREATED];
        if($dateCreated instanceof \DateTime){
            
        }else if(is_string($dateCreated)){
            $dateCreated = @\DateTime::createFromFormat('Y-m-d H:i:s',$dateCreated);
        }else if(is_array($dateCreated)){
            $dateCreated = @new \DateTime($dateCreated["date"]);
        }
        $this->setDateCreated($dateCreated);
    }

        /**
     * Get the value of dateCreated
     *
     * @return  DateTime
     */ 
    public function getDateCreated()
    {
        if(!$this->dateCreated) $this->dateCreated = new DateTime();
        return $this->dateCreated;
    }

    /**
     * Set the value of dateCreated
     *
     * @param  DateTime  $dateCreated
     *
     * @return  self
     */ 
    public function setDateCreated(DateTime $dateCreated = null)
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    /**
     * Get the value of name
     *
     * @return  string
     */ 
    public function getName()
    {
        if(!$this->name) $this->name = "";

        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @param  string  $name
     *
     * @return  self
     */ 
    public function setName(string $name = null)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of status
     *
     * @return  EntityStatus
     */ 
    public function getStatus()
    {
        if(!$this->status) $this->status = new EntityStatus(EntityStatus::NEUTRAL);
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @param  EntityStatus  $status
     *
     * @return  self
     */ 
    public function setStatus($status = null)
    {
        $this->status = $status;
        return $this;
    }


    /**
     * Get the value of note
     *
     * @return  string
     */ 
    public function getNote()
    {
        if(!$this->note) $this->note = "";
        return $this->note;
    }

    /**
     * Set the value of note
     *
     * @param  string  $note
     *
     * @return  self
     */ 
    public function setNote(string $note = null)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get the value of ref
     *
     * @return  string
     */ 
    public function getRef()
    {
        if(!$this->ref) $this->ref = "";
        return $this->ref;
    }

    /**
     * Set the value of ref
     *
     * @param  string  $ref
     *
     * @return  self
     */ 
    public function setRef(string $ref = null)
    {
        $this->ref = $ref;

        return $this;
    }
}