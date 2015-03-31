<?php

namespace Acilia\Bundle\OAuth2Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class OAuth2Controller extends Controller
{
    public function callbackAction(Request $request, $provider)
    {
        $redirectTo = $this->get('acilia.oauth2')->init($request, $provider);

        return new RedirectResponse($redirectTo, RedirectResponse::HTTP_FOUND);
    }
}
