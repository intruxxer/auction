<section>
	<div class="row">
		<div class="columns small-12 small-uncentered medium-6  medium-centered large-4 text-center">
			<img src="<?php echo site_url(); ?>/assets/img/logo-q.png">
			<h1>Login</h1>
		</div>
	</div>
	<div class="row">
		<form method="POST" action="<?php echo site_url();?>home/login" id="register-form" class="columns small-12 small-uncentered medium-6 medium-centered large-4">
			<div class="container">
				<div class="row">
					<div class="columns small-12">
						<label>Email</label>
						<input type="email" name="email">
					</div>			
					<div class="columns small-12">
						<label>Password</label>
						<input type="password" name="password">
					</div>
					<div class="columns small-12">
						<button class="call-to-action-green"><span>Submit</span></button>
					</div>
					<div class="columns small-12" style="text-align: center;">
						<br>
						<a href="<?= site_url();?>reset_password">Forgot Password?</a>
					</div>
				</div>
			</div>
		</form>
	</div>
</section>
<?php if($error_login){ ?>
<div class="reveal tiny info-window" id="modal_error" data-reveal>
	<div class="row">
		<div class="columns small-12 text-center">
			<h4 id="response-title"></h4>
			<hr>
			<p id="response-text"></p>
			<div class="button-group">
				<a class="button green" rel="button-modal-info" data-value="close">Close</a>
			</div>
			<p></p>
			<p>Forgot Password, Instead? Click <a href="<?= site_url('reset_password') ?>">Here.</a></p>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).foundation();
	var error_login = "<?= $error_login ?>";
	$('#response-title').text('Invalid Login');
	$('#response-text').text(error_login);
	$('#modal_error').foundation('open');
	$(document).on('click', '[rel="button-modal-info"]', function() {
		$('#modal_error').foundation('close');
	});
</script>
<?php } ?>

