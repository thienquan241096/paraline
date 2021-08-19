<?php
require_once('app/Controllers/BaseController.php');

use App\Models\UserModel;

class LoginUserController extends BaseController
{
    public function __construct()
    {
        $this->folder = 'user';
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