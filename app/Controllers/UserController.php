<?php
require_once('app/Controllers/BaseController.php');

use App\Models\UserModel;

class UserController extends BaseController
{
    public function __construct()
    {
        if (isset($_SESSION['admin'])) {
            $this->folder = 'user';
        } else {
            ob_start();
            header("Location:?controller=login&action=login");
        }
    }

    public function list()
    {
        $modelUser = new UserModel();
        $listUser = $modelUser->all();
        $this->render('list', compact('listUser'));
    }

    public function postSearch()
    {
        $modelUser = new UserModel();
        $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : "";
        $listUser = $modelUser->search('name', 'email', 'like', "%$keyword%");
        $this->render('listSearch', compact('listUser'));
    }



    public function getEdit()
    {

        $modelUser = new UserModel();
        $detail = $modelUser->find($_GET['id']);
        $this->render('edit', compact('detail'));
    }
    public function postEdit()
    {
        $modelUser = new UserModel();
        $detail = $modelUser->find($_GET['id']);

        if ($_FILES['avatar']['name'] == "") {
            $target_file = $detail->avatar;
        } else {
            $target_file = TARGET_DIR . basename($_FILES["avatar"]["name"]);
            $move = move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file);
        }

        $data = [
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'avatar' => $target_file,
            'status' => $_POST['status'],
        ];

        $modelUser->update($_GET['id'], $data);
        $_SESSION['success_message'] = UPDATE_SUCCESS_MESSAGE;
        header('Location:?controller=user&action=list');
    }

    public function delete()
    {
        $modelUser = new UserModel();
        $detail = $modelUser->find($_GET['id']);
        $data = [
            'del_flag' => DESTROY,
        ];
        $modelUser->delete($_GET['id'], $data);
        $_SESSION['success_message'] = DELETE_SUCCESS_MESSAGE;
        header('Location:?controller=user&action=list');
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