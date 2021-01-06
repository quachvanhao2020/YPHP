<?php
namespace YPHP;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 */
class EntityStatusEnum extends Enum{
    const ACTIVE = "ACTIVE";
    const FREEZE = "FREEZE";
    const VIRUS = "VIRUS";
    const NEUTRAL = "NEUTRAL";
}
