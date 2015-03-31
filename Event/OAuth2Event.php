<?php
namespace Acilia\Bundle\OAuth2Bundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;

class OAuth2Event extends Event
{
    protected $request;

    protected $returnUrl;

    protected $userData;

    public function __construct($userData, Request $request)
    {
        $this->userData = $userData;
        $this->request = $request;
        $this->returnUrl = '/';
    }

    public function getUserData()
    {
        return $this->userData;
    }

    public function getRequest()
    {
        return $this->request;
    }

    public function setReturnUrl($returnUrl)
    {
        $this->returnUrl = $returnUrl;
    }

    public function getReturnUrl()
    {
        return $this->returnUrl;
    }
}
