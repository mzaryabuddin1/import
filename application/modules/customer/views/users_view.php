<?php

$pagetab = "users_accounts";
$pagename = "manage_users";


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
		<div class="row">
			<div class="col-sm-12">
				<div class="card">
					<div class="card-header">
						<h4 class="card-title">Default Datatable</h4>
						<p class="card-text">
							This is the most basic example of the datatables with zero configuration. Use the <code>.datatable</code> class to initialize datatables.
						</p>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table  datanew ">
								<thead>
									<tr>
										<th>Username</th>
										<th>Email</th>
										<th>Address</th>
										<th>Phone</th>
										<th>Status</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>Tiger Nixon</td>
										<td>System Architect</td>
										<td>Edinburgh</td>
										<td>61</td>
										<td>2011/04/25</td>
										<td>2011/04/25</td>
									</tr>
									
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

<script src="<?= base_url()?>theme/assets/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url()?>theme/assets/js/dataTables.bootstrap4.min.js"></script>