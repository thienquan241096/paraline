<?php
require_once('Controllers/BaseController.php');

require_once './Models/AdminModel.php';

class AdminController extends BaseController
{
    public function __construct()
    {
        $this->folder = 'admin';
    }

    public function list()
    {
        if ($_SESSION['admin']["role_type"] == ROLE_TYPE_SUPPERADMIN) {
            $modelAdmin = new AdminModel();
            $listAdmin = $modelAdmin->all();
            $this->render('list', compact('listAdmin'));
        } else {
            ob_start();
            header("Location:?controller=login&action=login");
        }
    }

    public function getInsert()
    {
        if ($_SESSION['admin']["role_type"] == ROLE_TYPE_SUPPERADMIN) {
            $this->render('insert');
        } else {
            ob_start();
            header("Location:?controller=login&action=login");
        }
    }

    public function postInsert()
    {
        $modelAdmin = new AdminModel();
        if (isset($_FILES['avatar'])) {
            $target_dir = "public/image/"; //định nghĩa đường dẫn
            $target_file = $target_dir . basename($_FILES["avatar"]["name"]); //tên file
            // var_dump($target_file);
            $move = move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file); //chuyển vào thư mục Public/image
        }

        $data = [
            'name' => isset($_POST['name']) ? $_POST['name'] : "",
            'email' => isset($_POST['email']) ? $_POST['email'] : "",
            'password' => isset($_POST['password']) ? md5($_POST['password']) : "",
            'avatar' => $target_file,
            'role_type' => $_POST['role_type'],
            'ins_id' => $_SESSION['admin']['id'],
            'upd_id' => $_SESSION['admin']['id'],
            'ins_datetime' => INS_DATETIME,
            'upd_datetime' => UPD_DATETIME,
            'del_flag' => DEL_FALG,
        ];
        $modelAdmin->insert($data);
        header("Location:?controller=admin&action=list");
    }

    public function getEdit()
    {
        if ($_SESSION['admin']["role_type"] == ROLE_TYPE_SUPPERADMIN) {

            $modelAdmin = new AdminModel();
            $detail = $modelAdmin->find($_GET['id']);
            $this->render('edit', compact('detail'));
        } else {
            ob_start();
            header("Location:?controller=login&action=login");
        }
    }
    public function postEdit()
    {
        $modelAdmin = new AdminModel();
        $detail = $modelAdmin->find($_GET['id']);
        // var_dump($detail->avatar);
        // die;
        if ($_FILES['avatar']['name'] == "") {
            $target_file = $detail->avatar;
        } else {
            $target_file = TARGET_DIR . basename($_FILES["avatar"]["name"]); //tên file
            $move = move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file); //chuyển vào thư mục Public/image
        }

        if (empty($_POST['password'])) {
            $password = $detail->password;
        } else {
            $password = md5($_POST['password']);
        }

        $data = [
            'name' => isset($_POST['name']) ? $_POST['name'] : "",
            'email' => isset($_POST['email']) ? $_POST['email'] : "",
            'password' => $password,
            'avatar' => $target_file,
            'role_type' => $_POST['role_type'],
            'ins_id' => $detail->ins_id,
            'upd_id' => $_SESSION['admin']['id'],
            'ins_datetime' => $detail->ins_datetime,
            'upd_datetime' => UPD_DATETIME,
            'del_flag' => DEL_FALG,
        ];

        $modelAdmin->update($_GET['id'], $data);
        header('Location:?controller=admin&action=list');
    }

    public function delete()
    {
        if ($_SESSION['admin']["role_type"] == ROLE_TYPE_SUPPERADMIN) {
            $modelAdmin = new AdminModel();
            $detail = $modelAdmin->find($_GET['id']);
            $data = [
                'upd_id' => $_SESSION['admin']['id'],
                'upd_datetime' => UPD_DATETIME,
                'del_flag' => DESTROY,
            ];
            $modelAdmin->delete($_GET['id'], $data);
            header('Location:?controller=admin&action=list');
        } else {
            ob_start();
            header("Location:?controller=login&action=login");
        }
    }
}