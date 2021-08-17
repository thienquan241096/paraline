<div class="row">
    <div class="col-8">
        <form class="d-flex" action="?controller=admin&action=postSearch" method="POST">
            <input class="form-control me-2" type="search" placeholder="name , email ..." name="keyword">
            <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
    </div>
    <div class="col-4">
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
            <th scope="row"><?= $key['id'] ?></th>
            <td><?= $key['name'] ?></td>
            <td><?= $key['email'] ?></td>
            <td><img src="<?= $key['avatar'] ?>" width="100px" alt=""></td>
            <td><?= $key['role_type'] == 1 ? "Supper Admin" : "Admin"  ?></td>
            <td>
                <a name="" id="" class="btn btn-success" href="?controller=admin&action=getEdit&id=<?= $key['id'] ?>"
                    role="button">Edit</a>
            </td>
            <td>
                <a name="" id="" class="btn btn-danger" href="?controller=admin&action=delete&id=<?= $key['id'] ?>"
                    role="button">Delete</a>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>