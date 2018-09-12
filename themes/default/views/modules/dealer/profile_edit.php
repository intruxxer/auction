<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="columns small-12">
	<div class="row uncollapse">
		<div class="columns small-12 small-uncentered medium-10 medium-centered text-center">
			<h1><?= $dealer_profile->key_contact; ?></h1>
			<p><?= $dealer_profile->company_name; ?></p>
		</div>
	</div>
	
	<div class="row uncollapse">
		<div class="columns small-12 small-uncentered medium-10 medium-centered">
			<ul class="tabs" data-tabs id="profile-tabs">
				<li class="tabs-title is-active"><a href="#panel-information" aria-selected="true">Information</a></li>
				<li class="tabs-title"><a href="#panel-key-contact">Key Contact</a></li>
			</ul>
			
			<div class="tabs-content" data-tabs-content="profile-tabs">
				<div class="tabs-panel is-active" id="panel-information">
					<div class="row">
						<div class="columns small-12 medium-4 large-3">
							<p>Company Name</p>
						</div>
						
						<div class="columns small-12 medium-8 large-9 text-right">
							<input name="company_name" type="text" value="<?= $dealer_profile->company_name; ?>">
						</div>
						
						<hr>
					</div>
					
					<div class="row">
						<div class="columns small-12 medium-4 large-3">
							<p>Company Email</p>
						</div>
						
						<div class="columns small-12 medium-8 large-9 text-right">
							<input name="company_email" type="email" value="<?= $dealer_profile->company_email; ?>">
						</div>
						
						<hr>
					</div>

					<div class="row">
						<div class="columns small-12 medium-4 large-3">
							<p>Company Phone</p>
						</div>
						
						<div class="columns small-12 medium-8 large-9 text-right">
							<input name="company_phone" type="text" value="<?= $dealer_profile->company_phone; ?>">
						</div>
						
						<hr>
					</div>

					<div class="row">
						<div class="columns small-12 medium-4 large-3">
							<p>Company Address</p>
						</div>
						
						<div class="columns small-12 medium-8 large-9 text-right">
							<input name="company_address" type="text" value="<?= $dealer_profile->company_address; ?>">
						</div>
						
						<hr>
					</div>
					
					<div class="row">
						<div class="columns small-12 medium-4 large-3">
							<p>Company Website</p>
						</div>
						
						<div class="columns small-12 medium-8 large-9 text-right">
							<input name="company_website" type="text" value="<?= $dealer_profile->company_website; ?>">
						</div>
						
						<hr>
					</div>
				</div>
				
				<div class="tabs-panel" id="panel-key-contact">
					<div class="row">
						<div class="columns small-12 medium-4 large-3">
							<p>Name</p>
						</div>
						
						<div class="columns small-12 medium-8 large-9 text-right">
							<input name="key_contact" type="text" value="<?= $dealer_profile->key_contact ?>">
						</div>
						
						<hr>
					</div>

					<div class="row">
						<div class="columns small-12 medium-4 large-3">
							<p>Title</p>
						</div>
						
						<div class="columns small-12 medium-8 large-9 text-right">
							<input name="key_contact_title" type="text" value="<?= $dealer_profile->key_contact_title ?>">
						</div>
						
						<hr>
					</div>
					
					<div class="row">
						<div class="columns small-12 medium-4 large-3">
							<p>Email</p>
						</div>
						
						<div class="columns small-12 medium-8 large-9 text-right">
							<input name="key_contact_email" type="email" value="<?= $dealer_profile->key_contact_email; ?>">
						</div>
						
						<hr>
					</div>
					
					<div class="row">
						<div class="columns small-12 medium-4 large-3">
							<p>Mobile Phone</p>
						</div>
						
						<div class="columns small-12 medium-8 large-9 text-right">
							<input name="key_contact_phone" type="text" value="<?= $dealer_profile->key_contact_phone; ?>">
						</div>
						
						<hr>
					</div>
					
					<div class="row">
						<div class="columns small-12 medium-4 large-3">
							<p>Address 1</p>
						</div>
						
						<div class="columns small-12 medium-8 large-9 text-right">
							<input name="address_1" type="text" value="<?= $dealer_profile->address_1; ?>">
						</div>
						
						<hr>
					</div>
					
					<div class="row">
						<div class="columns small-12 medium-4 large-3">
							<p>Address 2</p>
						</div>
						
						<div class="columns small-12 medium-8 large-9 text-right">
							<input name="address_2" type="text" value="<?= $dealer_profile->address_2; ?>">
						</div>
						
						<hr>
					</div>

					<div class="row">
						<div class="columns small-12 medium-4 large-3">
							<p>City</p>
						</div>
						
						<div class="columns small-12 medium-8 large-9 text-right">
							<input name="city" type="text" value="<?= $dealer_profile->city; ?>">
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
							<input name="zip_code" type="text" value="<?= $dealer_profile->zip_code; ?>">
						</div>
						
						<hr>
					</div>
					
				</div>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="columns large-6 large-centered">
			<div class="row small-up-2">
				<div class="column column-block">
					<a class="call-to-action" href="<?php echo site_url('dealer/profile'); ?>"><span>Cancel</span></a>
				</div>
				
				<div class="column column-block">
					<a class="call-to-action save-edit-profile" data-dealer="<?= $dealer_id ?>" data-email="<?= $email ?>"><span>Save</span></a>
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
		dealer_id   		= $(this).data('dealer');
		email       		= $(this).data('email'); //email login quanto 
		company_name 		= $('[name="company_name"]').val();
		company_email		= $('[name="company_email"]').val();
		company_phone		= $('[name="company_phone"]').val();
		company_address		= $('[name="company_address"]').val();
		company_website		= $('[name="company_website"]').val();
		key_contact			= $('[name="key_contact"]').val();
		key_contact_title	= $('[name="key_contact_title"]').val();
		key_contact_email	= $('[name="key_contact_email"]').val();
		key_contact_phone	= $('[name="key_contact_phone"]').val();
		address_1			= $('[name="address_1"]').val();
		address_2			= $('[name="address_2"]').val();
		city				= $('[name="city"]').val();
		state				= $('[name="state"]').val();
		zip_code			= $('[name="zip_code"]').val();
		
		var formData =  { 
			"dealer_id"			: dealer_id,
			"email"				: email,
			"company_name"  	: company_name,
			"company_email"     : company_email,
			"company_phone"     : company_phone,
			"company_address" 	: company_address,
			"company_website"	: company_website,
			"key_contact"		: key_contact,
			"key_contact_title"	: key_contact_title,
			"key_contact_email"	: key_contact_email,
			"key_contact_phone"	: key_contact_phone,
			"address_1"			: address_1,
			"address_2"			: address_2,
			"city"				: city,
			"state"				: state,
			"zipcode"			: zip_code
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