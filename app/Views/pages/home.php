<p>
    Họ tên : <?= $info['name'] ?>
</p>
<p>
    Tuổi : <?= $info['age'] ?>
</p>

<?php
if (isset($_SESSION['admin'])) {
    echo "<p><a class='btn btn-primary' href='?controller=login&action=logout' >Đăng xuất</a></p>";
} else {
    echo "<p>
            <a class='btn btn-primary' href='?controller=login&action=login'>Đăng nhập Admin</a></p>
        <p>
            <a class='btn btn-primary' href='?controller=loginUser&action=login'>Đăng nhập User FB</a>
        </p>
        ";
}
?>