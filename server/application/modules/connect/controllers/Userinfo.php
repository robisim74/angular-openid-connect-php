<?php defined('BASEPATH') OR exit('No direct script access allowed');

use OAuth2\Request;
use OAuth2\Response;
use OAuth2\RequestInterface;
use OAuth2\ResponseInterface;
use OAuth2\OpenID\Controller\UserInfoControllerInterface;

/*
 * Userinfo endpoint.
 * 
 * @see http://openid.net/specs/openid-connect-core-1_0.html#UserInfo
 */
class Userinfo extends CI_Controller implements UserInfoControllerInterface
{
    public function __construct()
    {
        parent::__construct();
        // Allows CORS.
        $this->output->set_header('Access-Control-Allow-Origin: *');
        $this->output->set_header('Access-Control-Allow-Methods: GET, OPTIONS');
        $this->output->set_header('Access-Control-Allow-Headers: Content-Type, Authorization');

        // Authentication library.
        $this->load->library('ion_auth');
        
        // OAuth 2.0 Server.
        $this->load->library('OAuth2_server');
    }

    public function index()
    {
        $request = Request::createFromGlobals();
        $response = new Response();

        // Browsers preflight the request to look for CORS headers.
        // If the request is acceptable, then they will send the real request.
        $bearer = $request->headers('Authorization', null);
        if (is_null($bearer)) {
            return;
        }

        $this->handleUserInfoRequest($request, $response)->send();
    }

    public function handleUserInfoRequest(RequestInterface $request, ResponseInterface $response)
    {
        // OAuth 2.0 authentication: "openid" scope.
        if (!$this->oauth2_server->server->verifyResourceRequest($request, $response, 'openid')) {
            return;
        }

        $token = $this->oauth2_server->server->getAccessTokenData($request, $response);
        
        // The default behavior is to use "username" as user_id.
        $user = $this->ion_auth->user($token['user_id'])->row();

        // Groups of claims are returned based on the requested scopes.
        // Scopes with matching claims: profile, email, address, phone.
        // http://openid.net/specs/openid-connect-core-1_0.html#ScopeClaims
        $claims = $this->oauth2_server->storage->getUserClaims($user->username, $token['scope']);
        
        // The sub Claim MUST always be returned in the UserInfo Response.
        // http://openid.net/specs/openid-connect-core-1_0.html#UserInfoResponse
        $claims += array(
            'sub' => $token['user_id'],
        );

        // Custom claims.
        // Groups.
        $groups = $this->ion_auth->groups()->result_array();
        $claims += array(
            'groups' => $groups
        );

        $response->addParameters($claims);

        return $response;
    }
}
