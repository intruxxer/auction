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
					<p>Email:</p>
				</div>
				
				<div class="columns small-12 medium-8 large-9">
					<p>: <a><?php echo $seller_profile->email ?></a></p>
				</div>
				
				<hr>
			</div>
			
			<div class="row">
				<div class="columns small-12 medium-4 large-3">
					<p>Phone Number</p>
				</div>
				
				<div class="columns small-12 medium-8 large-9">
					<p>: <?php echo $seller_profile->cellphone ?></p>
				</div>
				
				<hr>
			</div>
			
			<div class="row">
				<div class="columns small-12 medium-4 large-3">
					<p>Address 1</p>
				</div>
				
				<div class="columns small-12 medium-8 large-9">
					<p>: <?php echo $seller_profile->address_1; ?></p>
				</div>
				
				<hr>
			</div>

			<div class="row">
				<div class="columns small-12 medium-4 large-3">
					<p>Address 2</p>
				</div>
				
				<div class="columns small-12 medium-8 large-9">
					<p>: <?php echo $seller_profile->address_2; ?></p>
				</div>
				
				<hr>
			</div>
			
			<div class="row">
				<div class="columns small-12 medium-4 large-3">
					<p>City</p>
				</div>
				
				<div class="columns small-12 medium-8 large-9">
					<p>: <?php echo $seller_profile->city; ?></p>
				</div>
				
				<hr>
			</div>
			
			<div class="row">
				<div class="columns small-12 medium-4 large-3">
					<p>Province / State / Region</p>
				</div>
				
				<div class="columns small-12 medium-8 large-9">
					<p>: <?php echo $seller_profile->state; ?></p>
				</div>
				
				<hr>
			</div>
			
			<div class="row">
				<div class="columns small-12 medium-4 large-3">
					<p>ZIP / Postal Code</p>
				</div>
				
				<div class="columns small-12 medium-8 large-9">
					<p>: <?php echo $seller_profile->zip_code; ?></p>
				</div>
				
				<hr>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="columns large-6 large-centered">
			<div class="row small-up-1">
				<div class="column column-block">
					<a class="call-to-action-green" href="<?php echo site_url('seller/profile/edit'); ?>"><span>Edit</span></a>
				</div>
			</div>
		</div>
	</div>
</div>