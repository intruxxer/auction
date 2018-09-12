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
							<p>Company Email</p>
						</div>
						
						<div class="columns small-12 medium-8 large-9">
							<p>: <a><?= $dealer_profile->company_email; ?></a></p>
						</div>
						
						<hr>
					</div>
					
					<div class="row">
						<div class="columns small-12 medium-4 large-3">
							<p>Company Phone</p>
						</div>
						
						<div class="columns small-12 medium-8 large-9">
							<p>: <?= $dealer_profile->company_phone; ?></p>
						</div>
						
						<hr>
					</div>
					
					<div class="row">
						<div class="columns small-12 medium-4 large-3">
							<p>Company Address</p>
						</div>
						
						<div class="columns small-12 medium-8 large-9">
							<p>: <?= $dealer_profile->company_address; ?></p>
						</div>
						
						<hr>
					</div>

					<div class="row">
						<div class="columns small-12 medium-4 large-3">
							<p>Company Website</p>
						</div>
						
						<div class="columns small-12 medium-8 large-9">
							<p>: <a><?= $dealer_profile->company_website; ?></a></p>
						</div>
						
						<hr>
					</div>
					
				</div>
				
				<div class="tabs-panel" id="panel-key-contact">
					<div class="row">
						<div class="columns small-12 medium-4 large-3">
							<p>Name</p>
						</div>
						
						<div class="columns small-12 medium-8 large-9">
							<p>: <?= $dealer_profile->key_contact . ' (' . $dealer_profile->key_contact_title . ')'; ?></p>
						</div>
						
						<hr>
					</div>
					
					<div class="row">
						<div class="columns small-12 medium-4 large-3">
							<p>Email</p>
						</div>
						
						<div class="columns small-12 medium-8 large-9">
							<p>: <a><?= $dealer_profile->key_contact_email; ?></a></p>
						</div>
						
						<hr>
					</div>
					
					
					<div class="row">
						<div class="columns small-12 medium-4 large-3">
							<p>Mobile Phone</p>
						</div>
						
						<div class="columns small-12 medium-8 large-9">
							<p>: <?= $dealer_profile->key_contact_phone; ?></p>
						</div>
						
						<hr>
					</div>

					<div class="row">
						<div class="columns small-12 medium-4 large-3">
							<p>Address 1</p>
						</div>
						
						<div class="columns small-12 medium-8 large-9">
							<p>: <?= $dealer_profile->address_1; ?></p>
						</div>
						
						<hr>
					</div>

					<div class="row">
						<div class="columns small-12 medium-4 large-3">
							<p>Address 2</p>
						</div>
						
						<div class="columns small-12 medium-8 large-9">
							<p>: <?= $dealer_profile->address_2; ?></p>
						</div>
						
						<hr>
					</div>

					<div class="row">
						<div class="columns small-12 medium-4 large-3">
							<p>City</p>
						</div>
						
						<div class="columns small-12 medium-8 large-9">
							<p>: <?= $dealer_profile->city; ?></p>
						</div>
						
						<hr>
					</div>
					
					<div class="row">
						<div class="columns small-12 medium-4 large-3">
							<p>Province / State / Region</p>
						</div>
						
						<div class="columns small-12 medium-8 large-9">
							<p>: <?= $dealer_profile->state; ?></p>
						</div>
						
						<hr>
					</div>
					
					<div class="row">
						<div class="columns small-12 medium-4 large-3">
							<p>ZIP / Postal Code</p>
						</div>
						
						<div class="columns small-12 medium-8 large-9">
							<p>: <?= $dealer_profile->zip_code; ?></p>
						</div>
						
						<hr>
					</div>

				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="columns large-6 large-centered">
			<div class="row small-up-1">
				<div class="column column-block">
					<a class="call-to-action-green" href="<?php echo site_url('dealer/profile/edit'); ?>"><span>Edit</span></a>
				</div>
			</div>
		</div>
	</div>
</div>