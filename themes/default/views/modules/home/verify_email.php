<section>
	<div class="row">
		<div class="columns small-12 small-uncentered medium-6  medium-centered large-4 text-center">
			<img src="<?php echo site_url(); ?>/assets/img/logo-q.png">	
			<h1>Reset Password</h1>
		</div>
	</div>
	<div class="row">
		<form id="verify-email-form" method="POST" class="columns small-12 small-uncentered medium-6 medium-centered large-4">
			<div class="container">
				<div class="row">
					<div class="columns small-12">
						<label>Email</label>
						<input type="email" name="email" required>
					</div>
					<div class="columns small-12">
						<button class="call-to-action-green"><span>Send to Email</span></button>
					</div>
				</div>
			</div>
		</form>
	</div>
</section>
<div class="reveal tiny" id="modal_edit_info" data-reveal>
	<div class="row">
		<div class="columns small-12 text-center">
			<h4 id="edit-info-title"></h4>
			<hr>
			<p id="edit-info-text"></p>
			<div class="button-group">
				<a class="button" rel="button-modal-info" data-value="close">Close</a>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$('#verify-email-form').submit(function(e) {
		var email = $('[name="email"]').val();

		var formData = {
			"email"  : email
		}; 
		console.log(formData);

		$.ajax({
		        type        : 'POST', 
		        url         : '<?= $reset_password_url ?>', 
		        data        : formData,
		        dataType    : 'json',
		        encode      : true
		    }).done(function(resp) { 
		    	$('#edit-info-title').html("Reset Password");
				$('#edit-info-text').html("Please check your email to confirm reset password.");
			    $('#modal_edit_info').foundation('open');
		    	
		    }).fail(function(resp) {
			    $('#edit-info-title').html("Car Color");
				$('#edit-info-text').html("Error on sending reset request to your email.");
			    $('#modal_edit_info').foundation('open');
			}).always(function(resp) {
		    	console.log(resp); 
		});
		
		e.preventDefault();
	});

	$('#car-color-form').on('keyup keypress', function(e) {
	  var keyCode = e.keyCode || e.which;
	  if (keyCode === 13) { 
	    e.preventDefault();
	    return false;
	  }
	});

	$(document).on('click', '[rel="button-modal-info"]', function() {
		$('#modal_edit_info').foundation('close');
	});
</script>