<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use OAuth2\Response;
use OAuth2\Server as OAuth2Server;
use OAuth2\Storage\Pdo;
use OAuth2\Storage\Memory;
use OAuth2\Scope;

/*
 * OAuth 2.0 Server configuration.
 */
class OAuth2_server extends CI_Controller
{
    protected $storage;
    protected $server;

    protected $dsn;
    protected $username;
    protected $password;

    public function __construct()
    {
        parent::__construct();
        // Allows CORS.
        $this->output->set_header('Access-Control-Allow-Origin: *');
        $this->output->set_header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        $this->output->set_header('Access-Control-Allow-Headers: Content-Type, Authorization');

        $this->load->database();
        $this->load->library('ion_auth');

        // Gets database config values.
        $this->dsn = $this->db->dsn;
        $this->username = $this->db->username;
        $this->password = $this->db->password;

        $this->setup();
    }

    private function setup()
    {
        // Uses Ion Auth "users" table as OAuth2 user_table.
        //
        // To match claims, you need to redefine the "users" table attributes.
        // http://openid.net/specs/openid-connect-core-1_0.html#Claims
        $config = array(
            'user_table' => 'users'
        );
        $this->storage = new Pdo(array(
            'dsn' => $this->dsn, 'username' => $this->username, 'password' => $this->password
        ), $config);
                
        // Instantiates the OAuth 2.0 Server.
        $this->server = new OAuth2Server($this->storage, array(
            'enforce_state' => true,
            'allow_implicit' => true,
            'use_openid_connect' => true,
            'issuer' => $_SERVER['HTTP_HOST'],
            'use_jwt_access_tokens' => true,
            'encryption_algorithm' => 'RS256'
        ));

        // In memory.
        $this->server->addStorage($this->get_key_storage(), 'public_key');

        $scope_util = new Scope($this->get_scopes());
        $this->server->setScopeUtil($scope_util);
        $this->server->addStorage($this->get_scopes(), 'scope');
    }

    /*
     * Keys could also be stored in the PDO database by "oauth_public_keys" table.
     */
    private function get_key_storage()
    {
        $public_key = file_get_contents($this->get_project_root() . '/data/pubkey.pem');
        $private_key = file_get_contents($this->get_project_root() . '/data/privkey.pem');
        $memory = new Memory(array('keys' => array(
            'public_key' => $public_key,
            'private_key' => $private_key,
        )));
        return $memory;
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

    private function get_project_root()
    {
        return dirname(dirname(__DIR__));
    }
}