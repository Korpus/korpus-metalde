<?php

namespace Korpus\HelperBundle\Component;

class FileHelper
{

    /**
     * 
     * @param type $filename
     * @return string
     */
    public static function generateSlug($filename)
    {
        return urlencode(strtolower(substr(str_replace(' ', '-', str_replace('!', '', str_replace('?', '', str_replace('.', '', str_replace(',', '', $filename))))), 0, 50)));
    }

}