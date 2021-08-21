<?php

use App\Models\AdminModel;

require_once('app/Controllers/BaseController.php');

class LoginUserController extends BaseController
{
    public function __construct()
    {
        $this->folder = 'user';
    }

    public function info()
    {
        if (isset($_SESSION['id'])) {
            $this->renderFontEnd('info');
        } else {
            ob_start();
            header("Location:?controller=pages&action=home");
        }
    }

    public function login()
    {
        $this->renderFontEnd('login');
    }

    public function logout()
    {
        session_destroy();
        session_unset($_SESSION['access_token']);
        ob_start();
        header('Location:?controller=pages&action=home');
    }
}