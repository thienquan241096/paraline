<?php
require_once('app/Controllers/BaseController.php');
require_once './common_const.php';

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
        $listAdmin = $modelAdmin::all();
        $this->render('list', compact('listAdmin'));
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
        $modelAdmin = new AdminModel();
        if (isset($_FILES['avatar'])) {
            $target_file = TARGET_DIR . basename($_FILES["avatar"]["name"]);
            $move = move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file);
        }

        $data = [
            'name' => isset($_POST['name']) ? $_POST['name'] : "",
            'email' => isset($_POST['email']) ? $_POST['email'] : "",
            'password' => isset($_POST['password']) ? md5($_POST['password']) : "",
            'avatar' => $target_file,
            'role_type' => $_POST['role_type'],

        ];
        $modelAdmin::insert($data);
        $_SESSION['success_message'] = CREATE_SUCCESS_MESSAGE;
        header("Location:?controller=admin&action=list");
    }

    public function getEdit()
    {

        $modelAdmin = new AdminModel();
        $detail = $modelAdmin->find($_GET['id']);
        $this->render('edit', compact('detail'));
    }
    public function postEdit()
    {
        $modelAdmin = new AdminModel();
        $detail = $modelAdmin->find($_GET['id']);
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
            'name' => isset($_POST['name']) ? $_POST['name'] : "",
            'email' => isset($_POST['email']) ? $_POST['email'] : "",
            'password' => $password,
            'avatar' => $target_file,
            'role_type' => $_POST['role_type'],
        ];

        $modelAdmin->update($_GET['id'], $data);
        $_SESSION['success_message'] = UPDATE_SUCCESS_MESSAGE;
        header('Location:?controller=admin&action=list');
    }

    public function delete()
    {
        $modelAdmin = new AdminModel();
        $detail = $modelAdmin->find($_GET['id']);
        $data = [
            // 'upd_id' => $_SESSION['admin']['id'],
            'del_flag' => DESTROY,
        ];
        $modelAdmin->delete($_GET['id'], $data);
        $_SESSION['success_message'] = DELETE_SUCCESS_MESSAGE;
        header('Location:?controller=admin&action=list');
    }
}