<?php
namespace Acilia\Bundle\OAuth2Bundle\Library\OAuth2\Provider;

use Acilia\Bundle\OAuth2Bundle\Library\OAuth2\Provider\ProviderAbstract;
use Acilia\Bundle\OAuth2Bundle\Library\OAuth2\Configuration\ConfigurationInterface;
use Acilia\Bundle\OAuth2Bundle\Library\OAuth2\Configuration\FacebookConfiguration;
use Acilia\Bundle\OAuth2Bundle\Library\OAuth2\UserData\FacebookUserData;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;

class FacebookProvider extends ProviderAbstract
{
    const NAME = 'facebook';

    public function getName()
    {
        return self::NAME;
    }

    public function supportsConfiguration(ConfigurationInterface $configuration)
    {
        return $configuration instanceof FacebookConfiguration;
    }

    public function auth(Request $request, $callbackUrl)
    {
        $url = 'https://graph.facebook.com/oauth/access_token?'
             . 'client_id=' . $this->configuration->getAppId()
             . '&redirect_uri=' . urlencode($callbackUrl)
             . '&client_secret=' . $this->configuration->getAppSecret()
             . '&code=' . $request->query->get('code');

        $parameters = [];
        parse_str(file_get_contents($url), $parameters);

        $graphUrl = 'https://graph.facebook.com/me?access_token=' . $parameters['access_token'];
        $data = json_decode(file_get_contents($graphUrl), true);

        // Get User Avatar
        $avatarData = json_decode(file_get_contents('http://graph.facebook.com/v2.1/' . $data['id'] . '/picture?redirect=false&type=large'), true);
        if ($avatarData['data']['is_silhouette'] == false) {
            $data['avatar'] = $avatarData['data']['url'];
        }

        // Fix birthday
        if (isset($data['birthday'])) {
            if (strlen($data['birthday']) - strlen(str_replace('/', '', $data['birthday'])) == 3) {
                $data['birthday'] = strtotime($data['birthday']);
                if ($data['birthday']) {
                    $data['birthday'] = date('Y-m-d', $data['birthday']);
                } else {
                    unset($data['birthday']);
                }
            } else {
                unset($data['birthday']);
            }
        }

        $userData = new FacebookUserData();
        $userData->setData(new ParameterBag($data));

        return $userData;
    }

    public function getLink($callbackUrl)
    {
        $url = 'https://www.facebook.com/dialog/oauth?'
             . 'client_id=' . $this->configuration->getAppId()
             . '&redirect_uri=' . urlencode($callbackUrl)
             . '&scope=' . implode(',', $this->configuration->getScope());

        return $url;
    }
}
