<?php

namespace Korpus\TwigBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class KorpusTwigBundle extends Bundle
{
    public function getParent()
    {
        return 'TwigBundle';
    }
}
