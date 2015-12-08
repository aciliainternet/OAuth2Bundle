<?php
namespace Acilia\Bundle\OAuth2Bundle\Library\Twig\Extension;

use Acilia\Bundle\OAuth2Bundle\Service\OAuth2Service;

class OAuth2Extension extends \Twig_Extension
{
    protected $oauth2;

    public function __construct(OAuth2Service $oauth2)
    {
        $this->oauth2 = $oauth2;
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('get_oauth2_link', [$this, 'getOauth2Link']),
        ];
    }

    public function getOauth2Link($provider)
    {
        return $this->oauth2->getLink($provider);
    }

    public function getName()
    {
        return 'acilia_oauth2_bundle';
    }
}
