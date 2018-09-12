<form method="POST" action="<?php echo site_url();?>auction/photos">
<div id="vin-result" class="columns small-12 car-detail">
	<div class="row uncollapse">
		<div class="columns small-12 small-uncentered medium-10 medium-centered large-8 text-center">
			<h1>List Car</h1>
		</div>
	</div>
	
	<div class="row">
		<div class="columns small-12 medium-8 large-9">
			<label>VIN Number</label>
		</div>
		
		<div class="columns small-12 medium-4 large-3 text-right">
			<p><?= $data->vin ?></p>
		</div>
		
		<hr>
	</div>

	<div class="row">
		<div class="columns small-12 medium-8 large-9">
			<label>Year</label>
		</div>
		
		<div class="columns small-12 medium-4 large-3 text-right">
			<p><?= $data->year?></p>
		</div>
		
		<hr>
	</div>
	
	<div class="row">
		<div class="columns small-12 medium-8 large-9">
			<label>Make</label>
		</div>
		
		<div class="columns small-12 medium-4 large-3 text-right">
			<p><?= $data->make?></p>
		</div>
		
		<hr>
	</div>
	
	<div class="row">
		<div class="columns small-12 medium-8 large-9">
			<label>Model</label>
		</div>
		
		<div class="columns small-12 medium-4 large-3 text-right">
			<p><?= $data->model?></p>
		</div>
		
		<hr>
	</div>

	<div class="row">
		<div class="columns small-12 medium-8 large-9">
			<label>Trim</label>
		</div>
		
		<div class="columns small-12 medium-4 large-3 text-right">
			<select name="trim_id">
				<option value="default"><?= $data->trim?></option> 
				<?php foreach ($trim_options['objects'] as $model_id => $model_trim) { ?>
				<option value="<?= $model_id ?>" <?php if($trim_options['key'] == $model_id){ echo 'selected="selected"'; } ?> >
					<?= $model_trim ?>
				</option>
				<?php } ?>
			</select>
		</div>

		<div class="columns small-12 medium-9 large-12 text-right" style="display: none;">
			<p id="trim-select-warning" style="color: red;">Please select the closest available trim</p>
		</div>
		
		<hr>
	</div>

	<input type="hidden" name="vin" value="<?= $data->vin ?>">
	<input type="hidden" name="seller_id" value="<?= $seller_id ?>">
	<input type="hidden" name="year" value="<?= $data->year ?>">
	<input type="hidden" name="make" value="<?= $data->make ?>">
	<input type="hidden" name="model" value="<?= $data->model ?>">
	<input type="hidden" name="trim" value="<?= $data->trim ?>">
	<input type="hidden" name="trim_ids" value="<?= $trim_options['ids'] ?>">
	<input type="hidden" name="trim_models" value="<?= $trim_options['models'] ?>">
	<input type="hidden" name="body_style" value="<?= $data->body_style ?>">

	<div class="row" style="margin-top: 24px;">
		<div class="small-12 text-center">
			<button class="call-to-action-green submit"><span>Next</span></button>	
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
