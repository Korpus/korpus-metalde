<?php

namespace Korpus\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class KorpusUserBundle extends Bundle
{

    public function getParent()
    {
        return 'FOSUserBundle';
    }

}
