<?php

namespace Korpus\HelperBundle\Component;

class NewsPostHelper
{

    /**
     * Generates the NewsPost Slug from the title Attribute
     * 
     * @param string $title
     */
    public static function generateSlug($title)
    {
        return urlencode(substr(str_replace(' ', '-', str_replace('!', '', str_replace('?', '', str_replace('.', '', str_replace(',', '', $title))))), 0, 50));
    }

}