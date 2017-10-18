<?php defined('BASEPATH') OR exit('No direct script access allowed');

use OAuth2\OpenID\Storage\UserClaimsInterface;

class OAuth2_Server_model extends CI_Model implements UserClaimsInterface
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Return claims about the provided user id.
     *
     * Groups of claims are returned based on the requested scopes. No group
     * is required, and no claim is required.
     *
     * @param mixed  $user_id - The id of the user for which claims should be returned.
     * @param string $scope   - The requested scope.
     * Scopes with matching claims: profile, email, address, phone.
     *
     * @return array - An array in the claim => value format.
     *
     * @see http://openid.net/specs/openid-connect-core-1_0.html#ScopeClaims
     */
    public function getUserClaims($user_id, $scope)
    {

    }
}
