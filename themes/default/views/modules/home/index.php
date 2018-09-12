<section>
	<div class="row">
		<div class="columns small-12 small-uncentered medium-6  medium-centered large-4 text-center">
			<img src="<?php echo site_url(); ?>/assets/img/logo-q.png">
			<h1>Welcome</h1>
		</div>
	</div>
	<div class="row">
		<div id="welcome" class="columns small-12 small-uncentered medium-6  medium-centered large-4">
			<div class="container">
				<div class="row">
					<div class="columns small-12">
						<a href="<?php echo site_url('login'); ?>">Login</a>
						<a href="<?php echo site_url('register'); ?>">Create Account</a>
						<p><span>or</span></p>
						<a href="<?php echo $fb_login_url; ?>" class="social-media">Continue with Facebook</a>
						<a href="<?php echo $google_login_url; ?>" class="social-media">Continue with Google</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>