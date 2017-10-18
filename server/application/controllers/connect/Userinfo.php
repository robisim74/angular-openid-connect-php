<?php defined('BASEPATH') OR exit('No direct script access allowed');

use OAuth2\Request;
use OAuth2\Response;
use OAuth2\RequestInterface;
use OAuth2\ResponseInterface;
use OAuth2\OpenID\Controller\UserInfoControllerInterface;

/*
 * Userinfo endpoint.
 */
class Userinfo extends OAuth2_Server implements UserInfoControllerInterface
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        // Browsers preflight the request to look for CORS headers.
        // If the request is acceptable, then they will send the real request.
        $bearer = $this->input->get_request_header('Authorization', TRUE);
        if (is_null($bearer)) {
            return;
        }

        $request = Request::createFromGlobals();
        $response = new Response();

        $this->handleUserInfoRequest($request, $response)->send();
    }

    /**
     * Return claims about the authenticated end-user.
     * This would be called from the "/UserInfo" endpoint as defined in the spec.
     *
     * @param RequestInterface  $request  - Request object to grant access token
     * @param ResponseInterface $response - Response object containing error messages (failure) or user claims (success)
     * @return ResponseInterface
     *
     * @throws \InvalidArgumentException
     * @throws \LogicException
     *
     * @see http://openid.net/specs/openid-connect-core-1_0.html#UserInfo
     */
    public function handleUserInfoRequest(RequestInterface $request, ResponseInterface $response)
    {
        // OAuth2 authentication.
        if (!$this->server->verifyResourceRequest($request, $response, 'openid')) {
            return;
        }

        $token = $this->server->getAccessTokenData($request, $response);

        //$claims = $this->OAuth2_Server_model->getUserClaims($token['user_id'], $token['scope']);
        // The sub Claim MUST always be returned in the UserInfo Response.
        // http://openid.net/specs/openid-connect-core-1_0.html#UserInfoResponse
        $claims = array(
            'sub' => $token['user_id']
        );
        $response->addParameters($claims);

        return $response;
    }
}
