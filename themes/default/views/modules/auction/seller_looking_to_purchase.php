<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="columns small-12">
	<div class="row">
		<div class="columns small-12 text-center">
			<h2>Looking to Purchase</h2>
			
			<hr>
					
			<h3><?= $data->seller_name; ?></h3>
			
			<h3><?= $data->seller_cellphone; ?></h3>
			
			<h3><a href="mailto:<?= $data->seller_email; ?>"><?= $data->seller_email; ?></a></h3>
		</div>
	</div>
	
	<form class="car-detail">
		<div class="row">
			<div class="columns small-12 text-center">
				<ul class="options-interest types">
					<?php foreach($body_styles as $key => $bs) { ?>
						<li class="is-active">
							<a>
								<?php $icon_vehicle = str_replace(' ', '', strtolower($bs)); ?>
								<img src="<?php echo base_url(); ?>assets/img/icon-vehicle-<?= strtolower($icon_vehicle); ?>.png">
							</a>
							
							<?= ucwords(strtolower($bs)); ?>
						</li>
					<?php }?>
				</ul>
			</div>
			
			<hr>
		</div>
		
		<div class="row">
			<div class="columns small-12 tag-cloud text-center">
				<p>Other brands</p>
				<?php foreach($brands as $key => $b) { ?>
					<a class="button green"><?= ucwords(strtolower($b)); ?></a>
				<?php } ?>
			</div>
			
			<hr>
		</div>

		<div class="row">
			<div class="columns small-12 text-center">
				<a class="button gray" href="<?= site_url('auction/'.$auction_id.'/winner/dealer') ?>">< Back</a>
			</div>
		</div>
	</form>
</div>