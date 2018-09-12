<section>
	<div class="row">
		<div class="columns small-12 small-uncentered medium-6  medium-centered large-4 text-center">
			<img src="<?php echo site_url(); ?>/assets/img/logo-q.png">
			<h1>Register</h1>
		</div>
	</div>
	<div class="row">
		<form method="POST" action="<?php echo site_url(); ?>home/register/seller" id="register-form" class="columns small-12 small-uncentered medium-6 medium-centered large-4">
			<div class="container">
				<div class="row">
					<div class="columns small-12">
						<label>Email</label>
						<input type="email" name="email" value="<?= $this->session->userdata('social_register_email') ?>" required>
					</div>
					<div class="columns small-12">
						<label>Password</label>
						<input type="password" name="password" required>
					</div>
					<div class="columns small-12">
						<label>Repeat Password</label>
						<input type="password" name="re_password" required>
					</div>
					<div class="columns small-12">
						<button class="call-to-action-green submit"><span>Create Account</span></button>
					</div>
				</div>
			</div>
		</form>
	</div>
</section>
<div class="reveal tiny" id="modal_email_info" data-reveal>
	<div class="row">
		<div class="columns small-12 text-center">
			<h4 id="email-info-title"></h4>
			<hr>
			<p id="email-info-text"></p>
			<div class="button-group">
				<a id="close-button" class="button green" rel="button-modal-info" data-value="close">Close</a>
			</div>
		</div>
	</div>
</div>
<?php if($error_message){ ?>
	<script type="text/javascript">
		$( document ).ready(function() {
		    $('#email-info-title').html("Email Information");
			$('#email-info-text').html("<?= $error_message; ?>");
		    $('#modal_email_info').foundation('open');
		    $('#close-button').click(function () {
			    $('#modal_email_info').foundation('close');
			    return false;
			});
		});

		$( document ).on( "click", '[rel="button-modal-info"]', function( e ) {
			$('#modal_email_info').foundation('close');
			window.location = "<?= site_url('register/seller') ?>";
		});

	</script>
<?php } ?>
<script type="text/javascript">
(function(){
	"use strict";
	$(document).on('click', '[rel="select-role"]', function(e){
			e.preventDefault();
			$(this).closest('.row').find('a').removeClass('is-active');
			$(this).addClass('is-active');
	  		if ($(this).attr('data-role') == "seller") {
		  		$(this).closest('form').find('.dealer-only').addClass('is-hidden');
			  	$(this).closest('form').find('.seller-only').removeClass('is-hidden');
		  	} else if ($(this).attr('data-role') == "dealer") {
			  	$(this).closest('form').find('.dealer-only').removeClass('is-hidden');
			  	$(this).closest('form').find('.seller-only').addClass('is-hidden');
		  	}
		});
})();
</script>