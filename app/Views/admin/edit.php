<div class="container">
    <form action="?controller=admin&action=postEdit&id=<?= $detail->id ?>" method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="">Tên ADM</label>
                    <input type="text" class="form-control" name="name"
                        value="<?= isset($detail->name) ? $detail->name : "" ?>">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="">email</label>
                    <input type="text" class="form-control" name="email" disabled
                        value='<?= isset($detail->email) ? $detail->email : "" ?>'>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="">password</label>
                    <input type="text" class="form-control" name="password">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="">avatar</label>
                    <input type="file" class="form-control" name="avatar">
                </div>
            </div>
            <div class="col-12">
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="role_type" value="1"
                            <?= $detail->role_type == 1 ? 'checked' : "" ?>>
                        Supper Admin
                    </label>
                </div>
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="role_type" value="2"
                            <?= $detail->role_type == 2 ? 'checked' : "" ?>>
                        Admin
                    </label>
                </div>
            </div>
        </div>
        <div class="col-12">
            <button class=' btn btn-primary' name="btn_insert" type="submit">Sửa</button>
            <button type="reset" class="btn btn-warning text-white">Nhập lại</button>
            <a name="" id="" class="btn btn-primary" href="admin?page=admin" role="button">Danh
                sách</a>
        </div>
    </form>
</div>