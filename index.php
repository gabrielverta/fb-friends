<?php

require("vendor/autoload.php");

use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookSession;

class SocialException extends Exception {}

class FB {

    const REDIRECT_URL = "http://localhost:8000/";
    const SCOPE = "user_friends";

    public function __construct($app_id, $app_secret)
    {
        FacebookSession::setDefaultApplication($app_id, $app_secret);
    }

    /**
     * @return mixed
     * @throws \Facebook\FacebookRequestException
     */
    public function getFriends()
    {
        $session = $this->login();
        $request = new FacebookRequest($session, 'GET', '/me/friends');
        return $request->execute()->getGraphObjectList();

    }

    /**
     * Devolve a sessão atual do usuário ou redireciona para o login
     * @return FacebookSession|null|void
     */
    public function login(){
        if($this->checkLogin())
        {
            return new FacebookSession($_SESSION["token"]);
        }

        $helper = new FacebookRedirectLoginHelper(static::REDIRECT_URL);
        if(!array_key_exists("code", $_GET))
        {
            return $this->redirectToLogin($helper);
        }

        $session = $helper->getSessionFromRedirect();
        $_SESSION["token"] = $session->getToken();

        return $session;
    }

    /**
     * @return bool
     */
    private function checkLogin()
    {
        return array_key_exists("token", $_SESSION);
    }

    /**
     * @param $helper
     */
    public function redirectToLogin($helper)
    {
        header("Location: " . $helper->getLoginUrl($this->getScope()));
        exit;
    }

    /**
     * @return array
     */
    public function getScope()
    {
        return explode(",", static::SCOPE);
    }

}

$fb = new FB("APP_ID", "APP_SECRET");
$friends = $fb->getFriends();
var_dump($friends);