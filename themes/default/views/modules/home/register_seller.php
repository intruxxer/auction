<section>
	<div class="row">
		<form method="POST" action="<?php echo site_url(); ?>home/register/dealer" id="register-form" class="columns small-12 small-uncentered medium-8 medium-centered large-6">
			<div class="container">
				<div class="row">
					<div class="columns small-12">
						<label>I am</label>
						<div class="row small-up-2">
							<div class="column column-block">
								<a class="button is-active" rel="select-role" data-role="seller">SELLER</a>
							</div>
							
							<div class="column column-block">
								<a class="button" rel="select-role" data-role="dealer">DEALER</a>
							</div>
						</div>
					</div>
					<div class="columns small-12 seller-only">
						<label>First Name</label>
						<input type="text" name="first_name" value="<?= $this->session->userdata('social_register_name') ?>" >
					</div>
					<div class="columns small-12 seller-only">
						<label>Last Name</label>
						<input type="text" name="last_name">
					</div>
					<div class="columns small-12 seller-only">
						<label>Email</label>
						<input type="text" name="email" value="<?= $this->session->userdata('email') ?>" >
					</div>
					<div class="columns small-12 seller-only">
						<label>Phone Number</label>
						<input type="text" name="phone_number" id="phone_format" placeholder="(555) 555-5555" >
					</div>
					<div class="columns small-12 dealer-only is-hidden">
						<label>Company Name</label>
						<input type="text" name="company_name">
					</div>
					<div class="columns small-12">
						<label>Address 1</label>
						<input type="text" name="address_1">
					</div>
					<div class="columns small-12">
						<label>Address 2</label>
						<input type="text" name="address_2">
					</div>
					<div class="columns small-12">
						<label>City</label>
						<input type="text" name="city">
					</div>
					<div class="columns small-12">
						<label>Prov / State / Region</label>
						<select name="state">
							<option selected value="British Columbia (BC)">British Columbia (BC)</option>
						</select>
					</div>
					<div class="columns small-12">
						<label>Postal / ZIP Code</label>
						<input type="text" name="zip_code" id="zipcode_format" placeholder="A1A-1A1">
					</div>
					<div class="columns small-12 dealer-only is-hidden">
						<label>Company Email</label>
						<input type="email" name="company_email">
					</div>
					<div class="columns small-12 dealer-only is-hidden">
						<label>Company Phone Number</label>
						<input type="text" name="company_phone">
					</div>
					<div class="columns small-12 dealer-only is-hidden">
						<label>Company Website</label>
						<input type="text" name="company_website">
					</div>
					<div class="columns small-12 dealer-only is-hidden">
						<label>Company Address</label>
						<input type="text" name="company_address">
					</div>
					<div class="columns small-12 text-center seller-only">
						<input type="hidden" name="facebook_id" value="<?= $this->session->userdata('social_register_fbid') ?>">
						<input type="hidden" name="google_id" value="<?= $this->session->userdata('social_register_gid') ?>">
						<!-- <input type="hidden" name="role" value="seller"> -->
						<button class="button submit" href="<?php echo site_url(); ?>/home/register/dealer">Save</button>
					</div>
					<div class="columns small-12 text-center dealer-only is-hidden">
						<!-- <input type="hidden" name="role" value="dealer"> -->
						<button class="button submit" href="<?php echo site_url(); ?>/home/register/dealer">Next</button>
					</div>
					<input type="hidden" id="registration-role" name="registration-role" value="seller">
				</div>
			</div>
		</form>
	</div>
</section>

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
			  	$('#registration-role').val('seller');
		  	} else if ($(this).attr('data-role') == "dealer") {
			  	$(this).closest('form').find('.dealer-only').removeClass('is-hidden');
			  	$(this).closest('form').find('.seller-only').addClass('is-hidden');
			  	$('#registration-role').val('dealer');
		  	}
		});
})();
</script>

<script>
	$(window).load(function()
	{
	    var phones = [{ "mask": "(###) ###-####"}];
	    $('#phone_format').inputmask({ 
	        mask: phones, 
	        greedy: false, 
	        definitions: { '#': { validator: "[0-9]", cardinality: 1}} 
	    });

	    var zipcode = [{ "mask": "@#@ #@#"}];
	    
	    $('#zipcode_format').inputmask({ 
	        mask: zipcode, 
	        greedy: false, 
	        definitions: { '#': { validator: "[0-9]", cardinality: 1},
	        			   '@': { validator: "[A-Z]", cardinality: 1} } 
	    });

	});
</script>