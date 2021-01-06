<?php
namespace YPHP\Api\V1\Rest\Stream;

use Doctrine\ORM\Mapping as ORM;
use YPHP\Model\Media\EntityMedia;

/**
 * \@ORM\Entity 
 * @ORM\InheritanceType("JOINED") 
 * @ORM\InheritanceType("SINGLE_TABLE") 
 * \@ORM\DiscriminatorColumn(name="dtype", type="string",default="stream")
 * @ORM\DiscriminatorMap({"streams" = "YPHP\Api\V1\Rest\Stream\Entity","images" = "YPHP\Model\Media\Image", "videos" = "YPHP\Model\Media\Video"})
 * @ORM\Table(name="stream")
 */
class _Entity extends EntityMedia{

}

class_alias(EntityMedia::class, "YPHP\Api\V1\Rest\Stream\Entity");