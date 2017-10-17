<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use OAuth2\Response;
use OAuth2\Server as OAuth2Server;
use OAuth2\Storage\Pdo;
use OAuth2\Storage\Memory;

class Server_model extends CI_Model
{
    public $storage;

    public $server;

    private $dsn;
    private $username;
    private $password;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();

        // Gets database config values.
        $this->dsn = $this->db->dsn;
        $this->username = $this->db->username;
        $this->password = $this->db->password;

        $this->setup();
    }

    public function setup()
    {
        $this->storage = new Pdo(array('dsn' => $this->dsn, 'username' => $this->username, 'password' => $this->password));
                
        // Instantiates the OAuthn 2.0 server.
        $this->server = new OAuth2Server($this->storage, array(
            'enforce_state' => true,
            'allow_implicit' => true,
            'use_openid_connect' => true,
            'issuer' => $_SERVER['HTTP_HOST'],
            'use_jwt_access_tokens' => true,
            'encryption_algorithm' => 'RS256'
        ));

        $this->server->addStorage($this->get_key_storage(), 'public_key');
    }

    private function get_key_storage()
    {
        $public_key = file_get_contents($this->get_project_root() . '/data/pubkey.pem');
        $private_key = file_get_contents($this->get_project_root() . '/data/privkey.pem');
        $keyStorage = new Memory(array('keys' => array(
            'public_key' => $public_key,
            'private_key' => $private_key,
        )));
        return $keyStorage;
    }

    private function get_project_root()
    {
        return dirname(dirname(__DIR__));
    }
}