<div class="container">
    <a name="" id="" class="btn btn-primary" href="?controller=admin&action=getInsert" role="button">Add Admin</a>
    <form action="" method="get">
        <div class="row">
            <div class="col-4">
                <input type="hidden" name="page" value="admin">
                <input type="text" name="keyword" class='form-control'>
            </div>
            <div class="col-8">
                <div class="d-flex justify-content-center">
                    <button type="submit" class='btn btn-success'>Tìm kiếm</button>
                </div>
            </div>
        </div>
    </form>
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
</div>