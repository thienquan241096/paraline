<?php
require_once('Controllers/BaseController.php');

class PagesController extends BaseController
{
    function __construct()
    {
        $this->folder = 'pages';
    }

    public function home()
    {
        $info = array(
            'name' => 'Quan Kul',
            'age' => 25
        );
        $this->render('home', compact('info'));
    }

    public function error()
    {
        $this->render('error');
    }
}