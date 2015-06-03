<?php
//FacebookSession::setDefaultApplication('1852902498267705','6bbac720e88bc6da5877e95a4ef3ca31');

// include required files form Facebook SDK
//class Fbtest extends Controller
//{}
require_once ('vendor/facebook-php-sdk-v4/src/Facebook/HttpClients/FacebookHttpable.php');
require_once ('vendor/facebook-php-sdk-v4/src/Facebook/HttpClients/FacebookCurl.php');
require_once ('vendor/facebook-php-sdk-v4/src/Facebook/HttpClients/FacebookCurlHttpClient.php');

require_once ('vendor/facebook-php-sdk-v4/src/Facebook/Entities/AccessToken.php');
require_once ('vendor/facebook-php-sdk-v4/src/Facebook/Entities/SignedRequest.php');

require_once ('vendor/facebook-php-sdk-v4/src/Facebook/FacebookSession.php');
require_once ('vendor/facebook-php-sdk-v4/src/Facebook/FacebookRedirectLoginHelper.php');
require_once ('vendor/facebook-php-sdk-v4/src/Facebook/FacebookRequest.php');
require_once ('vendor/facebook-php-sdk-v4/src/Facebook/FacebookResponse.php');
require_once ('vendor/facebook-php-sdk-v4/src/Facebook/FacebookSDKException.php');
require_once ('vendor/facebook-php-sdk-v4/src/Facebook/FacebookRequestException.php');
require_once ('vendor/facebook-php-sdk-v4/src/Facebook/FacebookOtherException.php');
require_once ('vendor/facebook-php-sdk-v4/src/Facebook/FacebookAuthorizationException.php');
require_once ('vendor/facebook-php-sdk-v4/src/Facebook/GraphObject.php');
require_once ('vendor/facebook-php-sdk-v4/src/Facebook/GraphSessionInfo.php');

    use Facebook\HttpClients\FacebookHttpable;
    use Facebook\HttpClients\FacebookCurl;
    use Facebook\HttpClients\FacebookCurlHttpClient;

    use Facebook\Entities\AccessToken;
    use Facebook\Entities\SignedRequest;

    use Facebook\FacebookSession;
    use Facebook\FacebookRedirectLoginHelper;
    use Facebook\FacebookRequest;
    use Facebook\FacebookResponse;
    use Facebook\FacebookSDKException;
    use Facebook\FacebookRequestException;
    use Facebook\FacebookOtherException;
    use Facebook\FacebookAuthorizationException;
    use Facebook\GraphObject;
    use Facebook\GraphSessionInfo;

// start session
session_start();

// init app with app id and secret
FacebookSession::setDefaultApplication('1852902498267705', '6bbac720e88bc6da5877e95a4ef3ca31s');

// login helper with redirect_uri
$helper = new FacebookRedirectLoginHelper('http://localhost/login');

// see if a existing session exists
if (isset($_SESSION) && isset($_SESSION['fb_token']))
{
    // create new session from saved access_token
$session = new FacebookSession($_SESSION['fb_token']);

    // validate the access_token to make sure it's still valid
try
{
if (!$session->validate())
{
$session = null;
}
} catch
(Exception $e ) {
    // catch any exceptions
    $session = null;
}
}

if (!isset($session) || $session === null) {
    // no session exists

    try {
        $session = $helper->getSessionFromRedirect();
    } catch (FacebookRequestException $ex) {
        // When Facebook returns an error
        // handle this better in production code
        print_r($ex);
    } catch (Exception $ex) {
        // When validation fails or other local issues
        // handle this better in production code
        print_r($ex);
    }

}

// see if we have a session
if (isset($session)) {

    // save the session
    $_SESSION['fb_token'] = $session->getToken();
    // create a session using saved token or the new one we generated at login
    $session = new FacebookSession($session->getToken());

    // graph api request for user data
    $request = new FacebookRequest($session, 'GET', '/me');
    $response = $request->execute();
    // get response
    $graphObject = $response->getGraphObject()->asArray();

    // print profile data
    echo '<pre>' . print_r($graphObject, 1) . '</pre>';

    // print logout url using session and redirect_uri (logout.php page should destroy the session)
    echo '<a href="' . $helper->getLogoutUrl($session, 'http://yourwebsite.com/app/logout.php') . '">Logout</a>';

} else {
    // show login url
    echo '<a href="' . $helper->getLoginUrl(array('email', 'user_friends')) . '">Login</a>';
}
