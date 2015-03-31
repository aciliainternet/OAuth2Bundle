<?php
namespace Acilia\Bundle\OAuth2Bundle\Service;

use Acilia\Bundle\OAuth2Bundle\Library\OAuth2\Configuration\ConfigurationInterface;
use Acilia\Bundle\OAuth2Bundle\Library\OAuth2\Provider\ProviderAbstract;
use Acilia\Bundle\OAuth2Bundle\Event\OAuth2Event;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Exception;

class OAuth2Service
{
    const EVENT_LOADED = 'oauth2.loaded';

    protected $configuration;

    protected $router;

    protected $eventDispatcher;

    public function __construct(Router $router, EventDispatcherInterface $eventDispatcher)
    {
        $this->router = $router;
        $this->eventDispatcher = $eventDispatcher;
        $configuration = [];
    }

    public function addConfiguration(ConfigurationInterface $configuration)
    {
        $this->configuration[$configuration->getName()] = $configuration;
    }

    public function init(Request $request, $provider)
    {
        $provider = $this->getProvider($provider);
        $userData = $provider->auth($request, $this->router->generate('acilia_oauth2_bundle_callback', ['provider' => $provider->getName()], true));

        $event = new OAuth2Event($userData, $request);

        $this->eventDispatcher->dispatch(self::EVENT_LOADED, $event);

        return $event->getReturnUrl();
    }

    public function getLink($provider)
    {
        $provider = $this->getProvider($provider);
        return $provider->getLink($this->router->generate('acilia_oauth2_bundle_callback', ['provider' => $provider->getName()], true));
    }

    protected function getProvider($provider)
    {
        $providerClass = 'Acilia\\Bundle\OAuth2Bundle\\Library\\OAuth2\\Provider\\';
        $providerClass = $providerClass . str_replace(' ', '', ucwords(str_replace('_', ' ', strtolower($provider)))) . 'Provider';

        if (class_exists($providerClass)) {
            $providerInstance = new $providerClass;

            if ($providerInstance instanceof ProviderAbstract) {
                if (!isset($this->configuration[$providerInstance->getName()])) {
                    throw new Exception('No configuration found for provider');
                } elseif (!$providerInstance->supportsConfiguration($this->configuration[$providerInstance->getName()])) {
                    throw new Exception('Invalid configuration for provider');
                } else {
                    $providerInstance->setConfiguration($this->configuration[$providerInstance->getName()]);
                    return $providerInstance;
                }
            }
        }

        throw new Exception('Invalid provider');
    }
}
