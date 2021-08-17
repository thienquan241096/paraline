<?php
// $admin  = new Admin();
// $listAdmin = $admin->all();
?>
<div class="container">
    <form action="?controller=admin&action=postInsert" method="post" enctype="multipart/form-data">
        <!-- <div class="form-group">
            <label for="">ID</label>
            <input type="number" class="form-control" name="id" placeholder="">
        </div> -->
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="">Tên ADM</label>
                    <input type="text" class="form-control" name="name" placeholder="">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="">email</label>
                    <input type="text" class="form-control" name="email" placeholder="">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="">password</label>
                    <input type="text" class="form-control" name="password" placeholder="">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="">avatar</label>
                    <input type="file" class="form-control" name="avatar" placeholder="">
                </div>
            </div>
            <div class="col-12">
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="role_type" value="1" checked>
                        Supper Admin
                    </label>
                </div>
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="role_type" value="2">
                        Admin
                    </label>
                </div>
            </div>
        </div>
        <div class="col-12">
            <button class='btn btn-primary' name="btn_insert" type="submit">Thêm</button>
            <button type="reset" class="btn btn-warning text-white">Nhập lại</button>
            <a name="" id="" class="btn btn-primary" href="admin?page=admin" role="button">Danh
                sách</a>
        </div>
    </form>
</div>