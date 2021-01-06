<?php
namespace YPHP\Model\Stream;
use Doctrine\ORM\Mapping as ORM;

/** 
 * @ORM\Entity 
 * @ORM\Table(name="videos")
 */
class Video extends EntityStream{

    const THUMB = "thumb";

    /**
     * @ORM\ManyToOne(targetEntity="YPHP\Model\Stream\Image", inversedBy="children",cascade={"persist"})
     * @var Image
     */
    protected $thumb;
    

    /**
     * Get the value of thumb
     *
     * @return  Image
     */ 
    public function getThumb()
    {
        return $this->thumb;
    }

    /**
     * Set the value of thumb
     *
     * @param  Image  $thumb
     *
     * @return  self
     */ 
    public function setThumb(Image $thumb = null)
    {
        $this->thumb = $thumb;

        return $this;
    }
}