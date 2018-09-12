<div class="columns small-12">
	<div class="row">
		<div class="columns small-12 text-center">
			<h2>Exterior</h2>
		</div>
	</div>
	
	<form id="car-color-form" class="car-detail" method="post">
		<div class="row">
			<div class="columns small-6 large-12">
				<div class="input-group">
					<span class="input-group-label">Color</span>
					<input class="input-group-field" type="text" placeholder="Color" value="<?= $data->car_exterior ?>" name="exterior_color">
				</div>
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
	$('#car-color-form').submit(function(e) {
		var exterior_color = $('[name="exterior_color"]').val();

		var formData = {
			"car_sale_id"     : <?= $car_sale_id ?>,
			"exterior_color"  : exterior_color
		}; 
		console.log(formData);

		$.ajax({
		        type        : 'POST', 
		        url         : '<?= $update_exterior_url ?>', 
		        data        : formData,
		        dataType    : 'json',
		        encode      : true
		    }).done(function(resp) { 
		    	$('#edit-info-title').html("Car Color");
				$('#edit-info-text').html("Your Car's Color has been updated.");
			    $('#modal_edit_info').foundation('open');
		    	
		    }).fail(function(resp) {
			    $('#edit-info-title').html("Car Color");
				$('#edit-info-text').html("Error on updating your car's color.");
			    $('#modal_edit_info').foundation('open');
			}).always(function(resp) {
		    	console.log(resp); 
		});
		
		e.preventDefault();
	});

	$('#car-color-form').on('keyup keypress', function(e) {
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