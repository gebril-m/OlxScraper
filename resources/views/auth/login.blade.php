
<!doctype html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<meta name="description" content="Unify Admin Panel" />
		<meta name="keywords" content="Login, Unify Login, Admin, Dashboard, Bootstrap4, Sass, CSS3, HTML5, Responsive Dashboard, Responsive Admin Template, Admin Template, Best Admin Template, Bootstrap Template, Themeforest" />
		<meta name="author" content="Bootstrap Gallery" />
		<link rel="shortcut icon" href="img/favicon.ico" />
		<title>Unify Admin Dashboard - Login</title>
		
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
		
		<!-- Common CSS -->
		<link rel="stylesheet" href="http://bootstrap.gallery/unify-dashboards/design-12/css/bootstrap.min.css" />
		<link rel="stylesheet" href="http://bootstrap.gallery/unify-dashboards/design-12/fonts/icomoon/icomoon.css" />

		<!-- Mian and Login css -->
		<link rel="stylesheet" href="http://bootstrap.gallery/unify-dashboards/design-12/css/main.css" />
		<!-- Notify -->
		<link rel="stylesheet" href="http://bootstrap.gallery/unify-dashboards/design-12/vendor/notify/notify-flat.css" />

		<style>
			.login-slider{
				background-image: url('https://www.almasdar.com/upload/photo/news/9/2/600x338o/438.jpg?q=4');
			}
		</style>
	</head>  

	<body class="login-bg">
			
		<div class="container">
			@if(session()->has('error'))
			<div class="notify-notifications">
				<div id="notes" class="notify notify-notes"></div>
				<div id="messages" class="notify notify-messages"><div class="note note-danger note-1"><span class="image"><i class="icon-info-outline"></i></span><button type="button" class="remove"></button><div class="content"><strong class="title">Hello</strong>{{session('error')}}</div></div></div>
							
			</div>
			@endif
			<div class="login-screen row align-items-center">
				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
					<form action="{{route('login')}}" method="post">
						@csrf
						<div class="login-container">
							<div class="row no-gutters">
								<div class="col-xl-4 col-lg-5 col-md-6 col-sm-12">
									<div class="login-box">
										<a href="#" class="login-logo">
											<img src="https://borlabs.io/wp-content/uploads/2019/09/blog-wp-login.png" alt="Unify Admin Dashboard" />
										</a>
										<div class="input-group">
											<span class="input-group-addon" id="Email"><i class="icon-account_circle"></i></span>
											<input type="email" class="form-control" name="email" placeholder="Email" aria-label="Email" aria-describedby="email">
										</div>
										<br>
										<div class="input-group">
											<span class="input-group-addon" id="password"><i class="icon-verified_user"></i></span>
											<input type="password" class="form-control" name="password" placeholder="Password" aria-label="Password" aria-describedby="password">
										</div>
										<div class="actions clearfix">
											<!-- <a href="forgot-pwd.html">Lost password?</a> -->
									  	<button type="submit" class="btn btn-primary">Login</button>
									  </div>
									  <!-- <div class="or"></div>
									  <div class="mt-4">
									  	<a href="signup.html" class="additional-link">Don't have an Account? <span>Create Now</span></a>
									  </div> -->
									</div>
								</div>
								<div class="col-xl-8 col-lg-7 col-md-6 col-sm-12">
									<div class="login-slider"></div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<footer class="main-footer no-bdr fixed-btm">
			<div class="container">
				Copyright Gebril  2017.
			</div>
		</footer>

		<!-- jQuery first, then Tether, then other JS. -->
		<script src="http://bootstrap.gallery/unify-dashboards/design-12/js/jquery.js"></script>
		<script src="http://bootstrap.gallery/unify-dashboards/design-12/js/tether.min.js"></script>
		<script src="http://bootstrap.gallery/unify-dashboards/design-12/js/bootstrap.min.js"></script>
		<script src="http://bootstrap.gallery/unify-dashboards/design-12/vendor/unifyMenu/unifyMenu.js"></script>
		<script src="http://bootstrap.gallery/unify-dashboards/design-12/vendor/onoffcanvas/onoffcanvas.js"></script>
		<script src="http://bootstrap.gallery/unify-dashboards/design-12/js/moment.js"></script>

		<!-- Notify js -->
		<script src="http://bootstrap.gallery/unify-dashboards/design-12/js/jquery.easing.1.3.js"></script>
		<script src="http://bootstrap.gallery/unify-dashboards/design-12/vendor/notify/notify.js"></script>
		<script src="http://bootstrap.gallery/unify-dashboards/design-12/vendor/notify/notify-custom.js"></script>
		
		<!-- Hide Error Message -->
		<script>
			$(function() {

			    setTimeout(function() {
			        $(".notify-notifications").hide()
			    }, 3000);

			});
		</script>
	</body>
</html>