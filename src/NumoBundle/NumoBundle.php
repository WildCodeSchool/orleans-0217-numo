<?php

namespace NumoBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class NumoBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
