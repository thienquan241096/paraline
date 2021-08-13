<?php
require_once('Controllers/BaseController.php');
require_once './vendor/autoload.php';

require_once './Models/UserModel.php';

class UserController extends BaseController
{
    public function __construct()
    {
        $this->folder = 'user';
    }

    public function list()
    {
        if (isset($_SESSION['admin'])) {
            $modelUser = new UserModel();
            $listUser = $modelUser->all();
            // echo '<pre>';
            // var_dump($listUser);
            // die;
            $this->render('list', compact('listUser'));
        } else {
            ob_start();
            header("Location:?controller=login&action=login");
        }
    }

    public function getEdit()
    {
        if ($_SESSION['admin']) {

            $modelUser = new UserModel();
            $detail = $modelUser->find($_GET['id']);
            $this->render('edit', compact('detail'));
        } else {
            ob_start();
            header("Location:?controller=login&action=login");
        }
    }
    public function postEdit()
    {
        $modelUser = new UserModel();
        $detail = $modelUser->find($_GET['id']);
        // var_dump($detail->avatar);
        // die;
        if ($_FILES['avatar']['name'] == "") {
            $target_file = $detail->avatar;
        } else {
            $target_file = TARGET_DIR . basename($_FILES["avatar"]["name"]);
            $move = move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file);
        }

        if (empty($_POST['password'])) {
            $password = $detail->password;
        } else {
            $password = md5($_POST['password']);
        }

        $data = [
            // 'name' => isset($_POST['name']) ? $_POST['name'] : "",
            // 'email' => isset($_POST['email']) ? $_POST['email'] : "",
            // 'password' => $password,
            // 'avatar' => $target_file,
            // 'role_type' => $_POST['role_type'],
            // 'ins_id' => $detail->ins_id,
            // 'upd_id' => $_SESSION['admin']['id'],
            // 'ins_datetime' => $detail->ins_datetime,
            // 'upd_datetime' => UPD_DATETIME,
            // 'del_flag' => DEL_FALG,
        ];

        $modelUser->update($_GET['id'], $data);
        header('Location:?controller=user&action=list');
    }


    public function login()
    {
        if (!session_id()) {
            session_start();
        }

        $facebook = new \Facebook\Facebook([
            'app_id'      => '521651122531343',
            'app_secret'     => '079ecdfdb25ea2632c8266ff6eedb8ab',
            'default_graph_version'  => 'v2.10'
        ]);

        $facebook_output = '';

        $facebookHelper = $facebook->getRedirectLoginHelper();
        // var_dump($facebookHelper);
        // die;
        if (isset($_GET['code'])) {
            if (isset($_SESSION['access_token'])) {
                $accessToken = $_SESSION['access_token'];
            } else {
                $accessToken = $facebookHelper->getAccessToken();

                $_SESSION['access_token'] = $accessToken;

                $facebook->setDefaultAccessToken($_SESSION['access_token']);
                // var_dump($facebook->setDefaultAccessToken($_SESSION['access_token']));
                // die;
            }

            $_SESSION['id'] = '';
            $_SESSION['name'] = '';
            $_SESSION['email_address'] = '';
            $_SESSION['image'] = '';


            $graph_response = $facebook->get("/me?fields=name,email", $accessToken);

            $facebookUserInfo = $graph_response->getGraphUser();

            $modelUser = new UserModel();
            // $name, $facebook_id, $email, $avatar, $status = 1, $ins_id, $upd_id, $ins_datetime, $upd_datetime, $del_flag = 0
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
                $data = [
                    'name' => $name,
                    'email' => $email,
                    'facebook_id' => $facebook_id,
                    'avatar' => $avatar,
                    'del_flag' => DEL_FALG,
                ];
                $modelUser->insert($data);
            }
        } else {
            $facebookPermissions = ['email']; // quyền

            $facebookLoginUrl = $facebookHelper->getLoginUrl('http://localhost/paraline/login', $facebookPermissions);

            // hiển thị btn
            $facebookLoginUrl = '<div align="center"><a href="' . $facebookLoginUrl . '"><img src="php-login-with-facebook.gif" /></a></div>';
        }
        $this->renderFontEnd('login');
    }

    public function logout()
    {
        session_destroy();
        session_unset($_SESSION['access_token']);
        ob_start();
        header('Location:/paraline/login');
    }
}