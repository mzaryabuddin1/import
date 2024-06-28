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
						<li class="breadcrumb-item active">Listing</li>
					</ul>
				</div>
			</div>
		</div>

		<?php if ($_SESSION['customer_superadmin'] || $insert) : ?>
			<div class="row mb-3">
				<div class="col-12 text-end">
					<a class="btn btn-primary" href="<?= base_url() ?>customer-add-user">Add New</a>
				</div>
			</div>
		<?php endif; ?>

		<div class="row">
			<div class="col-sm-12">
				<div class="card">
					<div class="card-header">
						<h4 class="card-title">Datatable</h4>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table  datanew ">
								<thead>
									<tr>
										<th>Avatar</th>
										<th>Username</th>
										<th>Email</th>
										<th>Address</th>
										<th>Phone</th>
										<th>Status</th>
										<th>Created</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($data as $row) : ?>
										<tr>
											<td><img src="<?= $row['profile_picture'] ?>" alt="profile" width="40px"></td>
											<td><?= ucfirst($row['username']) ?></td>
											<td><?= $row['email'] ?></td>
											<td><?= $row['address'] ?></td>
											<td><?= $row['phone'] ?></td>
											<td><?= $row['status'] ? 'Active' : 'Inactive' ?></td>
											<td><?= date('Y-m-d', strtotime($row['created_at'])) ?></td>
											<td>
												<div class="btn-group" role="group" aria-label="Basic example">
													<?php if ($_SESSION['customer_superadmin'] || $update) : ?>
														<a type="button" href="<?= base_url() . 'customer-edit-user/' . $row['id'] ?>" class="btn btn-outline-secondary">Edit</a>
													<?php endif; ?>
													<?php if ($_SESSION['customer_superadmin'] || $delete) : ?>
														<button type="button" class="btn btn-danger del" data-deleteid='<?= $row['id'] ?>'>Delete</button>
													<?php endif; ?>
												</div>
											</td>
										</tr>
									<?php endforeach; ?>

								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>



<?php
include_once('common/footer.php');
?>

<script src="<?= base_url() ?>theme/assets/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>theme/assets/js/dataTables.bootstrap4.min.js"></script>

<script>
	$(".del").on("click", function() {
		const id = $(this).data("deleteid")
		Swal.fire({
			title: "Are you sure?",
			text: "You won't be able to revert this!",
			icon: "warning",
			showCancelButton: true,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			confirmButtonText: "Yes, delete it!"
		}).then((result) => {
			if (result.isConfirmed) {
				const id = $(this).data("deleteid")
				console.log("id", id);
				$.ajax({
					url: "<?php echo base_url() . "customer-delete-user-submit"; ?>",
					type: "post",
					data: {
						id: id
					},
					// processData: false, // tell jQuery not to process the data
					// contentType: false, // tell jQuery not to set contentType
					// cache: false,
					beforeSend: function() {
						$(".del").prop("disabled", true);
					},
					success: function(res) {
						let obj = JSON.parse(res);
						if (obj.error) {
							$(".del").prop("disabled", false);
							toastr.error("Please check errors list!", "Error");
							$(window).scrollTop(0);
						} else if (obj.success) {
							Swal.fire({
								title: "Deleted!",
								text: "Your file has been deleted.",
								icon: "success"
							});
							setTimeout(function() {
								window.location = '<?php echo base_url() . 'customer-users' ?>';
							}, 1000);
						} else {
							$(".del").prop("disabled", false);
							toastr.error("Something bad happened!", "Error");
							$(window).scrollTop(0);
						}
						$(".del").prop("disabled", false);
					},
					error: function(error) {
						toastr.error("Error while sending request to server!", "Error");
						$(window).scrollTop(0);
						$(".del").prop("disabled", false);
					}
				})


			}
		});
	})
</script>