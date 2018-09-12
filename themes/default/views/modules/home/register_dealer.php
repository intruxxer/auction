<section>
	<div class="row">
		<form method="POST" action="<?= site_url()?>home/register/dealer_create" id="register-form" class="columns small-12 small-uncentered medium-8 medium-centered large-6">
			<div class="container">
				<div class="row">
					<div class="columns small-12">
						<label>Key Contact</label>
						<input type="text" name="key_contact">
					</div>
					<div class="columns small-12">
						<label>Key Contact Title</label>
						<input type="text" name="key_contact_title">
					</div>
					<div class="columns small-12">
						<label>Key Contact Email</label>
						<input type="email" name="key_contact_email">
					</div>
					<div class="columns small-12">
						<label>Key Contact Phone</label>
						<input type="text" name="key_contact_phone">
					</div>
					<div class="columns small-12">
						<label>Key Contact Mobile Phone</label>
						<input type="text" name="key_contact_mobile">
					</div>
					<div class="columns small-12">
						<label>Company Type</label>
						<input type="text" name="company_type">
					</div>
					<div class="columns small-12">
						<label>Year Established</label>
						<input type="text" name="year_established">
					</div>
					<div class="columns small-12">
						<label>Number of Employees</label>
						<input type="text" name="number_of_employees">
					</div>
					<input type="hidden" name="facebook_id" value="<?= $this->session->userdata('social_register_fbid') ?>">
					<input type="hidden" name="google_id" value="<?= $this->session->userdata('social_register_gid') ?>">
					<div class="columns small-12 text-center">
						<button class="button submit">Save</button>
					</div>
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
		  	} else if ($(this).attr('data-role') == "dealer") {
			  	$(this).closest('form').find('.dealer-only').removeClass('is-hidden');
			  	$(this).closest('form').find('.seller-only').addClass('is-hidden');
		  	}
		});
})();
</script>