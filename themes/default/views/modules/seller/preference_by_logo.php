<!--
<div class="row">
	<div class="columns small-12 medium-8 medium-centered text-center">
		<?php $n = 0; foreach ($brands as $brand) { ?>
			<?php if(($n%5)==0){ ?>  <ul class="options-interest brands"> <?php } ?>
				<?php if($brand->type=='main'){ ?>
				<li class="brand <?php echo $brand->active ?>">
					<a>
						<img src="<?php echo base_url(); ?>assets/img/icon-brand-<?php echo strtolower($brand->name) ?>.png">
					</a>
					<?php echo $brand->name; ?>
				</li>
				<?php } ?>
			<?php if(($n%4)==0 && ($n!=0)){ ?> </ul> <?php } ?>
		<?php $n++; } ?>
	</div>
</div>
-->