<?php

namespace Korpus\HelperBundle\Component;

class ArticleHelper
{

    /**
     * Generates the Article Slug from the title Attribute
     * 
     * @param string $title
     * @return string
     */
    public static function generateSlug($title)
    {
        return urlencode(strtolower(substr(str_replace(' ', '-', str_replace('!', '', str_replace('?', '', str_replace('.', '', str_replace(',', '', 'art-' . $title))))), 0, 50)));
    }

}