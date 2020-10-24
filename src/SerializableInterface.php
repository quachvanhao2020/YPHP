<?php
namespace YPHP;
use JsonSerializable;
interface SerializableInterface extends JsonSerializable
{
    function __toStd();
    function __toArray();
}