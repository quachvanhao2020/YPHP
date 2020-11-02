<?php
namespace YPHP;

interface EntityInterface{
    /**
     * @return string
     */
    function getId();
        /**
     * @return string
     */
    function getClass();

    function __toArray();

    function __arrayTo($array);
}