<?php

    session_start();

    // PHP Composer
    // You need to compose the TwitterOAuth
    require 'vendor/autoload.php';
    use Abraham\TwitterOAuth\TwitterOAuth;

    // Load config.php
    require 'config.php';

    if (isset($_REQUEST['oauth_verifier'], $_REQUEST['oauth_token']) && $_REQUEST['oauth_token'] == $_SESSION['oauth_token']) {
        $request_token = [];
        $request_token['oauth_token'] = $_SESSION['oauth_token'];
        $request_token['oauth_token_secret'] = $_SESSION['oauth_token_secret'];
        $connection = new TwitterOAuth($consumer_key, $consumer_secret, $request_token['oauth_token'], $request_token['oauth_token_secret']);
        $access_token = $connection->oauth("oauth/access_token", array("oauth_verifier" => $_REQUEST['oauth_verifier']));
        $_SESSION['access_token'] = $access_token;
        
        // redirect user back to index page
        header('Location: ./');
    }

?>