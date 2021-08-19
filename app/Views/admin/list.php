<div class="container">
    <div class="row">
        <div class="col-6">
            <form class="d-flex" action="?controller=admin&action=postSearch" method="POST">
                <input class="form-control me-2" type="search" placeholder="name , email ..." name="keyword">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
        </div>
        <div class="col-2 d-flex justify-content-center">
            <a name="" id="" class="btn btn-info" href="?controller=admin&action=list" role="button">List Admin</a>
        </div>
        <div class="col-2 d-flex justify-content-center">
            <a name="" id="" class="btn btn-warning" href="?controller=admin&action=listDelete" role="button">List
                Delete</a>
        </div>
        <div class="col-2 d-flex justify-content-center">
            <a name="" id="" class="btn btn-primary" href="?controller=admin&action=getInsert" role="button">Add
                Admin</a>
        </div>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">STT</th>
                <th scope="col">name</th>
                <th scope="col">email</th>
                <th scope="col">avatar</th>
                <th scope="col">role_type</th>
                <th scope="col"></th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($listAdmin as $key) { ?>
            <tr>
                <th scope="row"><?= $key->id ?></th>
                <td><?= $key->name ?></td>
                <td><?= $key->email ?></td>
                <td><img src="<?= $key->avatar ?>" width="100px" alt=""></td>
                <td><?= $key->role_type == 1 ? "Supper Admin" : "Admin"  ?></td>
                <td>
                    <a name="" id="" class="btn btn-success" href="?controller=admin&action=getEdit&id=<?= $key->id ?>"
                        role="button">Edit</a>
                </td>
                <td>
                    <a name="" id="" class="btn btn-danger" href="?controller=admin&action=delete&id=<?= $key->id ?>"
                        role="button">Delete</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <nav aria-label="Page navigation example">
        <ul class="pagination d-flex justify-content-center">
            <li class="page-item">
                <a class="page-link" href="?controller=admin&action=list&page=1" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <li class="page-item">
                <a class="page-link" href="?controller=admin&action=list&page=<?= $_SESSION['prePage'] ?>">Prev</a>
            </li>
            <?php
            for ($i = 1; $i <= $_SESSION['totalPage']; $i++) {
                echo "<li class='page-item'><a class='page-link' href='?controller=admin&action=list&page={$i}'>$i</a></li>";
            }
            ?>
            <li class="page-item">
                <a class="page-link" href="?controller=admin&action=list&page=<?= $_SESSION['nextPage'] ?>">Next</a>
            </li>
            <li class="page-item">
                <a class="page-link" href="?controller=admin&action=list&page=<?= $_SESSION['totalPage'] ?>"
                    aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
    <?php if (isset($_SESSION['success_message']) && !empty($_SESSION['success_message'])) { ?>
    <div class="success-message alert alert-success">
        <?= $_SESSION['success_message']; ?></div>
    <?php
        unset($_SESSION['success_message']);
    }
    ?>
</div>