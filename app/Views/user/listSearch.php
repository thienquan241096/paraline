<div class="container">
    <div class="">
        <form class="d-flex" action="?controller=user&action=postSearch" method="POST">
            <input class="form-control me-2" type="search" placeholder="name , email ..." name="keyword">
            <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">STT</th>
                <th scope="col">name</th>
                <th scope="col">email</th>
                <th scope="col">avatar</th>
                <th scope="col">facebook_id</th>
                <th scope="col"></th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($listUser as $key) { ?>
            <tr>
                <th scope="row"><?= $key['id'] ?></th>
                <td><?= $key['name'] ?></td>
                <td><?= $key['email'] ?></td>
                <td><img src="<?= $key['avatar'] ?>" width="100px" alt=""></td>
                <td><?= $key['facebook_id'] ?></td>
                <td>
                    <a name="" id="" class="btn btn-success" href="?controller=user&action=getEdit&id=<?= $key['id'] ?>"
                        role="button">Edit</a>
                </td>
                <td>
                    <a name="" id="" class="btn btn-danger" href="?controller=user&action=delete&id=<?= $key['id'] ?>"
                        role="button">Delete</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>