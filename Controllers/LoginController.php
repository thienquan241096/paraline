<?php
require_once('Controllers/BaseController.php');

require_once './Models/AdminModel.php';

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
            $detail = $modelAdmin->findByEmail($user); // checkemail -> lấy pass
            if (isset($detail)) {
                $passWordAdmin = $detail->password;
                if (!empty($user) && !empty($password)) {
                    if (md5($password) === $passWordAdmin) {
                        $result = $modelAdmin->checkLogin($user, md5($password));
                        var_dump($result);
                        $infoUser = [
                            'id' => $result->id,
                            "email" => $result->email,
                            "password" => $result->password,
                            "role_type" => $result->role_type,
                            "del_flag" => $result->del_flag,
                        ];
                        if ($result) {
                            $_SESSION["admin"] = $infoUser;
                            // var_dump($_SESSION["admin"]);
                            header("Location:?controller=admin&action=list");
                        } else {
                            echo ' ko tc';
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