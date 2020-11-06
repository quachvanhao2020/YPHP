<?php
namespace YPHP\Filter;
use DateTime;
use ArrayAccess;
use YPHP\EntityStatistical;

class DateTimeFilter extends EntityFilter{
    const DATESTART = "dateStart";
    const DATEEND = "dateEnd";

    /**
     * @param ArrayAccess $result
     * @return mixed
     */
    function filter(ArrayAccess &$result){
        foreach ($result as $key => $entity) {
            if($entity instanceof AwareDateTimeInterface){
                $timestamp = $entity->getDateTime()->getTimestamp();
                if(
                    (!$this->dateStart || $timestamp >= $this->getDateStart()->getTimestamp())
                    && 
                    (!$this->dateEnd || $timestamp <= $this->getDateEnd()->getTimestamp())
                ){

                }else{
                    unset($result[$key]);
                }
            }
        }
        return $result;
    }

    /**
     * @var DateTime
     */
    protected $dateStart;

    /**
     * @var DateTime
     */
    protected $dateEnd;

    /**
     * Get the value of dateStart
     *
     * @return  DateTime
     */ 
    public function getDateStart()
    {
        return $this->dateStart;
    }

    /**
     * Set the value of dateStart
     *
     * @param  DateTime  $dateStart
     *
     * @return  self
     */ 
    public function setDateStart(?DateTime $dateStart = null)
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    /**
     * Get the value of dateEnd
     *
     * @return  DateTime
     */ 
    public function getDateEnd()
    {
        return $this->dateEnd;
    }

    /**
     * Set the value of dateEnd
     *
     * @param  DateTime  $dateEnd
     *
     * @return  self
     */ 
    public function setDateEnd(?DateTime $dateEnd = null)
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }
}