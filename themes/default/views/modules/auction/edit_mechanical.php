<div class="columns small-12">
	<div class="row">
		<div class="columns small-12 text-center">
			<h2>Mechanical</h2>
		</div>
	</div>
	
	<form id="car-mechanical-detail" class="car-detail">
		<div class="row">
			<div class="columns small-12">
				<p>Transmission</p>
				<?php foreach($data->transmission as $t){?>
				<a class="button transmission-btn <?= $t->orange ?>" data-value="<?= $t->name ?>"><?= $t->name ?></a>
				<?php } ?>
			</div>
			
			<hr>
		</div>
		
		<div class="row">
			<div class="columns small-12">
				<p>Drivetrain</p>
				<?php foreach($data->drivetrain as $d){?>
				<a class="button drivetrain-btn <?= $d->orange ?>" data-value="<?= $d->name ?>"><?= $d->name ?></a>
				<?php } ?>
			</div>
			
			<hr>
		</div>
		
		<div class="row">
			<div class="columns small-12">
				<p>Cylinders</p>
				<?php foreach($data->cylinders as $c){?>
				<a class="button cylinders-btn <?= $c->orange ?>" data-value="<?= $c->name ?>"><?= $c->name ?></a>
				<?php } ?>
			</div>
			
			<hr>
		</div>
		
		<div class="row">
			<div class="columns small-6 large-12">
				<div class="input-group">
					<span class="input-group-label">Displacement</span>
					<input class="input-group-field" type="text" name="car_displacement" placeholder="Displacement" 
					       value="<?= $data->car_mechanical->displacement; ?>">
				</div>
			</div>
			
			<hr>
		</div>
		
		<div class="row">
			<div class="columns small-12">
				<p>Fuel Type</p>
				<?php foreach($data->fuel_type as $f){?>
				<a class="button fuel-type-btn <?= $f->orange ?>" data-value="<?= $f->name ?>"><?= $f->name ?></a>
				<?php } ?>
			</div>
			
			<hr>
		</div>
		
		<div class="row">
			<div class="columns small-12 text-center">
				<button class="call-to-action"><span>SUBMIT</span></button>
			</div>
		</div>
	</form>
</div>
<div class="reveal tiny" id="modal_edit_info" data-reveal>
	<div class="row">
		<div class="columns small-12 text-center">
			<h4 id="edit-info-title"></h4>
			<hr>
			<p id="edit-info-text"></p>
			<div class="button-group">
				<a class="button" rel="button-modal-info" data-value="close">Close</a>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	var formData = {
		"car_sale_id"  : <?= $car_sale_id ?>,
		"transmission" : "<?= $data->car_mechanical->transmission ?>",
		"drivetrain"   : "<?= $data->car_mechanical->drivetrain ?>",
		"cylinders"    : <?= $data->car_mechanical->cylinders ?>,
		"displacement" : <?= (double) $data->car_mechanical->displacement ?>,
		"fuel_type"    : "<?= $data->car_mechanical->fuel_type ?>"
	}; 
	console.log(formData);

	$('#car-mechanical-detail').submit(function(e){
		var displacement   = $('[name="car_displacement"]').val();
		if(displacement == ''){ formData.displacement = "0.0";  }
		else{
			formData.displacement = displacement;
		}
		console.log(formData);

		$.ajax({
		        type        : 'POST', 
		        url         : '<?= $update_mechanical_url ?>', 
		        data        : formData,
		        dataType    : 'json',
		        encode      : true
		    }).done(function(resp) { 
		    	$('#edit-info-title').html("Car Mechanical's Details");
				$('#edit-info-text').html("Your Car's Mechanical Details have been updated.");
			    $('#modal_edit_info').foundation('open');
		    	
		    }).fail(function(resp) {
			    $('#edit-info-title').html("Car Mechanical's Details");
				$('#edit-info-text').html("Error on updating your car's mechanical details.");
			    $('#modal_edit_info').foundation('open');
			}).always(function(resp) {
		    	console.log(resp); 
		});
		
		e.preventDefault();
	});

	$('#car-mechanical-detail').on('keyup keypress', function(e) {
	  var keyCode = e.keyCode || e.which;
	  if (keyCode === 13) { 
	    e.preventDefault();
	    return false;
	  }
	});

	$(document).on('click', '.transmission-btn', function()
	{
		  var transmission_classes = $(this).attr('class');
		  var transmission_value   = $(this).data('value');
		  var pattern = /orange/i;
		  var found = transmission_classes.match( pattern );
		  if(!found){
		  	$('.transmission-btn').removeClass('orange');
		  	$(this).addClass('orange');
		  }else{ }
		  formData.transmission = transmission_value;
		  console.log(formData);
	});

	$(document).on('click', '.drivetrain-btn', function()
	{
		  var drivetrain_classes = $(this).attr('class');
		  var drivetrain_value   = $(this).data('value');
		  var pattern = /orange/i;
		  var found = drivetrain_classes.match( pattern );
		  if(!found){
		  	$('.drivetrain-btn').removeClass('orange');
		  	$(this).addClass('orange');
		  }else{ }
		  formData.drivetrain = drivetrain_value;
		  console.log(formData);
	});

	$(document).on('click', '.cylinders-btn', function()
	{
		  var cylinders_classes = $(this).attr('class');
		  var cylinders_value   = $(this).data('value');
		  var pattern = /orange/i;
		  var found = cylinders_classes.match( pattern );
		  if(!found){
		  	$('.cylinders-btn').removeClass('orange');
		  	$(this).addClass('orange');
		  }else{ }
		  formData.cylinders = cylinders_value;
		  console.log(formData);
	});

	$(document).on('click', '.fuel-type-btn', function()
	{
		  var fuel_type_classes = $(this).attr('class');
		  var fuel_type_value   = $(this).data('value');
		  var pattern = /orange/i;
		  var found = fuel_type_classes.match( pattern );
		  if(!found){
		  	$('.fuel-type-btn').removeClass('orange');
		  	$(this).addClass('orange');
		  }else{ }
		  formData.fuel_type = fuel_type_value;
		  console.log(formData);
	});

	$(document).on('click', '[rel="button-modal-info"]', function() {
		$('#modal_edit_info').foundation('close');
	});
</script>