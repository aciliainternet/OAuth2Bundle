<?php
namespace Acilia\Bundle\OAuth2Bundle\Library\OAuth2\Provider;

use Acilia\Bundle\OAuth2Bundle\Library\OAuth2\Provider\ProviderInterface;
use Acilia\Bundle\OAuth2Bundle\Library\OAuth2\Configuration\ConfigurationInterface;
use Symfony\Component\HttpFoundation\Request;

abstract class ProviderAbstract
{
    protected $configuration;

    abstract public function getName();

    abstract public function auth(Request $request, $callbackUrl);

    abstract public function getLink($callbackUrl);

    abstract public function supportsConfiguration(ConfigurationInterface $configuration);

    public function setConfiguration(ConfigurationInterface $configuration)
    {
        $this->configuration = $configuration;
        return $this;
    }
}