<?php
require_once('app/Controllers/BaseController.php');

use App\Models\AdminModel;

class AdminController extends BaseController
{

    public function __construct()
    {
        if (isset($_SESSION['admin']['role_type']) && $_SESSION['admin']['role_type'] == ROLE_TYPE_SUPPERADMIN) {
            $this->folder = 'admin';
        }
    }

    public function list()
    {
        $modelAdmin = new AdminModel();
        $listAdmin = $modelAdmin->paginate();
        $this->render('list', compact('listAdmin'));
    }

    public function listDelete()
    {
        $modelAdmin = new AdminModel();
        $listAdminDelete = $modelAdmin->historyDelete();
        $this->render('listDelete', compact('listAdminDelete'));
    }

    public function postSearch()
    {
        $modelAdmin = new AdminModel();
        $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : "";
        $listAdmin = $modelAdmin::search('name', 'email', 'like', "%$keyword%");
        $this->render('listSearch', compact('listAdmin'));
    }


    public function getInsert()
    {
        $this->render('insert');
    }

    public function postInsert()
    {
        $arrTypeImg = ['image/bmp', 'image/jpeg', 'image/png'];

        $err = [];
        $listAdmin = AdminModel::all();
        $email = isset($_POST['email']) ? $_POST['email'] : "";

        foreach ($listAdmin as $value) {
            if (empty($email)) {
                $err['email'] = 'k để trống';
            }
            if ($email === $value->email) {
                $err['email'] = 'email tồn tại';
            }
        }

        if (isset($_FILES['avatar'])) {
            if (!in_array($_FILES['avatar']['type'], $arrTypeImg)) {
                $err['avatar'] = 'k đúng định dạng ảnh';
            }
            if ($_FILES['avatar']['size'] > 5000000) {
                $err['avatar'] = 'nhập lại';
            }
        }

        if (!empty($err)) {
            $this->render('insert', compact('err'));
        } else {
            if (isset($_FILES['avatar'])) {
                $target_file = TARGET_DIR . basename($_FILES["avatar"]["name"]);
                $move = move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file);
            }
            $data = [
                'name' => isset($_POST['name']) ? $_POST['name'] : "",
                'email' => $email,
                'password' => isset($_POST['password']) ? md5($_POST['password']) : "",
                'avatar' => $target_file,
                'role_type' => $_POST['role_type'],

            ];
            AdminModel::insert($data);
            $_SESSION['success_message'] = CREATE_SUCCESS_MESSAGE;
            header("Location:?controller=admin&action=list");
        }
    }

    public function getEdit()
    {
        $modelAdmin = new AdminModel();
        $detail = $modelAdmin->find($_GET['id']);
        $this->render('edit', compact('detail'));
    }
    public function postEdit()
    {
        $arrTypeImg = ['image/bmp', 'image/jpeg', 'image/png'];
        $err = [];
        $detail = AdminModel::find($_GET['id']);
        $email = isset($_POST['email']) ? $_POST['email'] : "";
        $listEmail = AdminModel::findEmailByID($_GET['id']);
        foreach ($listEmail as $value) {
            if (empty($email)) {
                $err['email'] = 'k để trống';
            }
            if ($email === $value->email) {
                $err['email'] = 'email tồn tại';
            }
        }

        if ($_FILES['avatar']['name'] == "") {
            $target_file = $detail->avatar;
            $err = "";
        } else {
            if (!in_array($_FILES['avatar']['type'], $arrTypeImg)) {
                $err['avatar'] = 'k đúng định dạng ảnh';
            }
            if ($_FILES['avatar']['size'] > 500000) {
                $err['avatar'] = 'nhập lại';
            }
            if (in_array($_FILES['avatar']['type'], $arrTypeImg) && $_FILES['avatar']['size'] < 500000) {
                $err = "";
                $target_file = TARGET_DIR . basename($_FILES["avatar"]["name"]);
                $move = move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file);
            }
        }

        if (!empty($err)) {
            $this->render('edit', compact('err', 'detail'));
        } else {
            if (empty($_POST['password'])) {
                $password = $detail->password;
            } else {
                $password = md5($_POST['password']);
            }
            $data = [
                'name' => isset($_POST['name']) ? $_POST['name'] : "",
                'email' => $email,
                'password' => $password,
                'avatar' => $target_file,
                'role_type' => $_POST['role_type'],
            ];
            AdminModel::update($_GET['id'], $data);
            $_SESSION['success_message'] = UPDATE_SUCCESS_MESSAGE;
            header('Location:?controller=admin&action=list');
        }
    }

    public function delete()
    {
        $modelAdmin = new AdminModel();
        $detail = $modelAdmin->find($_GET['id']);
        $data = [
            'del_flag' => DESTROY,
        ];
        $modelAdmin->delete($_GET['id'], $data);
        $_SESSION['success_message'] = DELETE_SUCCESS_MESSAGE;
        header('Location:?controller=admin&action=list');
    }
}