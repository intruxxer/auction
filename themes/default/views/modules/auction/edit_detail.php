<div class="columns small-12">
	<div class="row">
		<div class="columns small-12 text-center">
			<h2>Detail</h2>
		</div>
	</div>
	
	<form id="car-detail-form" class="car-detail" method="post">
		<div class="row">
			<div class="columns small-12 medium-6">
				<p>As-is</p>
			</div>
			
			<div class="columns small-12 medium-6 text-right">
				<?php if(!empty($data->as_is)){ ?>
					<?php  if( (int) $data->as_is == 1){ $check_orange = 'orange'; $close_orange = ''; }
				           elseif( (int) $data->as_is == 0) { $close_orange = 'orange'; $check_orange =''; } 
					?>
					<a class="as-is button <?= $check_orange ?>" data-value= "1"><i class="fa fa-check"></i></a>
					<a class="as-is button <?= $close_orange ?>" data-value= "0"><i class="fa fa-close"></i></a>
					<input type="hidden" name="as_is" value="<?= $data->as_is ?>">
				<?php } else {?>
					<a class="as-is button" data-value= "1"><i class="fa fa-check"></i></a>
					<a class="as-is button" data-value= "0"><i class="fa fa-close"></i></a>
					<input type="hidden" name="as_is" value="">
				<?php }?>
			</div>
			
			<hr>
		</div>
		
		<div class="row">
			<div class="columns small-12 medium-6">
				<p>Make</p>
			</div>
			
			<div class="columns small-12 medium-6 text-right">
				<p id="detail-maker" class="disabled" data-value="<?= $data->make;?>"><?= $data->make;?></p>
			</div>
			
			<hr>
		</div>
		
		<div class="row">
			<div class="columns small-12 medium-6">
				<p>Model</p>
			</div>
			
			<div class="columns small-12 medium-6 text-right">
				<p id="detail-model" class="disabled" data-value="<?= $data->model;?>"><?= $data->model;?></p>
			</div>
			
			<hr>
		</div>
		
		<div class="row">
			<div class="columns small-12 medium-6">
				<p>Trim</p>
			</div>
			
			<div class="columns small-12 medium-6 text-right">
				<p id="detail-trim" class="disabled" data-value="<?= $data->trim;?>"><?= $data->trim;?></p>
			</div>
			
			<hr>
		</div>
		
		<div class="row">
			<div class="columns small-12 medium-6">
				<p>Year</p>
			</div>
			
			<div class="columns small-12 medium-6 text-right">
				<p id="detail-year" class="disabled" data-value="<?= $data->year;?>"><?= $data->year;?></p>
			</div>
			
			<hr>
		</div>
		
		<div class="row">
			<div class="columns small-12 medium-6">
				<div class="input-group">
					<span class="input-group-label">Mileage</span>
					<input name="mileage" class="input-group-field" type="text" 
					       placeholder="Mileage" value="<?php if($data->mileage){ echo $data->mileage; } ?>">
				</div>
			</div>
			
			<div class="columns small-12 medium-6 text-right">
				<?php if(!empty($data->mileage_type)){
					  if(strtolower($data->mileage_type) == 'mi'){ $mi_orange = 'orange'; $km_orange = ''; }
					  elseif(strtolower($data->mileage_type) == 'km') { $km_orange = 'orange'; $mi_orange =''; }
				?>
					<a class="mileage-type button <?= $mi_orange ?>" data-value="mi">Mi</a>
					<a class="mileage-type button <?= $km_orange ?>" data-value="km">Km</a>
					<input type="hidden" name="mileage_type" value="<?= strtolower($data->mileage_type); ?>">
				<?php } else {?>
					<a class="mileage-type button" data-value="mi">Mi</a>
					<a class="mileage-type button" data-value="km">Km</a>
					<input type="hidden" name="mileage_type" value="">
				<?php }?>
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
	$('#car-detail-form').submit(function(e) {
		var as_is        = $('[name="as_is"]').val();
		var mileage      = $('[name="mileage"]').val();
		var mileage_type = $('[name="mileage_type"]').val();;

		var formData = {
			"car_sale_id"  : <?= $car_sale_id ?>,
			"as_is"        : as_is,
			"mileage"      : mileage,
			"mileage_type" : mileage_type
		}; 
		console.log(formData);

		$.ajax({
		        type        : 'POST', 
		        url         : '<?= $update_detail_url ?>', 
		        data        : formData,
		        dataType    : 'json',
		        encode      : true
		    }).done(function(resp) { 
		    	$('#edit-info-title').html("Car Detail");
				$('#edit-info-text').html("Your Car's Details have been updated.");
			    $('#modal_edit_info').foundation('open');
		    	
		    }).fail(function(resp) {
			    $('#edit-info-title').html("Car Detail");
				$('#edit-info-text').html("Error on updating your car's details.");
			    $('#modal_edit_info').foundation('open');
			}).always(function(resp) {
		    	console.log(resp); 
		});
		
		e.preventDefault();
	});

	$('#car-detail-form').on('keyup keypress', function(e) {
	  var keyCode = e.keyCode || e.which;
	  if (keyCode === 13) { 
	    e.preventDefault();
	    return false;
	  }
	});

	$(document).on('click', '.mileage-type', function()
	{
		  var mileage_classes = $(this).attr('class');
		  var mileage_type_val = $(this).data('value');
		  var pattern = /orange/i;
		  var found = mileage_classes.match( pattern );
		  if(!found){
		  	$('.mileage-type').removeClass('orange');
		  	$(this).addClass('orange');
		  }else{ }

		  $('input[name="mileage_type"]').val(mileage_type_val);
	});

	$(document).on('click', '.as-is', function()
	{
		  var as_is_classes = $(this).attr('class');
		  var as_is_value   = $(this).data('value');
		  var pattern = /orange/i;
		  var found = as_is_classes.match( pattern );
		  if(!found){
		  	$('.as-is').removeClass('orange');
		  	$(this).addClass('orange');
		  }else{ }

		  $('input[name="as_is"]').val(as_is_value);
	});

	$(document).on('click', '[rel="button-modal-info"]', function() {
		$('#modal_edit_info').foundation('close');
	});
</script>