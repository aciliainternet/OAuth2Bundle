<?php
namespace Acilia\Bundle\OAuth2Bundle\Library\OAuth2\Configuration;

use Acilia\Bundle\OAuth2Bundle\Library\OAuth2\Configuration\ConfigurationInterface;
use Acilia\Bundle\OAuth2Bundle\Library\OAuth2\Provider\FacebookProvider;

class FacebookConfiguration implements ConfigurationInterface
{
    protected $appId;

    protected $appSecret;

    protected $scope;

    public function __construct()
    {
        $this->scope = ['public_profile'];
    }

    public function getName()
    {
        return FacebookProvider::NAME;
    }

    /**
     * @param string $appId
     */
    public function setAppId($appId)
    {
        $this->appId = $appId;
        return $this;
    }

    /**
     * @return string
     */
    public function getAppId()
    {
        return $this->appId;
    }

    /**
     * @param string $appSecret
     */
    public function setAppSecret($appSecret)
    {
        $this->appSecret = $appSecret;
        return $this;
    }

    /**
     * @return string
     */
    public function getAppSecret()
    {
        return $this->appSecret;
    }

    /**
     * @param mixed $scope
     */
    public function setScope($scope)
    {
        $this->scope = $scope;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getScope()
    {
        return $this->scope;
    }

    public function addScope($scope)
    {
        $this->scope[] = $scope;
        return $this;
    }
}