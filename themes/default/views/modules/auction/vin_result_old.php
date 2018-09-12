<form method="POST" action="<?php echo site_url();?>auction/photos">
<div id="vin-result" class="columns small-12 car-detail">
	<div class="row uncollapse">
		<div class="columns small-12 small-uncentered medium-10 medium-centered large-8 text-center">
			<h1>List Car</h1>
		</div>
	</div>
	
	<div class="row">
		<div class="columns small-12 medium-8 large-9">
			<p>VIN Number</p>
		</div>
		
		<div class="columns small-12 medium-4 large-3 text-right">
			<p><?= $data->vin ?></p>
		</div>
		
		<hr>
	</div>
	
	<div class="row">
		<div class="columns small-12 medium-8 large-9">
			<p>Make</p>
		</div>
		
		<div class="columns small-12 medium-4 large-3 text-right">
			<p><?= $data->make?></p>
		</div>
		
		<hr>
	</div>
	
	<div class="row">
		<div class="columns small-12 medium-8 large-9">
			<p>Model</p>
		</div>
		
		<div class="columns small-12 medium-4 large-3 text-right">
			<p><?= $data->model?></p>
		</div>
		
		<hr>
	</div>

	<div class="row">
		<div class="columns small-12 medium-8 large-9">
			<p>Trim</p>
		</div>
		
		<div class="columns small-12 medium-4 large-3 text-right">
			<select>
				<option value="default"><?= $data->trim?></option> 
				<?php foreach ($trim_options['objects'] as $model_id => $model_trim) { ?>
				<option value="<?= $model_id ?>" <?php if($trim_options['key'] == $model_id){ echo 'selected="selected"'; } ?> >
					<?= $model_trim ?>
				</option>
				<?php } ?>
			</select>
		</div>

		<div class="columns small-12 medium-9 large-12 text-right"">
			<p style="color: red;">Please select the closest available trim</p>
		</div>
		
		<hr>
	</div>
	
	<div class="row">
		<div class="columns small-12 medium-8 large-9">
			<p>Year</p>
		</div>
		
		<div class="columns small-12 medium-4 large-3 text-right">
			<p><?= $data->year?></p>
		</div>
		
		<hr>
	</div>
	
	<!--
	<div class="row">
		<div class="columns small-12 medium-8 large-9">
			<p>Transmission</p>
		</div>

		<div class="columns small-12 medium-3 text-right">
			<?php if(!empty($data->transmission)){ ?>
				<?php  if( $data->transmission == 'Manual'){ $check_green = 'green'; $close_green = ''; }
			           elseif( $data->transmission == 'Automatic') { $close_green = 'green'; $check_green =''; } 
				?>
				<a class="transmission button <?= $check_green ?>" data-value='Manual'>Manual</i></a>
				<a class="transmission button <?= $close_green ?>" data-value='Automatic'>Automatic</a>
				<input type="hidden" name="transmission" value="<?= $data->transmission ?>">
			<?php } else {?>
				<a class="transmission button" data-value='Manual'>Manual</i></a>
				<a class="transmission button" data-value='Automatic'>Automatic</i></a>
				<input type="hidden" name="transmission" value="">
			<?php }?>
		</div>
		
		<hr>
	</div> -->
	
	<!-- <div class="row">
		<div class="columns small-12 medium-8 large-9">
			<p>Cylinder</p>
		</div>
		
		<div class="columns small-12 medium-4 large-3 text-right">
			<a class="button green"><?= $data->cylinders?></a>
		</div>
		
		<hr>
	</div> -->
	
	<!--div class="row">
		<div class="columns small-12 medium-8 large-9">
			<p>Fuel Type</p>
		</div>
		
		<div class="columns small-12 medium-4 large-3 text-right">
			<a class="button green"><?= $data->fuel_type?></a>
		</div>
		
		<hr>
	</div-->
	
	<!--
	<div class="row">
		<div class="columns small-12 medium-8 large-9">
			<p>Drive Train</p>
		</div>
		
		<div class="columns small-12 medium-4 large-3 text-right">
			<a class="button green"><?= $data->drivetrain?></a>
		</div>
		
		<hr>
	</div> -->
	
	<!-- <div class="row">
		<div class="columns small-12 medium-8 large-9">
			<p>Exterior Color</p>
		</div>
		
		<div class="columns small-12 medium-4 large-3 text-right">
			<p><?= $data->exterior_color?></p>
		</div>
		
		<hr>
	</div> -->

	<input type="hidden" name="vin" value="<?= $data->vin ?>">
	<input type="hidden" name="seller_id" value="<?= $seller_id ?>">
	<input type="hidden" name="year" value="<?= $data->year ?>">
	<input type="hidden" name="make" value="<?= $data->make ?>">
	<input type="hidden" name="model" value="<?= $data->model ?>">
	<input type="hidden" name="trim" value="<?= $data->trim ?>">
	<input type="hidden" name="trim_ids" value="<?= $trim_options['ids'] ?>">
	<input type="hidden" name="trim_models" value="<?= $trim_options['models'] ?>">

	<div class="row" style="margin-top: 24px;">
		<div class="small-12 text-center">
			<button class="call-to-action submit"><span>Next</span></button>	
		</div>
	</div>
</div>
</form>

<script>
	$(document).on('click', '.transmission', function()
	{
		  var transmission_classes = $(this).attr('class');
		  var transmission_value   = $(this).data('value');
		  var pattern = /green/i;
		  var found = transmission_classes.match( pattern );
		  if(!found){
		  	$('.transmission').removeClass('green');
		  	$(this).addClass('green');
		  }else{ }

		  $('input[name="transmission"]').val(transmission_value);
	});
</script>
