<?php

use App\Models\UserModel;

if (!session_id()) {
    session_start();
}

$facebook = new \Facebook\Facebook([
    'app_id'      => '521651122531343',
    'app_secret'     => '079ecdfdb25ea2632c8266ff6eedb8ab',
    'default_graph_version'  => 'v11.0'
]);

$facebook_output = '';

$facebookHelper = $facebook->getRedirectLoginHelper();

if (isset($_GET['code'])) {
    if (isset($_SESSION['access_token'])) {
        $accessToken = $_SESSION['access_token'];
    } else {
        $accessToken = $facebookHelper->getAccessToken();

        $_SESSION['access_token'] = $accessToken;

        $facebook->setDefaultAccessToken($_SESSION['access_token']);
    }

    $_SESSION['id'] = '';
    $_SESSION['name'] = '';
    $_SESSION['email_address'] = '';
    $_SESSION['image'] = '';


    $graph_response = $facebook->get("/me?fields=name,email", $accessToken);

    $facebookUserInfo = $graph_response->getGraphUser();

    $modelUser = new UserModel();


    if (!empty($facebookUserInfo)) {
        if (!empty($facebookUserInfo['id'])) {
            $_SESSION['image'] = 'http://graph.facebook.com/' . $facebookUserInfo['id'] . '/picture';
        }

        if (!empty($facebookUserInfo['name'])) {
            $_SESSION['name'] = $facebookUserInfo['name'];
        }

        if (!empty($facebookUserInfo['email'])) {
            $_SESSION['email_address'] = $facebookUserInfo['email'];
        }
        $name = $facebookUserInfo['name'];
        $facebook_id = $facebookUserInfo['id'];
        $email = $facebookUserInfo['email'];
        $avatar = 'http://graph.facebook.com/' . $facebookUserInfo['id'] . '/picture';

        $listUser = $modelUser->all();
        $arrFacebookID = [];
        foreach ($listUser as $key) {
            array_push($arrFacebookID, $key->facebook_id);
        }
        if (!in_array($facebook_id, $arrFacebookID)) {
            $data = [
                'name' => $name,
                'email' => $email,
                'facebook_id' => $facebook_id,
                'avatar' => $avatar,
                'status' => STATUS,
                'del_flag' => DEL_FALG,
            ];
            $modelUser->insert($data);
        }
    }
} else {
    $facebookPermissions = ['email']; // quyền

    $facebookLoginUrl = $facebookHelper->getLoginUrl('http://localhost/paraline/?controller=loginUser&action=login');
    $facebookLoginUrl = '<div align="center"><a href="' . $facebookLoginUrl . '"><img src="php-login-with-facebook.gif" /></a></div>';
}

?>
<div class="container">
    <h2 align="center">PHP Login using Facebok Account</h2>
    <br />
    <div class="panel panel-default">
        <?php
        if (isset($facebookLoginUrl)) {
            echo $facebookLoginUrl;
        } else {
            echo '<div class="panel-heading">Welcome User</div><div class="panel-body">';
            echo '<img src="' . $_SESSION["image"] . '" class="img-responsive img-circle img-thumbnail" />';
            echo '<h3><b>Name :</b> ' . $_SESSION['name'] . '</h3>';
            echo '<h3><b>Email :</b> ' . $_SESSION['email_address'] . '</h3>';
            echo '<h3><a href="?controller=loginUser&action=logout">Logout</h3></div>';
        }
        ?>
    </div>
</div>