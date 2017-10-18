<?php defined('BASEPATH') OR exit('No direct script access allowed');

use OAuth2\Scope;
use SimpleJWT\Keys\KeySet;
use SimpleJWT\Keys\RSAKey;

/*
 * Discovery endpoints.
 * @see https://openid.net/specs/openid-connect-discovery-1_0.html
 */
class Openid_Configuration extends OAuth2_Server
{
    public function __construct()
    {
        parent::__construct();
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

        $scope_util = new Scope();
        $reserved_scopes = $scope_util->getReservedScopes();
        $memory = $this->server->getStorage('scope');
        $scopes = $memory->supportedScopes;
        $scopes_supported = array_merge($reserved_scopes, $scopes);

        $standard_claims = array("sub");
        // PDO Storage implements UserClaimsInterface, with the following constants.
        $profile_claims = explode(" ", $this->storage::PROFILE_CLAIM_VALUES);
        $email_claims = explode(" ", $this->storage::EMAIL_CLAIM_VALUES);
        $address_claims = explode(" ", $this->storage::ADDRESS_CLAIM_VALUES);
        $phone_claims = explode(" ", $this->storage::PHONE_CLAIM_VALUES);
        $claims_supported = array_merge(
            $standard_claims,
            $profile_claims,
            $email_claims,
            $address_claims,
            $phone_claims
        );

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
            "scopes_supported" => $scopes_supported,
            "claims_supported" => $claims_supported,
            "grant_types_supported" => ["implicit"],
            "response_types_supported" => ["id_token token"],
            "subject_types_supported" => ["public"],
            "id_token_signing_alg_values_supported" => ["RS256"]
        );

        echo json_encode($arr, JSON_UNESCAPED_SLASHES);
    }

    /* 
     * JSON Web Key Set [JWK] document: /.well-known/openid-configuration/jwks  
     * @see https://tools.ietf.org/html/rfc7517
     */
    public function jwks()
    {
        $memory = $this->server->getStorage('public_key');
        $public_key = $memory->getPublicKey();

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
}
