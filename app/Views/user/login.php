<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
	<script src="/particles.min.js"></script>
	<title>Login | Heat Pipe</title>
</head>

<body>

	<style>
		body {
			background-color: var(--bs-gray-500);
		}

		.background {
			width: 100vw;
			height: 100vh;
			position: absolute;
		}
	</style>

	<script>
		particlesJS.load('particles-js', "<?= base_url() ?>/api/v1/particles");
	</script>

	<div class="background" id="particles-js"></div>

	<div class="d-flex flex-column min-vh-100 justify-content-center align-items-center">
		<div class="col-2">
		<?php if(isset($_SESSION['error_message'])){ ?>
			<div class="alert alert-danger" role="alert">
				<strong><?php echo $_SESSION['error_message'] ?></strong>
			</div>
			<?php } ?>
			
			<div class="card">
				<div class="card-header">Login to Heat Pipe</div>
				<div class="card-body">
					<div class="m-auto">
						<form action="/user/attempt_login" method="post">
							<div class="mb-3">
							  <label for="username" class="form-label">Username</label>
							  <input type="text" class="form-control" name="username" id="username">
							</div>
							<div class="mb-3">
							  <label for="password" class="form-label">Password</label>
							  <input type="password" class="form-control" name="password" id="password">
							</div>
							<div class="form-check mb-3">
							  <input type="checkbox" class="form-check-input" name="remember" id="remember" value="true" checked>
							  <label class="form-check-label" for="remember">
								Remember for 14 days
							  </label>
							</div>
							<button type="submit" class="btn btn-primary">Submit</button>
						</form>
						<!--a class="" href="< $oauth_url['microsoft'] ?>"><i class="fab fa-microsoft"></i></a-->
						<!--a class="" href="< $oauth_url['google'] ?>"><i class="fab fa-google"></i></a-->
					</div>
				</div>
			</div>
		</div>
	</div>

</body>

</html>