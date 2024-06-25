<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
	<meta name="description" content="POS - Bootstrap Admin Template">
	<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, invoice, html5, responsive, Projects">
	<meta name="author" content="Dreamguys - Bootstrap Admin Template">
	<meta name="robots" content="noindex, nofollow">
	<title>Customer</title>

	<link rel="shortcut icon" type="image/x-icon" href="<?= base_url() ?>theme/assets/img/favicon.png">
	<link rel="stylesheet" href="<?= base_url() ?>theme/assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?= base_url() ?>theme/assets/plugins/fontawesome/css/fontawesome.min.css">
	<link rel="stylesheet" href="<?= base_url() ?>theme/assets/plugins/fontawesome/css/all.min.css">
	<link rel="stylesheet" href="<?= base_url() ?>theme/assets/css/style.css">
</head>

<body class="account-page">
	<div class="main-wrapper">
		<div class="account-content">
			<div class="login-wrapper">
				<div class="login-content">
					<div class="login-userset">
						<div class="login-logo">
							<img src="<?= base_url() ?>theme/assets/img/logo.png" alt="img">
						</div>
						<div class="login-userheading">
							<h3>Sign In</h3>
							<h4>Please login to your account</h4>
						</div>
						<div class="alert alert-danger alert-dismissible fade show <?= isset($_GET['err']) ? '' : 'd-none' ?> " id="error" role="alert"><?= isset($_GET['err']) ? $_GET['err'] : '' ?></div>
						<form id="regstr">
							<div class="form-login">
								<label>Username</label>
								<div class="form-addons">
									<input type="text" name="username" placeholder="Enter your email address">
									<img src="<?= base_url() ?>theme/assets/img/icons/mail.svg" alt="img">
								</div>
							</div>
							<div class="form-login">
								<label>Password</label>
								<div class="pass-group">
									<input type="password" name="password" class="pass-input" placeholder="Enter your password">
									<span class="fas toggle-password fa-eye-slash"></span>
								</div>
							</div>
							<div class="form-login">
								<div class="alreadyuser">
									<h4><a href="forgetpassword.html" class="hover-a">Forgot Password?</a></h4>
								</div>
							</div>
							<div class="text-center d-none" id="spinner">
								<div class="spinner-border" role="status">
									<span class="sr-only">Loading...</span>
								</div>
							</div>
							<div class="form-login">
								<button class="btn btn-login" type="submit">Sign In</button>
							</div>
						</form>
					</div>
				</div>
				<div class="login-img">
					<img src="<?= base_url() ?>theme/assets/img/login.jpg" alt="img">
				</div>
			</div>
		</div>
	</div>

	<script src="<?= base_url() ?>theme/assets/js/jquery-3.6.0.min.js"></script>
	<script src="<?= base_url() ?>theme/assets/js/feather.min.js"></script>
	<script src="<?= base_url() ?>theme/assets/js/bootstrap.bundle.min.js"></script>
	<script src="<?= base_url() ?>theme/assets/js/script.js"></script>



	<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
	<script>
		// Set the options that I want
		toastr.options = {
			"closeButton": true,
			"newestOnTop": false,
			"progressBar": true,
			"positionClass": "toast-top-right",
			"preventDuplicates": false,
			"onclick": null,
			"showDuration": "300",
			"hideDuration": "1000",
			"timeOut": "5000",
			"extendedTimeOut": "1000",
			"showEasing": "swing",
			"hideEasing": "linear",
			"showMethod": "fadeIn",
			"hideMethod": "fadeOut"
		}
	</script>

	<script>
		$("#regstr").on("submit", function(e) {
			e.preventDefault()

			const formdata = new FormData(this)

			$.ajax({
				url: "<?php echo base_url() . "customer-login-submit"; ?>",
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
							window.location = '<?php echo base_url() . 'customer-welcome' ?>';
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

</body>

</html>