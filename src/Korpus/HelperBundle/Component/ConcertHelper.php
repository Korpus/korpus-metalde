<?php

namespace Korpus\HelperBundle\Component;

class ConcertHelper
{

    /**
     * Generates the Concert Slug from the date, event, city Attribute
     * 
     * @param DateTime $date
     * @param string $event
     * @param string $city
     * @return string
     */
    public static function generateSlug(\DateTime $date, $event, $city)
    {
        return urlencode(strtolower(substr(str_replace(' ', '-', str_replace('!', '', str_replace('?', '', str_replace('.', '', str_replace(',', '', $date->format('dmY') . '-' . $event . '-' . $city))))), 0, 50)));
    }

}