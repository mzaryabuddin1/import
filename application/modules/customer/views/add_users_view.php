<?php

$pagetab = "users_accounts";
$pagename = "manage_users";


$filtered_modules = array_filter($_SESSION['customer_modules'], function ($module) {
    return $module['module'] === 'users';
});


$view = $filtered_modules[0]['view'];
$insert = $filtered_modules[0]['insert'];
$update = $filtered_modules[0]['update'];
$delete = $filtered_modules[0]['delete'];


include_once('common/header.php');
include_once('common/sidebar.php');
?>

<div class="page-wrapper pagehead">
    <div class="content">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Users</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>customer-dashboard">Users</a></li>
                        <li class="breadcrumb-item active">Add</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <form id="regstr">
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Username <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                                        <small id="emailHelp" class="form-text text-muted">Should be unique.</small>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Password <span class="text-danger">*</span></label>
                                        <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Email </label>
                                        <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Password">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Phone </label>
                                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                                    </div>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-12">
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Address </label>
                                        <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                                    </div>
                                </div>
                            </div>
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <th>S.no</th>
                                    <th>Module</th>
                                    <th>View</th>
                                    <th>Add</th>
                                    <th>Update</th>
                                    <th>Delete</th>
                                </thead>
                                <tbody>
                                    <?php
                                        $modules = ['dashbard', 'users'];
                                        $sno = 1;
                                    ?>
                                    <?php foreach($modules as $row) : ?>
                                        <tr>
                                            <td><?php echo $sno; $sno++; ?></td>
                                            <td><?= ucfirst($row)  ?></td>
                                            <td><input type="checkbox" name="view[]"></td>
                                            <td><input type="checkbox" name="add[]"></td>
                                            <td><input type="checkbox" name="update[]"></td>
                                            <td><input type="checkbox" name="delete[]"></td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>

                            </table>
                           
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>



<?php
include_once('common/footer.php');
?>