<form id="car-edit-form" method="POST">
<div class="columns small-12">
	<div class="row">
		<div class="columns small-12">
			<div class="box-carousel">
				<div class="carousel seller-auction">
				<?php foreach($an_auction->multimedia as $m) { ?>
					<div class="item">
						<img src="<?= $m->filename; ?>" data-code="<?= $m->multimedia_code ?>">
					</div>
				<?php } ?>
				</div>
				<p></p>
				<a class="button edit" rel="upload-photo" data-auction="<?= $auction_id ?>" data-car="<?= $auction_car ?>">
					<i class="fa fa-pencil"></i></a>
				<a class="button add" href="<?= site_url('auction/'.$auction_id.'/photos/'.$auction_car.'/'.$auction_vin) ?>">
					<i class="fa fa-plus"></i></a>
			</div>
			
			<h2><?= $an_auction->auction->item_title ?></h2>
			
			<div class="row">
				<div class="columns small-12 medium-8 large-9">
					<p>Trim</p>
				</div>
				
				<div class="columns small-12 medium-4 large-3 text-right">
					<select name="trim">
					
					<?php foreach ($trim_options as $model_id => $model_trim) { 
							if($an_auction->sale->trim_id == $model_id) { $selected = "selected"; } else { $selected = ""; }?>
						<option value="<?= $model_id ?>" <?= $selected; ?>><?= $model_trim ?></option>
					<?php } ?>
						
					</select>
				</div>
				
				<hr>
			</div>
			
			<div class="row">
				<div class="columns small-12 medium-4 large-6">
					<p>Mileage</p>
				</div>
				
				<div class="columns small-12 medium-4 large-3 text-right">
					<input name="mileage" type="text" value="<?= $an_auction->sale->mileage ?>">
				</div>
				
				<div class="columns small-12 medium-4 large-3 text-right">
					<a class="mileage-type button <?php if(strtolower($an_auction->sale->mileage_type)=='miles'){ echo 'green'; }else{ echo 'gray'; } ?>" data-value='miles'>Miles</a>
					<a class="mileage-type button <?php if(strtolower($an_auction->sale->mileage_type)=='kms'){ echo 'green'; }else{ echo 'gray'; } ?>" data-value='kms'>Kms</a>
					<input type="hidden" name="mileage_type" value="<?= $an_auction->sale->mileage_type ?>">

				</div>
				
				<hr>
			</div>
			
			<div class="row">
				<div class="columns small-12">
					<p>Exterior: <?= $exterior_car ?></p>
				</div>
				
				<div class="columns small-12">
					<div class="color-pallete-container">
						<?php foreach($exterior_ref as $e) { ?>
						<div class="color-pallete">
							<?php if(strtolower($exterior_car) == strtolower($e->name)) { $is_active = "is-active"; } 
							else{ $is_active = ""; }
							?>
							<a class="btn-ext button <?= strtolower($e->name); ?> <?= $is_active; ?>" data-value=<?= ucwords($e->name); ?>></a>
							<p><?= ucwords($e->name); ?></p>
						</div>
						<?php } ?>
					</div>
					<input type="hidden" name="exterior_color" value="<?= $exterior_car ?>">
				</div>
				<hr>
			</div>
			
			<div class="row">
				<div class="columns small-12">
					<p>Interior: <?= $interior_car ?></p>
				</div>
				
				<div class="columns small-12">
					<div class="color-pallete-container">
						<?php foreach($interior_ref as $e) { ?>
						<div class="color-pallete">
							<?php if(strtolower($interior_car) == strtolower($e->name)) { $is_active = "is-active"; } 
							else{ $is_active = ""; }
							?>
							<a class="btn-int button <?= strtolower($e->name); ?> <?= $is_active; ?>" data-value=<?= ucwords($e->name); ?>></a>
							<p><?= ucwords($e->name); ?></p>
						</div>
						<?php } ?>
					</div>
					<input type="hidden" name="interior_color" value="<?= $interior_car ?>">
				</div>
				<hr>
			</div>
			
			<div class="row">
				<div class="columns small-12 medium-8 large-9">
					<p>Transmission</p>
				</div>
				
				<div class="columns small-12 medium-4 large-3 text-right">
					<a class="transmission button <?php if(strtolower($an_auction->sale->transmission)=='manual'){ echo 'green'; }else{ echo 'gray'; } ?>" data-value='Manual'>Manual</a>
					<a class="transmission button <?php if(strtolower($an_auction->sale->transmission)=='automatic'){ echo 'green'; }else{ echo 'gray'; } ?>" data-value='Automatic'>Automatic</a>
					<input type="hidden" name="transmission" value="<?= $an_auction->sale->transmission ?>">
				</div>
				
				<hr>
			</div>
			
			<div class="row">
				<div class="columns small-12 medium-6 large-6">
					<p>Drive Train</p>
				</div>
				
				<div class="columns small-12 medium-6 large-6 text-right">
					<a class="drivetrain button <?php if(strtolower($an_auction->sale->drivetrain)=='fwd'){ echo 'green'; }else{ echo 'gray'; } ?>" data-value='FWD'>FWD</a>
					<a class="drivetrain button <?php if(strtolower($an_auction->sale->drivetrain)=='rwd'){ echo 'green'; }else{ echo 'gray'; } ?>" data-value='RWD'>RWD</a>
					<a class="drivetrain button <?php if(strtolower($an_auction->sale->drivetrain)=='4wd'){ echo 'green'; }else{ echo 'gray'; } ?>" data-value='4WD'>4WD</a>
					<a class="drivetrain button <?php if(strtolower($an_auction->sale->drivetrain)=='awd'){ echo 'green'; }else{ echo 'gray'; } ?>" data-value='AWD'>AWD</a>
					<input type="hidden" name="drivetrain" value="<?= $an_auction->sale->drivetrain ?>">
				</div>
				
				<hr>
			</div>
			
			<div class="row">
				<div class="columns small-12 medium-6">
					<p>Fuel Type</p>
				</div>
				
				<div class="columns small-12 medium-6 text-right">
					<a class="fuel-type button <?php if(strtolower($an_auction->sale->fuel_type)=='gasoline'){ echo 'green'; }else{ echo 'gray'; } ?>" data-value='Gasoline'>
					Gasoline</a>
					<a class="fuel-type button <?php if(strtolower($an_auction->sale->fuel_type)=='diesel'){ echo 'green'; }else{ echo 'gray'; } ?>" data-value='Diesel'>
					Diesel</a>
					<a class="fuel-type button <?php if(strtolower($an_auction->sale->fuel_type)=='hybrid'){ echo 'green'; }else{ echo 'gray'; } ?>" data-value='Hybrid'>
					Hybrid</a>
					<a class="fuel-type button <?php if(strtolower($an_auction->sale->fuel_type)=='electric'){ echo 'green'; }else{ echo 'gray'; } ?>" data-value='Electric'>
					Electric</a>
					<a class="fuel-type button <?php if(strtolower($an_auction->sale->fuel_type)=='other'){ echo 'green'; }else{ echo 'gray'; } ?>" data-value='Other'>
					Other</a>
					<input type="hidden" name="fuel_type" value="<?= $an_auction->sale->fuel_type ?>">
				</div>
				
				<hr>
			</div>
			
			<div class="row">
				<div class="columns small-12 medium-2">
					<p>Options</p>
				</div>
				
				<div class="columns small-12 medium-10 text-right">
					<?php foreach($options as $o){ ?>
					<a id="btn-option-<?= strtolower($o->name) ?>" class="button all-option gray <?= $o->green ?>" data-option="<?= $o->name ?>">
						<?= $o->name ?>
					</a>
					<?php } ?>

				</div>
				
				<hr>
			</div>
			
			<div class="row">
				<div class="columns small-12 medium-2">
					<p>Needs Repair</p>
				</div>

				<div class="columns small-12 medium-10 text-right">
					<?php foreach($needs_repair as $o){ ?>
					<a id="btn-option-<?= strtolower($o->name) ?>" class="button all-needs-repair gray <?= $o->green ?>" data-repair="<?= $o->name ?>">
						<?= $o->name ?>
					</a>
					<?php } ?>

				</div>
				
				<hr>
			</div>
			
			<div class="row">
				<div class="columns small-12 medium-8 large-9">
					<p>Has Accident</p>
				</div>
				
				<div class="columns small-12 medium-4 large-3 text-right">
					<a class="has-accident button <?php if(strtolower($an_auction->sale->has_accident)=='no'){ echo 'green'; }else{ echo 'gray'; } ?>" data-value='No'>No</a>
					<a class="has-accident repair-yes button <?php if(strtolower($an_auction->sale->has_accident)=='yes'){ echo 'green'; } else{ echo 'gray'; } ?>" data-value='Yes'>Yes</a>
					<a class="has-accident button <?php if(strtolower($an_auction->sale->has_accident)=='rebuild'){ echo 'green'; }else{ echo 'gray'; } ?>" data-value='Rebuild'>Rebuild</a>
					<input type="hidden" name="has_accident" value="<?= $an_auction->sale->has_accident ?>">
					<?php if($an_auction->sale->has_accident != 'Yes') { $type="hidden"; }else{ $type="text"; $currency = "$"; } ?>
					<!-- <label id="currency" style="float: right;"><?= $currency ?><label> -->
					<?php 	if($an_auction->sale->value_repair != 0)
								$value = $an_auction->sale->value_repair;
							else $value = ""; ?>
					<input id="repair-fee" type="<?= $type; ?>" placeholder="Value ($)" 
					value="<?= $value ?>" name="value_repair">
					
				</div>
				
				<hr>
			</div>
			
			<div class="row">
				<div class="columns small-12 ">
					<p>Notes</p>
				</div>
				
				<div class="columns small-12">
					<textarea name="notes" style="min-height: 200px; max-height: none;"><?= $an_auction->declaration_details ?></textarea>
				</div>
				
				<hr>
			</div>
			
			<div class="row">
				<div class="columns small-12 medium-6 text-center">
					<a class="call-to-action gray" href="<?= site_url('seller') ?>"><span>Cancel</span></a>	
				</div>
				
				<div class="columns small-12 medium-6 text-center">
					<!-- <a class="call-to-action save-edit-auction" data-auction="<?= $auction_id ?>" data-car="<?= $auction_car ?>" > -->
					<!-- <span>Save</span></a>	 -->
					<button class="call-to-action-green"><span>Save</span></button>
				</div>
			</div>
		</div>
	</div>
</div>
</form>
<!-- Auction Edit response -->
<div class="reveal tiny" id="modal_edit_info" data-reveal>
	<div class="row">
		<div class="columns small-12 text-center">
			<h4 id="edit-info-title"></h4>
			<hr>
			<p id="edit-info-text"></p>
			<div class="button-group">
				<a class="button green" rel="button-modal-info" data-value="close">Close</a>
			</div>
		</div>
	</div>
</div>
<!-- Sidebar Auction -->
<div class="reveal tiny" id="modal_confirm_delete" data-reveal>
	<div class="row">
		<div class="columns small-12 text-center">
			<h4>Are you sure you want to delete?</h4>
			<div class="button-group">
				<a class="button green" rel="button-modal-confirm-delete" data-value="no">No</a>
				<a class="button green" rel="button-modal-confirm-delete" data-value="yes">Yes</a>
			</div>
		</div>
	</div>
</div>
<div class="reveal tiny" id="modal_active_auction" data-reveal></div>

<!-- upload modal -->
<div class="reveal" id="upload-modal" data-reveal>
	<form class="dropzone" id="dropzone">
		<h4></h4>
		<a class="call-to-action-green" rel="upload"><span><i class="fa fa-spinner fa-spin"></i> Upload</span></a>
	</form>
	
	<button class="close-button" data-close aria-label="Close modal" type="button">
		<i class="fa fa-times-circle"></i>
	</button>
</div>

<!-- dropzone preview template -->
<div class="dz-preview dz-image-preview" id="dz-preview">
	<div class="dz-image">
		<img data-dz-thumbnail />
		<div class="dz-success-mark">
			<p>The image has been successfully uploaded</p>
		</div>
		<div class="dz-error-mark"><i class="fa fa-times-circle"></i></div>
	</div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/dropzone.min.js"></script>
<script>
	//UPLOAD SCRIPT
	var preview = $('#dz-preview').html();
	$('#dz-preview').remove(); 

	var file_image_server = "<?= $this->config->item('api_url'); ?>";
	var file_image_src; 
	var file_image_type;
	var file_title;
	var file_code;
	$('[rel="upload-photo"]').on('click', function() {
		file_image_src  = $('.slick-active').find('img').attr('src'); //.slick-current
		file_image_name = file_image_src.replace(file_image_server, '');
		file_image_name = file_image_name.split('/');
		file_image_name = file_image_name[2];
		file_image_name = file_image_name.split('.');
		file_image_name = file_image_name[0];

		file_image_type = file_image_name.split('_'); 
		file_image_type = file_image_type[2];
		if(file_image_type=='34Front'){ file_title = '3/4 Front'; }else{ file_title = file_image_type; }
		console.log(file_image_src); console.log(file_image_name); console.log(file_title);
		file_code = $('.slick-active').find('img').data('code'); console.log(file_code);
		$('#upload-modal').find('h4').html(file_title + '<br><small>(Drop image file here or click to replace image)</small>');
		$('#upload-modal').foundation('open');
	});

	$('.fa-spin').hide();

	$('#upload-modal').on('closed.zf.reveal', function() {
					$(this).find('.dz-message').remove();
					$(this).find('.dz-image-preview').remove();
					$(this).find('h4').show();
	});
			
	Dropzone.autoDiscover = false;
	var dropzone= new Dropzone("#dropzone",{
		url: "<?= $upload_photo_url ?>",
		method: "post",
		acceptedFiles: "image/*",
		paramName: "userfile",
		autoProcessQueue: false,
		previewTemplate: preview,
		thumbnailWidth: 480,
		thumbnailHeight: 270
	});

	dropzone.on("addedfile", function(file, xhr, formData) {
		$('#upload-modal').find('h4').hide();
		$('[rel="upload"]').on('click', function() {
			dropzone.processQueue();
		}).show();
		var ext = file.type.split("/"); ext = ext[1];
		file_image_name = file_image_name + "." + ext;
		console.log(file); console.log(file_image_name);
	}).on('sending', function(file, xhr, formData){
		formData.append("std_filename", file_image_name);
		formData.append("auction_name", file_image_type);
		formData.append("auction_code", file_code);
		console.log(file_image_name);
		//$('[rel="upload"]').find('i').addClass('fa-spin').unbind();
		$('.fa-spin').show();
	}).on("success", function(file, response) {
			$('.fa-spin').hide();
			$('#upload-modal').find('.dz-success-mark').show();
			$('[rel="upload"]').removeClass('spin').hide();
			$('#current-photo').find('p').addClass('active');
			console.log(response.data.multimedia_uri);
			$('.slick-active').find('img').attr('src', response.data.multimedia_uri);
			location.reload(true);
	});

	//CAROUSEL SLIDER SCRIPT
	$('.carousel').on('init', function(event, slick){
		$('.box-carousel').find('p').text("1/" + slick.slideCount);
		
	}).on('afterChange', function(event, slick, currentSlide, nextSlide){
		$('.box-carousel').find('p').text((currentSlide + 1) + "/" + slick.slideCount);
	});

	$('.carousel').slick({
		arrows: true,
		prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-arrow-left"></i></button>',
		nextArrow: '<button type="button" class="slick-next"><i class="fa fa-arrow-right"></i></button>',
		dots: false,
		infinite: false,
		adaptiveHeight: true
	}).on('init', function(event){
		console.log(event);
	});

	//SAVING AUCTION SCRIPT
	var auction_id; var auction_car; var div_item;

	$( document ).on( "click", '.save-edit-auction', function( e ) {
		auction_id   = $(this).data('auction');
		auction_car  = $(this).data('car');
		var auctionData =  { 'auction_id' : auction_id, 'car_sale_id' : auction_car };
		var auctionURL  =  "";
		$.ajax({ 
		type : "POST", url : auctionURL, data : auctionData, dataType : 'json', encode : true })
		.done(function(data) { })
		.fail(function(data) { })
		.always(function(data){ });
	});

	
	$( document ).on( "click", '.live-auction', function( e ) {
		auction_id      =  $(this).data('auction');
		var auctionData =  { 'auction_id' : auction_id };
		var auctionURL  =  "<?= site_url('auction/set_auction') ?>/" + auction_id + "/active";

		$.ajax({ 
		type : "POST", url : auctionURL, data : auctionData, dataType : 'json', encode : true })
		.done(function(data) { 
			if(data.start_time && data.endtime){
				$('#modal_active_auction').html(
				'<h4>Auction is activated</h4>' + '<p>Auction is active on ' + data.start_time + ' - ' + data.endtime + '</p>' 
				+ '<a class="button green" rel="button-modal-confirm-ok" data-value="ok">OK</a>')
				.foundation('open');
			}
			else
				$('#modal_active_auction').html(
				'<h4>Active Auction</h4>' + '<p>Auction is already active on upcoming auction. </p>' 
				+ '<a class="button green" rel="button-modal-confirm-ok" data-value="ok">OK</a>')
				.foundation('open');
		})
		.fail(function(data) { })
		.always(function(data){ console.log(data); });
			
	});

	$(document).on('click', '[rel="button-modal-confirm-ok"]', function() {
		$('#modal_active_auction').foundation('close');
	});

	$( document ).on( "click", '.delete-auction', function( e ) {
		auction_id   = $(this).data('auction');
		auction_car  = $(this).data('car');
		div_item     = $(this).parents('div .item');
		$('#modal_confirm_delete').foundation('open');
	});

	$(document).on('click', '[rel="button-modal-confirm-delete"]', function() {
			var val = $(this).attr('data-value');
			if (val === "yes") { 
				var auctionData  =  { 'auction_car' : auction_car };
				var auctionURL   =  "<?= site_url('auction/delete') ?>/" + auction_id + "/" + auction_car;
				$.ajax({ 
					type : "POST", url : auctionURL, data : auctionData, dataType : 'json', encode : true })
					.done(function(data) { div_item.hide(); })
					.fail(function(data) { })
					.always(function(data){ });
				
			} else { }

			$('#modal_confirm_delete').foundation('close');
	});

	$(document).on('click', '.mileage-type', function()
	{
		  var mileage_classes = $(this).attr('class');
		  var mileage_type_val = $(this).data('value');
		  var pattern = /orange/i;
		  var found = mileage_classes.match( pattern );
		  if(!found){
		  	$('.mileage-type').removeClass('green').addClass('gray');
		  	$(this).addClass('green');
		  }else{ }

		  $('input[name="mileage_type"]').val(mileage_type_val);
	});

	$(document).on('click', '.transmission', function()
	{
		  var transmission_classes = $(this).attr('class');
		  var transmission_value   = $(this).data('value');
		  var pattern = /green/i;
		  var found = transmission_classes.match( pattern );
		  if(!found){
		  	$('.transmission').removeClass('green').addClass('gray');
		  	$(this).addClass('green');
		  }else{ }

		  $('input[name="transmission"]').val(transmission_value);
	});

	$(document).on('click', '.drivetrain', function()
	{
		  var drivetrain_classes = $(this).attr('class');
		  var drivetrain_value   = $(this).data('value');
		  var pattern = /green/i;
		  var found = drivetrain_classes.match( pattern );
		  if(!found){
		  	$('.drivetrain').removeClass('green').addClass('gray');
		  	$(this).addClass('green');
		  }else{ }

		  $('input[name="drivetrain"]').val(drivetrain_value);
	});

	$(document).on('click', '.fuel-type', function()
	{
		  var fueltype_classes = $(this).attr('class');
		  var fueltype_value   = $(this).data('value');
		  var pattern = /green/i;
		  var found = fueltype_classes.match( pattern );
		  if(!found){
		  	$('.fuel-type').removeClass('green').addClass('gray');
		  	$(this).addClass('green');
		  }else{ }

		  $('input[name="fuel_type"]').val(fueltype_value);
	});

	$(document).on('click', '.btn-ext', function()
	{
		  var ext_classes = $(this).attr('class');
		  var ext_value   = $(this).data('value');
		  var pattern = /is-active/i;
		  var found = ext_classes.match( pattern );
		  if(!found){
		  	$('.btn-ext').removeClass('is-active');
		  	$(this).addClass('is-active');
		  }else{ }

		  $('input[name="exterior_color"]').val(ext_value);
		  console.log(ext_value);
	});

	$(document).on('click', '.btn-int', function()
	{
		  var int_classes = $(this).attr('class');
		  var int_value   = $(this).data('value');
		  var pattern = /is-active/i;
		  var found = int_classes.match( pattern );
		  if(!found){
		  	$('.btn-int').removeClass('is-active');
		  	$(this).addClass('is-active');
		  }else{ }

		  $('input[name="interior_color"]').val(int_value);
		  console.log(int_value);
	});

	$(document).on('click', '.has-accident', function()
	{
		  var has_accident_classes = $(this).attr('class');
		  var has_accident_value   = $(this).data('value');
		  var pattern = /green/i;
		  var found = has_accident_classes.match( pattern );
		  if(!found){
		  	$('.has-accident').removeClass('green').addClass('gray');
		  	$(this).addClass('green');
		  }else{ }

		  $('input[name="has_accident"]').val(has_accident_value);
		  console.log(has_accident_value);
		  
		  var val_repair = document.getElementById('repair-fee');
		  if (val_repair.style.display === 'block') {
	        	val_repair.style.display = 'none';
	        	val_repair.type = 'hidden';
		   } else {
		        val_repair.style.display = 'none';
		        val_repair.type = 'hidden';
		   }
	});

	$(document).on('click', '.repair-yes', function()
	{	 
		  $('#currency').text('$');
		  var val_repair = document.getElementById('repair-fee');
		  val_repair.style.display = 'block';
		  val_repair.type = 'text';
	});

	var options = [<?= $car_options; ?>];
	var option_refs = [<?= $car_option_refs; ?>];
	console.log(options);

	$( document ).on( "click", '.all-option', function( e ) {
	  var option_classes = $(this).attr('class'); 
	  var option = $(this).data('option');
	  var pattern = /green/i;
	  var found = option_classes.match( pattern );
	  if(!found){
	  	$(this).addClass('green').removeClass('gray');
	  	options.push(option);
	  }else{
	  	$(this).removeClass('green').addClass('gray');
	 	var index = options.indexOf(option);
		if (index >= 0) {
		   options.splice( index, 1 );
		}
	  }
	  console.log(options);
	});

	var needs_repairs = [<?= $car_needs_repair; ?>];
	var needs_repair_refs = [<?= $car_needs_repair_refs; ?>];
	console.log(needs_repairs);

	$( document ).on( "click", '.all-needs-repair', function( e ) {
	  var needs_repair_classes = $(this).attr('class'); 
	  var needs_repair = $(this).data('repair');
	  var pattern = /green/i;
	  var found = needs_repair_classes.match( pattern );
	  if(!found){
	  	$(this).addClass('green').removeClass('gray');
	  	needs_repairs.push(needs_repair);
	  }else{
	  	$(this).removeClass('green').addClass('gray');
	 	var index = needs_repairs.indexOf(needs_repair);
		if (index >= 0) {
		   needs_repairs.splice( index, 1 );
		}
	  }
	  console.log(needs_repairs);
	});

	var updated = false;
	//POST EDIT DETAILS
	$('#car-edit-form').submit(function(e) {
		var selected_trim   = $('[name="trim"]').val();
		var mileage      	= $('[name="mileage"]').val();
		var mileage_type 	= $('[name="mileage_type"]').val();
		var exterior_color 	= $('[name="exterior_color"]').val();
		var interior_color 	= $('[name="interior_color"]').val();
		var transmission 	= $('[name="transmission"]').val();
		var drivetrain 		= $('[name="drivetrain"]').val();
		var fuel_type 		= $('[name="fuel_type"]').val();
		var has_accident 	= $('[name="has_accident"]').val();
		var value_repair 	= $('[name="value_repair"]').val();
		var notes 			= $('[name="notes"]').val();

		if(mileage == ''){ mileage = 0; }
		if(has_accident != 'Yes'){ value_repair = 0; }

		var formData = {
			"auction_id"	: <?= $auction_id ?>,
			"car_sale_id"  	: <?= $auction_car ?>,
			"trim_id"       : selected_trim,
			"mileage"      	: mileage,
			"mileage_type" 	: mileage_type,
			"exterior"		: exterior_color,
			"interior"		: interior_color,
			"transmission" 	: transmission,
			"drivetrain" 	: drivetrain,
			"fuel_type" 	: fuel_type,
			"has_accident" 	: has_accident,
			"value_repair" 	: value_repair,
			"options" 		: options,
			"needs_repair" 	: needs_repairs,
			"notes"			: notes
		}; 
		console.log(formData);

		$.ajax({
		        type        : 'POST', 
		        url         : '<?= $auction_edit_url ?>', 
		        data        : formData,
		        dataType    : 'json',
		        encode      : true
		    }).done(function(resp) { 
		    	$('#edit-info-title').html("Car Detail");
				$('#edit-info-text').html("Your Car's Details have been updated.");
			    $('#modal_edit_info').foundation('open');
			    updated = true;
		    }).fail(function(resp) {
			    $('#edit-info-title').html("Car Detail");
				$('#edit-info-text').html("Error on updating your car's details.");
			    $('#modal_edit_info').foundation('open');
			}).always(function(resp) {
		    	console.log(resp); 
			    <?php if($seller_filters){ ?>
			    	window.location = "<?= site_url('seller/preference/set_for_auction/'.$auction_id) ?>";
			    <?php } ?>
			});
		
		e.preventDefault();
	});

	$('#car-edit-form').on('keyup keypress', function(e) {
	  var keyCode = e.keyCode || e.which;
	  if (keyCode === 13) { 
	    e.preventDefault();
	    return false;
	  }
	});

	$(document).on('click', '[rel="button-modal-info"]', function() {
		$('#modal_edit_info').foundation('close');
		if(updated){ window.location = "<?= site_url('seller') ?>"; }
	});

</script>


	
