<?php
namespace YPHP;
class EntityFertility extends Entity{
    const NAME = "name";
    const PARENT = "parent";
    const CHILDS = "childrens";
    const DATECREATED = "dateCreated";
    const REF = "ref";

        /**
     * 
     *
     * @var string
     */
    protected $name;
    /**
     * 
     *
     * @var string
     */
    protected $ref;
    /**
     * 
     *
     * @var Entity
     */
    protected $parent;
    /**
     * 
     *
     * @var Entity[]
     */
    protected $childrens;

    /**
     * 
     *
     * @var int
     */
    protected $dateCreated;

    public function __toArray(){
        return array_merge(parent::__toArray(),[
            self::CHILDS => $this->getChildrens(),
            self::PARENT => $this->getParent(),
            self::REF => $this->getRef(),
            self::DATECREATED => $this->getDateCreated(),
        ]);
    }

    /**
     * Get the value of childrens
     *
     * @return  Entity[]
     */ 
    public function getChildrens()
    {
        return $this->childrens;
    }

    /**
     * Set the value of childrens
     *
     * @param  Entity[]  $childrens
     *
     * @return  self
     */ 
    public function setChildrens($childrens)
    {
        $this->childrens = $childrens;
        return $this;
    }

    /**
     * Get the value of parent
     *
     * @return  Entity
     */ 
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set the value of parent
     *
     * @param  Entity  $parent
     *
     * @return  self
     */ 
    public function setParent(Entity $parent)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get the value of ref
     *
     * @return  string
     */ 
    public function getRef()
    {
        return $this->ref;
    }

    /**
     * Set the value of ref
     *
     * @param  string  $ref
     *
     * @return  self
     */ 
    public function setRef(string $ref)
    {
        $this->ref = $ref;

        return $this;
    }

    /**
     * Get the value of dateCreated
     *
     * @return  int
     */ 
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * Set the value of dateCreated
     *
     * @param  int  $dateCreated
     *
     * @return  self
     */ 
    public function setDateCreated(int $dateCreated)
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
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @param  string  $name
     *
     * @return  self
     */ 
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }
}