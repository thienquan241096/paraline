<?php

require_once('app/Controllers/BaseController.php');

use App\Models\AdminModel;

class LoginController extends BaseController
{
    public function __construct()
    {
        $this->folder = 'auth';
    }

    public function login()
    {
        if (isset($_POST['btn_submit'])) {
            $modelAdmin = new AdminModel();
            $user = isset($_POST['email']) ? $_POST['email'] : "";
            $password = isset($_POST['password']) ? $_POST['password'] : '';
            $detail = $modelAdmin->findByEmail($user);
            if (isset($detail)) {
                if (!empty($user) && !empty($password)) {
                    $passWordAdmin = $detail->password;
                    if (md5($password) === $passWordAdmin) {
                        $result = $modelAdmin->checkLogin($user, md5($password));
                        $infoUser = [
                            'id' => $result->id,
                            "email" => $result->email,
                            "password" => $result->password,
                            "role_type" => $result->role_type,
                            "del_flag" => $result->del_flag,
                        ];
                        if ($result) {
                            $_SESSION["admin"] = $infoUser;
                            header("Location:?controller=user&action=list");
                        } else {
                            $_SESSION['admin'] = false;
                        }
                    }
                }
            }
        }
        $this->render('login');
    }

    public function logout()
    {
        session_unset();
        session_destroy();
        header('Location:?controller=login&action=login');
    }
}