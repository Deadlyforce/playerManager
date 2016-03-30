<?php

namespace UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Description of AppUserBundle
 *
 * @author Norman
 */
class UserBundle extends Bundle
{
    public function getParent() 
    {
        return 'FOSUserBundle';
    }
}
