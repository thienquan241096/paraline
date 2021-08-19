<div class="container">
    <form action="?controller=user&action=postEdit&id=<?= $detail->id ?>" method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="">Tên người dùng</label>
                    <input type="text" class="form-control" name="name"
                        value="<?= isset($detail->name) ? $detail->name : "" ?>">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="">email</label>
                    <input type="text" class="form-control" name="email"
                        value='<?= isset($detail->email) ? $detail->email : "" ?>'>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="">facebook_id</label>
                    <input type="text" class="form-control" name="facebook_id" disabled
                        value='<?= isset($detail->facebook_id) ? $detail->facebook_id : "" ?>'>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="">avatar</label>
                    <input type="file" class="form-control" name="avatar">
                </div>
                <img src="<?= isset($detail->avatar) ? $detail->avatar : "" ?>" width="100px" alt="">
            </div>
            <div class="form-check">
                <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="status" value="1"
                        <?= $detail->status == 1 ? 'checked' : "" ?>>
                    Active
                </label>
            </div>
            <div class="form-check">
                <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="status" value="2"
                        <?= $detail->status == 2 ? 'checked' : "" ?>>
                    Banner
                </label>
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