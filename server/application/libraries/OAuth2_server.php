<?php defined('BASEPATH') OR exit('No direct script access allowed');

use OAuth2\Request;
use OAuth2\Response;
use OAuth2\RequestInterface;
use OAuth2\ResponseInterface;
use OAuth2\Server as OAuth2Server;
use OAuth2\Storage\Pdo;
use OAuth2\Storage\Memory;
use OAuth2\Scope;

/*
 * OAuth 2.0 Server configuration.
 */
class OAuth2_server
{
    public $storage;
    public $server;

    public $response;

    protected $CI;

    private $dsn;
    private $username;
    private $password;

    public function __construct()
    {
        // Assigns the CodeIgniter super-object.
        $this->CI = &get_instance();

        $this->CI->load->database();
        $this->CI->load->library('ion_auth');

        // Gets database config values.
        $this->dsn = $this->CI->db->dsn;
        $this->username = $this->CI->db->username;
        $this->password = $this->CI->db->password;

        $this->setup();
    }

    public function authorize(RequestInterface $request, $scope, $groups)
    {
        $this->response = new Response();

        // OAuth 2.0 authentication & scope.
        if (!$this->server->verifyResourceRequest($request, $this->response, $scope)) {
            $this->response = $this->server->getResponse();
            return FALSE;
        }

        // Allowed groups.
        $token = $this->server->getAccessTokenData($request, $this->response);
        if (!$this->CI->ion_auth->in_group($groups, $token['user_id'])) {
            $this->response->setError(401, 'Invalid group');
            return FALSE;
        }

        return TRUE;
    }

    private function setup()
    {
        // Uses Ion Auth "users" table as OAuth2 "user_table".
        //
        // To match claims, you need to redefine the "users" table attributes.
        // http://openid.net/specs/openid-connect-core-1_0.html#Claims
        $config = array(
            'user_table' => 'users'
        );
        // MySql db.
        $this->storage = new Pdo(array(
            'dsn' => $this->dsn, 'username' => $this->username, 'password' => $this->password
        ), $config);
                
        // OAuth 2.0 Server configuration.
        // Public & Private key are stored in the PDO storage.
        $this->server = new OAuth2Server($this->storage, array(
            'enforce_state' => true,
            'allow_implicit' => true,
            'use_openid_connect' => true,
            'issuer' => $_SERVER['HTTP_HOST'],
            /*
             * Where a self-contained token (JWT token) is hard to revoke before its expiration time, 
             * a reference token only lives as long as it exists in the STS data store. This allows for scenarios like:
             *
             * - revoking the token in an “emergency” case (lost phone, phishing attack etc.)
             * - invalidate tokens at user logout time or app uninstall
             * https://leastprivilege.com/2015/11/25/reference-tokens-and-introspection/
             * 
             *'use_jwt_access_tokens' => true,
             */
            'id_lifetime' => 3600,
            'access_lifetime' => 3600
        ));

        // Scopes.
        $scope_util = new Scope($this->get_scopes());
        $this->server->setScopeUtil($scope_util);
        $this->server->addStorage($this->get_scopes(), 'scope');
    }

    /*
     * Scopes could also be stored in the PDO database by "oauth_scopes" table.
     */
    private function get_scopes()
    {
        // Scopes.
        $defaultScope = 'profile';
        $supportedScopes = array(
            'profile',
            'email',
            'groups',
            'resource'
        );
        $memory = new Memory(array(
            'default_scope' => $defaultScope,
            'supported_scopes' => $supportedScopes
        ));
        return $memory;
    }
}
