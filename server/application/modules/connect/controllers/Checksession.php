<?php defined('BASEPATH') OR exit('No direct script access allowed');

/* 
 * Checksession endpoint.
 * 
 * @see http://openid.net/specs/openid-connect-session-1_0.html
 */
class Checksession extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        // Authentication library.
        $this->load->library('ion_auth');
        
        // OAuth 2.0 Server.
        $this->load->library('OAuth2_server');
    }

    public function index()
    {
        $content = $this->iframe();

        $this->output->set_header('Content-Type: text/html; charset=utf-8');

        echo $content;
    }

    private function iframe()
    {
        $content = <<<EOT
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
        <title>OP iFrame</title>
        <script src="../public/assets/node_modules/crypto-js/crypto-js.js"></script>
    </head>
    <body>
        <script type='text/javascript'>
            window.addEventListener("message", receiveMessage, false);
            
            function getCookie(c_name) {
                var i, x, y, ARRcookies = document.cookie.split(";");
                for (i = 0; i < ARRcookies.length; i++) {
                    x = ARRcookies[i].substr(0, ARRcookies[i].indexOf("="));
                    y = ARRcookies[i].substr(ARRcookies[i].indexOf("=") + 1);
                    x = x.replace(/^\s+|\s+$/g, "");
                    if (x == c_name) {
                        return unescape(y);
                    }
                }
            }
            
            function receiveMessage(e) {
                var client_id = e.data.split(' ')[0];
                var session_state = e.data.split(' ')[1];
                var salt = session_state.split('.')[1];
                
                var opbs = getCookie('opbs');
                var ss = CryptoJS.SHA256(client_id + e.origin + opbs + salt) + "." + salt;

                var state = '';
                if (session_state == ss) {
                    state = 'unchanged';
                } else {
                    state = 'changed';
                }
                e.source.postMessage(state, e.origin);
            };
        </script>
    </body>
</html>
EOT;

        return $content;
    }
}
