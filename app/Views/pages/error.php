<p>
    <?php
    if (!isset($_SESSION['admin'])) {
        echo '<a href="?controller=pages&action=home">Vui lòng đăng nhập</a>';
    } else {
        echo '<p>Lỗi</p>';
    }
    ?>
</p>