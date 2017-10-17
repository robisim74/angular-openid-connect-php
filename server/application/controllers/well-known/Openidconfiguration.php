<?php defined('BASEPATH') OR exit('No direct script access allowed');

use SimpleJWT\Keys\KeySet;
use SimpleJWT\Keys\RSAKey;

/*
 * Discovery endpoints. 
 */
class Openidconfiguration extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Allows CORS.
        $this->output->set_header('Access-Control-Allow-Origin: *');
    }

    /* 
     * Discovery document: /.well-known/openid-configuration
     */
    public function index()
    {
        $issuer = $_SERVER['HTTP_HOST'];
        $base_url = $this->config->item('base_url');
        $index_page = $this->config->item('index_page');
        $uri = $base_url . "/" . $index_page;

        $arr = array(
            "issuer" => $issuer,
            "jwks_uri" => $uri . "/.well-known/openid-configuration/jwks",
            "authorization_endpoint" => $uri . "/connect/authorize",
            "token_endpoint" => $uri . "/connect/token",
            "userinfo_endpoint" => $uri . "/connect/userinfo",
            "end_session_endpoint" => $uri . "/connect/endsession",
            "check_session_iframe" => $uri . "/connect/checksession",
            "revocation_endpoint" => $uri . "/connect/revocation",
            "introspection_endpoint" => $uri . "/connect/introspect",
            "scopes_supported" => ["openid", "offline_access", "profile", "roles", "resource"],
            "claims_supported" => ["sub", "username", "first_name", "last_name", "role"],
            "grant_types_supported" => ["implicit"],
            "response_types_supported" => ["id_token token"],
            "subject_types_supported" => ["public"],
            "id_token_signing_alg_values_supported" => ["RS256"]
        );

        echo json_encode($arr, JSON_UNESCAPED_SLASHES);
    }

    /* 
     * JSON Web Key Set [JWK] document: /.well-known/openid-configuration/jwks  
     */
    public function jwks()
    {
        $public_key = file_get_contents($this->get_project_root() . '/data/pubkey.pem');

        // Generates JWK Set.
        $set = new KeySet();
        // Generates JWKs rsa keys from PEM public key.
        $rsa_key = new RSAKey($public_key, 'pem', 'RS256');
        $set->add($rsa_key);
       
        // Build the response.
        $jwks = array(
            "keys" => array()
        );

        $keys = $set->getkeys();
        foreach ($keys as $key) {
            $data = $key->getKeyData();

            $jwk = array(
                "kty" => $data['kty'],
                "use" => 'sig',
                "kid" => $data['kid'],
                "e" => $data['e'],
                "n" => $data['n'],
                "alg" => 'RS256'
            );
            $jwks['keys'][] = $jwk;
        }

        echo json_encode($jwks);
    }

    private function get_project_root()
    {
        return dirname(dirname(dirname(__DIR__)));
    }
}
