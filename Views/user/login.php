<div class="container">
    <br />
    <h2 align="center">PHP Login using Facebok Account</h2>
    <br />
    <div class="panel panel-default">
        <?php
        if (isset($facebookLoginUrl)) {
            echo $facebookLoginUrl;
        } else {
            echo '<div class="panel-heading">Welcome User</div><div class="panel-body">';
            echo '<img src="' . $_SESSION["image"] . '" class="img-responsive img-circle img-thumbnail" />';
            echo '<h3><b>Name :</b> ' . $_SESSION['name'] . '</h3>';
            echo '<h3><b>Email :</b> ' . $_SESSION['email_address'] . '</h3>';
            echo '<h3><a href="?controller=user&action=logout">Logout</h3></div>';
        }
        ?>
    </div>
</div>