<?php
namespace Acilia\Bundle\OAuth2Bundle\Library\OAuth2\UserData;

use Acilia\Bundle\OAuth2Bundle\Library\OAuth2\UserData\UserDataAbstract;
use Acilia\Bundle\OAuth2Bundle\Library\OAuth2\Provider\FacebookProvider;

class FacebookUserData extends UserDataAbstract
{
    public function getName()
    {
        return FacebookProvider::NAME;
    }
}