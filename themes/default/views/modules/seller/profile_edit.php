<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="columns small-12">
	<div class="row uncollapse">
		<div class="columns small-12 small-uncentered medium-10 medium-centered text-center">
			<h1 style="border-bottom: 1px solid #ccc;"><?php echo $seller_profile->first_name . ' ' . $seller_profile->last_name; ?></h1>
		</div>
	</div>
	
	<div class="row uncollapse">
		<div class="columns small-12 small-uncentered medium-10 medium-centered">
			<div class="row">
				<div class="columns small-12 medium-4 large-3">
					<p>First Name</p>
				</div>
				
				<div class="columns small-12 medium-8 large-9 text-right">
					<input name="first_name" type="text" value="<?= $seller_profile->first_name ?>">
				</div>
				
				<hr>
			</div>
			
			<div class="row">
				<div class="columns small-12 medium-4 large-3">
					<p>Last Name</p>
				</div>
				
				<div class="columns small-12 medium-8 large-9 text-right">
					<input name="last_name" type="text" value="<?= $seller_profile->last_name; ?>">
				</div>
				
				<hr>
			</div>
			
			<div class="row">
				<div class="columns small-12 medium-4 large-3">
					<p>Email</p>
				</div>
				
				<div class="columns small-12 medium-8 large-9 text-right">
					<input name="email" type="email" value="<?= $seller_profile->email; ?>">
				</div>
				
				<hr>
			</div>
			
			<div class="row">
				<div class="columns small-12 medium-4 large-3">
					<p>Phone Number</p>
				</div>
				
				<div class="columns small-12 medium-8 large-9 text-right">
					<input name="cellphone" type="text" value="<?= $seller_profile->cellphone; ?>">
				</div>
				
				<hr>
			</div>
			
			<div class="row">
				<div class="columns small-12 medium-4 large-3">
					<p>Address 1</p>
				</div>
				
				<div class="columns small-12 medium-8 large-9 text-right">
					<input name="address_1" type="text" value="<?= $seller_profile->address_1; ?>">
				</div>
				
				<hr>
			</div>
			
			<div class="row">
				<div class="columns small-12 medium-4 large-3">
					<p>Address 2</p>
				</div>
				
				<div class="columns small-12 medium-8 large-9 text-right">
					<input name="address_2" type="text" value="<?= $seller_profile->address_2; ?>">
				</div>
				
				<hr>
			</div>

			<div class="row">
				<div class="columns small-12 medium-4 large-3">
					<p>City</p>
				</div>
				
				<div class="columns small-12 medium-8 large-9 text-right">
					<input name="city" type="text" value="<?= $seller_profile->city; ?>">
				</div>
				
				<hr>
			</div>
			
			<div class="row">
				<div class="columns small-12 medium-4 large-3">
					<p>Province / State / Region</p>
				</div>
				
				<div class="columns small-12 medium-8 large-9 text-right">
					<select name="state">
						<option selected value="British Columbia (BC)">British Columbia (BC)</option>
					</select>
				</div>
				
				<hr>
			</div>
			
			<div class="row">
				<div class="columns small-12 medium-4 large-3">
					<p>ZIP / Postal Code</p>
				</div>
				
				<div class="columns small-12 medium-8 large-9 text-right">
					<input name="zip_code" type="text" value="<?= $seller_profile->zip_code; ?>">
				</div>
				
				<hr>
			</div>
			
			<div class="row">
				<div class="columns large-6 large-centered">
					<div class="row small-up-2">
						<div class="column column-block">
							<a class="call-to-action" href="<?php echo site_url('seller/profile'); ?>"><span>Cancel</span></a>
						</div>
						
						<div class="column column-block">
							<a class="call-to-action save-edit-profile" data-seller="<?= $seller_id ?>"><span>Save</span></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="reveal tiny" id="modal_edit_info" data-reveal>
	<div class="row">
		<div class="columns small-12 text-center">
			<h4 id="edit-info-title"></h4>
			<hr>
			<p id="edit-info-text"></p>
			<div class="button-group">
				<a class="button green" rel="button-modal-info" data-value="close">Close</a>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$( document ).on( "click", '.save-edit-profile', function( e ) {
		seller_id   = $(this).data('seller');
		first_name 	= $('[name="first_name"]').val();
		last_name	= $('[name="last_name"]').val();
		email		= $('[name="email"]').val();
		cellphone	= $('[name="cellphone"]').val();
		address_1 	= $('[name="address_1"]').val();
		address_2	= $('[name="address_2"]').val();
		city		= $('[name="city"]').val();
		state		= $('[name="state"]').val();
		zip_code	= $('[name="zip_code"]').val();
		
		var formData =  { 
			"seller_id"		: seller_id,
			"first_name"	: first_name,
			"last_name"  	: last_name,
			"email"     	: email,
			"cellphone"     : cellphone,
			"address_1" 	: address_1,
			"address_2" 	: address_2,
			"city"			: city,
			"state"			: state,
			"zipcode"		: zip_code
		};
		var auctionURL  =  '<?= $edit_profile_url ?>';
		$.ajax({ 
		type : "POST", url : auctionURL, data : formData, dataType : 'json', encode : true })
		.done(function(data) { 
			$('#edit-info-title').html("Profile");
			$('#edit-info-text').html("Your profile have been updated.");
		    $('#modal_edit_info').foundation('open');})
		.fail(function(data) { 
			$('#edit-info-title').html("Profile");
			$('#edit-info-text').html("Error on updating your profile.");
		    $('#modal_edit_info').foundation('open');})
		.always(function(data){ console.log(data) });
	});

	$('#edit-profile').on('keyup keypress', function(e) {
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