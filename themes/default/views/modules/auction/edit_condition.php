<div class="columns small-12">
	<div class="row">
		<div class="columns small-12 text-center">
			<h2>Conditions</h2>
		</div>
	</div>
	
	<form id="car-condition-form" class="car-detail">
		<div class="row">
			<div class="columns small-12 tag-cloud">
				<p>Repairs:</p>
				<?php foreach($data->needs_repair as $key => $r) { ?>
				<a class="button <?= $r->orange; ?> btn-need-repair" data-value="<?= $r->name; ?>"><?= $r->name; ?></a>
				<?php } ?>
			</div>
			
			<hr>
		</div>
		
		<div class="row">
			<div class="columns small-12 tag-cloud">
				<p>Windshield:</p>
				<?php foreach($data->windshield as $key => $w) { ?>
				<a class="button <?= $w->orange; ?> btn-windshield" data-value="<?= $w->name; ?>"><?= $w->name; ?></a>
				<?php } ?>
			</div>
			
			<hr>
		</div>
		
		<div class="row">
			<div class="columns small-12 tag-cloud">
				<p>Tires:</p>
				<?php foreach($data->tire_condition as $key => $t) { ?>
				<a class="button <?= $t->orange; ?> btn-tire" data-value="<?= $t->name; ?>"><?= $t->name; ?></a>
				<?php } ?>
			</div>
			
			<hr>
		</div>
		
		<div class="row">
			<div class="columns small-12 tag-cloud">
				<p>Airbag:</p>
				<?php foreach($data->airbags_condition as $key => $ab) { ?>
				<a class="button <?= $ab->orange; ?> btn-airbag" data-value="<?= $ab->name; ?>"><?= $ab->name; ?></a>
				<?php } ?>
			</div>
			
			<hr>
		</div>
		
		<div class="row">
			<div class="columns small-12 tag-cloud">
				<p>ABS:</p>
				<?php foreach($data->antilock_condition as $key => $al) { ?>
				<a class="button <?= $al->orange; ?> btn-antilock" data-value="<?= $al->name; ?>"><?= $al->name; ?></a>
				<?php } ?>
			</div>
			
			<hr>
		</div>
		
		<div class="row">
			<div class="columns small-12">
				<p>Details</p>
				<textarea id="condition-input-details"><?= $data->car_condition->condition_details; ?></textarea>
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
	var needs_repair = <?= json_encode($data->car_condition->needs_repair) ?>;
    var windshield_conditions = <?= json_encode($data->car_condition->windshield) ?>;
	var formData = {
			"car_sale_id"               : <?= $car_sale_id ?>,
			"needs_repair"              : needs_repair,
			"windshield_condition"      : windshield_conditions,
			"tire_condition"            : '<?= $data->car_condition->tire_condition ?>',
			"airbags_condition"         : '<?= $data->car_condition->airbags_condition ?>',
			"antilock_brakes_condition" : '<?= $data->car_condition->antilock_condition ?>',
			"details"                   : '<?= $data->car_condition->condition_details ?>'
	}; 
	console.log(formData);

	$('.btn-need-repair').on("click", function( e ) {
		  var need_repair_classes = $(this).attr('class');
		  var need_repair = $(this).data('value');
		  var pattern = /orange/i;
		  var found = need_repair_classes.match( pattern );
		  if(!found){
		  	$(this).addClass('orange');
		  	needs_repair.push(need_repair);
		  }else{
		  	$(this).removeClass('orange');
		  	var index = needs_repair.indexOf(need_repair);
			if (index >= 0) {
			   needs_repair.splice( index, 1 );
			}
		  }
		  console.log(needs_repair);
	});

	$('.btn-windshield').on("click", function( e ) {
		  var windshield_classes = $(this).attr('class');
		  var windshield = $(this).data('value');
		  var pattern = /orange/i;
		  var found = windshield_classes.match( pattern );
		  if(!found){
		  	$(this).addClass('orange');
		  	windshield_conditions.push(windshield);
		  }else{
		  	$(this).removeClass('orange');
		  	var index = windshield_conditions.indexOf(windshield);
			if (index >= 0) {
			   windshield_conditions.splice( index, 1 );
			}
		  }
		  console.log(windshield_conditions);
	});

	$('.btn-tire').on("click", function( e ) {
		  var tire_classes = $(this).attr('class');
		  var tire = $(this).data('value');
		  var pattern = /orange/i;
		  var found = tire_classes.match( pattern );
		  if(!found){
		  	$(this).siblings().removeClass('orange');
		  	$(this).addClass('orange');
		  	formData.tire_condition = tire;
		  }else{ }
		  console.log(formData.tire_condition);
	});

	$('.btn-airbag').on("click", function( e ) {
		  var airbag_classes = $(this).attr('class');
		  var airbag = $(this).data('value');
		  var pattern = /orange/i;
		  var found = airbag_classes.match( pattern );
		  if(!found){
		  	$(this).siblings().removeClass('orange');
		  	$(this).addClass('orange');
		  	formData.airbags_condition = airbag;
		  }else{ }
		  console.log(formData.airbags_condition);
	});

	$('.btn-antilock').on("click", function( e ) {
		  var antilock_classes = $(this).attr('class');
		  var antilock = $(this).data('value');
		  var pattern = /orange/i;
		  var found = antilock_classes.match( pattern );
		  if(!found){
		  	$(this).siblings().removeClass('orange');
		  	$(this).addClass('orange');
		  	formData.antilock_brakes_condition = antilock;
		  }else{ }
		  console.log(formData.antilock_brakes_condition);
	});

	$('#car-condition-form').submit(function(e) {
		var condition_details    = $('#condition-input-details').val();
		formData.details         = condition_details;
		console.log(formData);

		$.ajax({
		        type        : 'POST', 
		        url         : '<?= $update_condition_url ?>', 
		        data        : formData,
		        dataType    : 'json',
		        encode      : true
		    }).done(function(resp) { 
		    	$('#edit-info-title').html("Car Conditions");
				$('#edit-info-text').html("Your Car's Conditions have been updated.");
			    $('#modal_edit_info').foundation('open');
		    	
		    }).fail(function(resp) {
			    $('#edit-info-title').html("Car Conditions");
				$('#edit-info-text').html("Error on updating your car's conditions.");
			    $('#modal_edit_info').foundation('open');
			}).always(function(resp) {
		    	console.log(resp); 
		});
		
		e.preventDefault();
	});

	$('#car-condition-form').on('keyup keypress', function(e) {
	  var keyCode = e.keyCode || e.which;
	  if (keyCode === 13) { 
	    e.preventDefault();
	    return false;
	  }
	});

	$(document).on('click', '[rel="button-modal-info"]', function() {
		$('#modal_edit_info').foundation('close');
	});
</script>