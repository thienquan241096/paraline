<div class="container">
    <h2>Info User</h2>
    <div>
        <?php
        echo '<div class="panel-heading">Welcome User</div><div class="panel-body">';
        echo '<div><img src="' . $_SESSION["image"] . '" class="img-responsive img-circle img-thumbnail" /></div>';
        echo '<h3><b>Name :</b> ' . $_SESSION['name'] . '</h3>';
        echo '<h3><b>Email :</b> ' . $_SESSION['email_address'] . '</h3>';
        ?>
    </div>
    <h3><a href="?controller=loginUser&action=logout">Logout</h3>
</div>
<?php
// phpinfo();
?>