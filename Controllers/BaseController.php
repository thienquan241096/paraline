<?php
class BaseController
{
    protected $folder;

    function render($file, $data = array())
    {
        // Kiểm tra file gọi đến có tồn tại hay không?
        $viewFile = 'views/' . $this->folder . '/' . $file . '.php';
        if (is_file($viewFile)) {
            // Nếu tồn tại file đó thì tạo ra các biến chứa giá trị truyền vào lúc gọi hàm
            extract($data);
            // Sau đó lưu giá trị trả về khi chạy file view template với các dữ liệu đó vào 1 biến chứ chưa hiển thị luôn ra trình duyệt
            ob_start();
            require_once($viewFile);
            $content = ob_get_clean();
            // gọi $content->view
            require_once('views/layouts/application.php');
        } else {
            header('Location: index.php?controller=pages&action=error');
        }
    }

    public function renderFontEnd($file, $data = array())
    {
        $viewFile = 'views/' . $this->folder . '/' . $file . '.php';
        if (is_file($viewFile)) {
            extract($data);
            ob_start();
            require_once($viewFile);
            $content = ob_get_clean();
            require_once('views/fontend/layout.php');
        } else {
            header('Location: index.php?controller=pages&action=error');
        }
    }
}