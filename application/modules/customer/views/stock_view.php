<?php

$pagetab = "stock";
$pagename = "manage_stock";


$filtered_modules = array_filter($_SESSION['customer_modules'], function ($module) {
	return $module['module'] === 'stock';
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
					<h3 class="page-title">Stock</h3>
					<ul class="breadcrumb">
						<li class="breadcrumb-item"><a href="<?= base_url() ?>customer-dashboard">Stock</a></li>
						<li class="breadcrumb-item active">Listing</li>
					</ul>
				</div>
			</div>
		</div>

		<?php if ($_SESSION['customer_superadmin'] || $insert) : ?>
			<div class="row mb-3">
				<div class="col-12 text-end">
					<a class="btn btn-primary" href="<?= base_url() ?>customer-add-stock">Add New</a>
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
										<th>GD</th>
										<th>HS</th>
										<th>Description</th>
										<th>Qty</th>
										<th>UOM</th>
										<th>Sales taxable value of import</th>
										<th>Sales tax paid at import stage</th>
										<th>Value addition tax on commerical import</th>
										<th>Sales tax rate</th>
										<th>Max sale able value</th>
										<th>Comments</th>
										<th>Created</th>
										<th>Created by</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($data as $row) : ?>
										<tr>
											<td><?= $row['gd_number'] ?></td>
											<td><?= $row['hscode'] ?></td>
											<td><?= $row['item_description'] ?></td>
											<td><?= $row['qty'] ?></td>
											<td><?= $row['unit_of_measurement'] ?></td>
											<td><?= $row['sales_taxable_value_of_import'] ?></td>
											<td><?= $row['sales_tax_paid_at_import_stage'] ?></td>
											<td><?= $row['value_addition_tax_on_commerical_import'] ?></td>
											<td><?= $row['sales_tax_rate'] ?></td>
											<td><?= $row['max_sale_able_value'] ?></td>
											<td><?= $row['comments'] ?></td>
											<td><?= date('Y-m-d', strtotime($row['created_at'])) ?></td>
											<td>
												<div class="btn-group" role="group" aria-label="Basic example">
													<?php if ($_SESSION['customer_superadmin'] || $update) : ?>
														<a type="button" href="<?= base_url() . 'customer-edit-stock/' . $row['id'] ?>" class="btn btn-outline-secondary">Edit</a>
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
					url: "<?php echo base_url() . "customer-delete-stock-submit"; ?>",
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
								window.location = '<?php echo base_url() . 'customer-stock' ?>';
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