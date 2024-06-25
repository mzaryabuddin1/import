<?php

$pagename = "welcome";
$pagetab = "welcome";


include_once('common/header.php');
include_once('common/sidebar.php');
?>

<div class="page-wrapper pagehead">
	<div class="content">
		<div class="page-header">
			<div class="row">
				<div class="col-sm-12">
					<h3 class="page-title">Welcome</h3>
					<ul class="breadcrumb">
						<li class="breadcrumb-item"><a href="<?= base_url() ?>customer-dashboard">Welcome</a></li>
						<li class="breadcrumb-item active">Tutorial</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				Contents here
			</div>
		</div>
	</div>
</div>



<?php
include_once('common/footer.php');
?>