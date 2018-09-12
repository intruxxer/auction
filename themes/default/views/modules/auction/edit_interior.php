<div class="columns small-12">
	<div class="row">
		<div class="columns small-12 text-center">
			<h2>Interior</h2>
		</div>
	</div>
	
	<form id="car-interior-form" class="car-detail" method="post">
		<div class="row">
			<div class="columns small-12">
				<p>Materials</p>
				<?php foreach($data->interior_material as $m){ ?>
					<a id="btn-material-<?= strtolower($m->name); ?>" 
					   class="button int-material <?= $m->orange ?>"
					   data-material="<?= $m->name; ?>">
					   <?= $m->name ?>
					</a>
				<?php } ?>
			</div>
			<hr>
		</div>
		
		<div class="row">
			<div class="columns small-6 large-12">
				<div class="input-group">
					<span class="input-group-label">Color</span>
					<input class="input-group-field" type="text" name="interior_color" placeholder="Color" value="<?= $data->car_interior ?>">
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
	var materials  = [<?php echo $interior_materials; ?>];
	var references = [<?php echo $material_references; ?>];
	console.log("materials: " + materials); 
	console.log("references: " + references);

	$('.int-material').on("click", function( e ) {
		  var material_classes = $(this).attr('class');
		  var material = $(this).data('material');
		  var pattern = /orange/i;
		  var found = material_classes.match( pattern );
		  if(!found){
		  	$(this).addClass('orange');
		  	materials.push(material);
		  }else{
		  	$(this).removeClass('orange');
		  	var index = materials.indexOf(material);
			if (index >= 0) {
			   materials.splice( index, 1 );
			}
		  }
		  console.log(materials);
	});

	$('#car-interior-form').submit(function(e) {
		var interior_color    = $('[name="interior_color"]').val();

		var formData = {
			"car_sale_id"       : <?= $car_sale_id ?>,
			"interior_color"    : interior_color,
			"interior_material" : materials
		}; 
		console.log(formData);

		$.ajax({
		        type        : 'POST', 
		        url         : '<?= $update_interior_url ?>', 
		        data        : formData,
		        dataType    : 'json',
		        encode      : true
		    }).done(function(resp) { 
		    	$('#edit-info-title').html("Car Interior");
				$('#edit-info-text').html("Your Car's Interiors have been updated.");
			    $('#modal_edit_info').foundation('open');
		    	
		    }).fail(function(resp) {
			    $('#edit-info-title').html("Car Interior");
				$('#edit-info-text').html("Error on updating your car's details.");
			    $('#modal_edit_info').foundation('open');
			}).always(function(resp) {
		    	console.log(resp); 
		});
		
		e.preventDefault();
	});

	$('#car-interior-form').on('keyup keypress', function(e) {
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