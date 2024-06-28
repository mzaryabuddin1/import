<?php

$pagetab = "users_accounts";
$pagename = "manage_users";


$filtered_modules = array_filter($_SESSION['customer_modules'], function ($module) {
    return $module['module'] === 'users';
});

$filtered_modules = array_values($filtered_modules);


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
                        <li class="breadcrumb-item active">Edit</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <form id="regstr">
                            <div class="alert alert-danger alert-dismissible fade show <?= isset($_GET['err']) ? '' : 'd-none' ?> " id="error" role="alert"><?= isset($_GET['err']) ? $_GET['err'] : '' ?></div>
                            <div class="row">
                                <input type="text" class="form-control d-none" name="id" value="<?= $data['id'] ?>" placeholder="Username" required>

                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Username <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="username" value="<?= $data['username'] ?>" minlength="3" placeholder="Username" disabled>
                                        <small id="emailHelp" class="form-text text-muted">Should be unique.</small>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Password </label>
                                        <input type="password" class="form-control" name="password" placeholder="Password">
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Email </label>
                                        <input type="email" class="form-control" name="email" value="<?= $data['email'] ?>" placeholder="Email">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Phone </label>
                                        <input type="text" class="form-control" name="phone" value="<?= $data['phone'] ?>" placeholder="Phone">
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Status </label>
                                        <select name="status" class="form-control" >
                                            <option value="1" <?= $data['status'] ? 'selected' : '' ?> >Active</option>
                                            <option value="0" <?= !$data['status'] ? 'selected' : '' ?> >Inactive</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Profile Picture </label>
                                        <input type="file" class="form-control" name="file" accept="image/*">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Address </label>
                                        <input type="text" class="form-control" name="address" value="<?= $data['address'] ?>" placeholder="Address">
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
                                    $alreadyadd_modules = json_decode($data['modules'], true);
                                    $sno = 1;
                                    function isChecked($modules, $moduleName, $permission)
                                    {
                                        foreach ($modules as $module) {
                                            if ($module['module'] === $moduleName && $module[$permission] == 1) {
                                                return 'checked';
                                            }
                                        }
                                        return '';
                                    }
                                    ?>
                                    <?php foreach (MODULES as $row) : ?>
                                        <tr>
                                            <td><?php echo $sno;
                                                $sno++; ?></td>
                                            <td><?= ucfirst($row) ?></td>
                                            <td><input type="checkbox" name="view[<?= $row ?>]" class="view" data-module="<?= $row ?>" <?= isChecked($alreadyadd_modules, $row, 'view') ?>></td>
                                            <td><input type="checkbox" name="add[<?= $row ?>]" class="add" data-module="<?= $row ?>" <?= isChecked($alreadyadd_modules, $row, 'insert') ?>></td>
                                            <td><input type="checkbox" name="update[<?= $row ?>]" class="update" data-module="<?= $row ?>" <?= isChecked($alreadyadd_modules, $row, 'update') ?>></td>
                                            <td><input type="checkbox" name="delete[<?= $row ?>]" class="delete" data-module="<?= $row ?>" <?= isChecked($alreadyadd_modules, $row, 'delete') ?>></td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>

                            </table>
                            <div class="d-none" id="spinner">
                                <div class="spinner-border" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
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


<script>
    $("#regstr").on("submit", function(e) {
        e.preventDefault()

        const formdata = new FormData(this)

        let permissionsArray = [];

        $('tr').each(function() {
            let module = $(this).find('input[type="checkbox"]').data('module');
            if (module) {
                let view = $(this).find('input.view').is(':checked') ? 1 : 0;
                let insert = $(this).find('input.add').is(':checked') ? 1 : 0;
                let update = $(this).find('input.update').is(':checked') ? 1 : 0;
                let deletePerm = $(this).find('input.delete').is(':checked') ? 1 : 0;

                permissionsArray.push({
                    module: module,
                    view: view,
                    insert: insert,
                    update: update,
                    delete: deletePerm
                });
            }
        });

        formdata.append("permissions", JSON.stringify(permissionsArray));


        $.ajax({
            url: "<?php echo base_url() . "customer-edit-user-submit"; ?>",
            type: "post",
            data: formdata,
            processData: false, // tell jQuery not to process the data
            contentType: false, // tell jQuery not to set contentType
            cache: false,
            beforeSend: function() {
                $(":submit").prop("disabled", true);
                $(":submit").addClass("d-none");
                $("#spinner").removeClass("d-none");
                $("#error").addClass("d-none");
            },
            success: function(res) {
                let obj = JSON.parse(res);
                console.log(obj);
                if (obj.error) {
                    $("#error").html(obj.error);
                    $("#error").removeClass("d-none");
                    $("#spinner").addClass("d-none");
                    $(":submit").removeClass("d-none");
                    toastr.error("Please check errors list!", "Error");
                    $(window).scrollTop(0);
                } else if (obj.success) {
                    $("#spinner").addClass("d-none");
                    toastr.success("Success!", "Hurray");
                    setTimeout(function() {
                        window.location = '<?php echo base_url() . 'customer-users' ?>';
                    }, 1000);
                } else {
                    $("#spinner").addClass("d-none");
                    $(":submit").prop("disabled", false);
                    $(":submit").removeClass("d-none");
                    toastr.error("Something bad happened!", "Error");
                    $(window).scrollTop(0);
                }
                $(":submit").prop("disabled", false);
            },
            error: function(error) {
                toastr.error("Error while sending request to server!", "Error");
                $(window).scrollTop(0);
                $("#spinner").addClass("d-none");
                $(":submit").prop("disabled", false);
                $(":submit").removeClass("d-none");
            }
        })

    })
</script>