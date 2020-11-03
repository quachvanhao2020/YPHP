<?php
namespace YPHP\Filter;

interface AwareSortFilterInterface{
    function getWeight($flag = SortFilter::MOST);
}