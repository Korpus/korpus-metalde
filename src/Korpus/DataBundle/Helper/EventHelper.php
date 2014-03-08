<?php

namespace Korpus\DataBundle\Helper;

use VerbalExpressions\PHPVerbalExpressions\VerbalExpressions;

class EventHelper
{
    public static function generateSlug($title)
    {
        return preg_replace('/[^\w\s]/', '-', preg_replace('/ /', '-', strtolower($title)));
    }
}