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

    public function postSearch()
    {
        if (isset($_SESSION['admin'])) {
            $modelUser = new UserModel();
            $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : "";
            $listUser = $modelUser->search('name', 'email', 'like', "%$keyword%");
            $this->render('listSearch', compact('listUser'));
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
            // var_dump($detail);
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

        if ($_FILES['avatar']['name'] == "") {
            $target_file = $detail->avatar;
        } else {
            $target_file = TARGET_DIR . basename($_FILES["avatar"]["name"]); //tên file
            $move = move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file); //chuyển vào thư mục Public/image
        }

        $data = [
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'avatar' => $target_file,
            'status' => $_POST['status'],
            'ins_id' => $detail->ins_id,
            'upd_id' => $_SESSION['admin']['id'],
            'ins_datetime' => $detail->ins_datetime,
            'upd_datetime' => UPD_DATETIME,
            'del_flag' => DEL_FALG,
        ];

        $modelUser->update($_GET['id'], $data);
        header('Location:?controller=user&action=list');
    }

    public function delete()
    {
        if ($_SESSION['admin']) {
            $modelUser = new UserModel();
            $detail = $modelUser->find($_GET['id']);
            $data = [
                'upd_id' => $_SESSION['admin']['id'],
                'upd_datetime' => UPD_DATETIME,
                'del_flag' => DESTROY,
            ];
            $modelUser->delete($_GET['id'], $data);
            header('Location:?controller=user&action=list');
        } else {
            ob_start();
            header("Location:?controller=login&action=login");
        }
    }


    public function login()
    {
        $this->renderFontEnd('login');
    }

    public function logout()
    {
        // var_dump(1);
        // die;
        session_destroy();
        session_unset($_SESSION['access_token']);
        ob_start();
        header('Location:?controller=pages&action=home');
    }
}