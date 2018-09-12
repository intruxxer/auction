<div class="columns small-12">
	<div class="row uncollapse">
		<div class="columns small-12 small-uncentered medium-10 medium-centered large-8 text-center">
			<h1>List Car</h1>
		</div>
	</div>
	
	<div class="row">
		<form class="columns small-12" id="upload-car-photo" action="">
			<?php $compulsory_photos_count = 0; ?>
			
			<div class="row">
				<div class="columns small-12 medium-8 large-9">
					<p class="number compulsory_photos <?php if($auction_files[2]){ echo $auction_files[2]; $compulsory_photos_count++; } ?>">1</p>
					<p id="photo_2" role="title" class="compulsory_photos <?= $auction_files[2] ?>">Front Side ( Main Photo )</p>
				</div>
				
				<div class="columns small-12 medium-4 large-3 text-right">
					<a class="icon" rel="upload-photo" data-code="2" data-naming="Front">
						<i class="fa fa-camera"></i></a>
				</div>
			</div>

			<div class="row">
				<div class="columns small-12 medium-8 large-9">
					<p class="number compulsory_photos <?php if($auction_files[4]){ echo $auction_files[4]; $compulsory_photos_count++; } ?>">2</p>
					<p id="photo_4" role="title" class="compulsory_photos <?= $auction_files[4] ?>">Back Side</p>
				</div>
				
				<div class="columns small-12 medium-4 large-3 text-right">
					<a class="icon" rel="upload-photo" data-code="4" data-naming="Back">
						<i class="fa fa-camera"></i></a>
				</div>
			</div>
			
			<div class="row">
				<div class="columns small-12 medium-8 large-9">
					<p class="number compulsory_photos <?php if($auction_files[3]){ echo $auction_files[3]; $compulsory_photos_count++; } ?>">3</p>
					<p id="photo_3" role="title" class="compulsory_photos <?= $auction_files[3] ?>">Driver Side</p>
				</div>
				
				<div class="columns small-12 medium-4 large-3 text-right">
					<a class="icon" rel="upload-photo" data-code="3" data-naming="DriverSide">
						<i class="fa fa-camera"></i></a>
				</div>
			</div>
			
			<div class="row">
				<div class="columns small-12 medium-8 large-9">
					<p class="number compulsory_photos <?php if($auction_files[5]){ echo $auction_files[5]; $compulsory_photos_count++; } ?>">4</p>
					<p id="photo_5" role="title" class="compulsory_photos <?= $auction_files[5] ?>">Passenger Side</p>
				</div>
				
				<div class="columns small-12 medium-4 large-3 text-right">
					<a class="icon" rel="upload-photo" data-code="5" data-naming="Passenger">
						<i class="fa fa-camera"></i></a>
				</div>
			</div>

			<div class="row">
				<div class="columns small-12 medium-8 large-9">
					<p class="number ">5</p>
					<p role="title" class="<?= $auction_files[1] ?>">3/4 Front</p>
				</div>
				
				<div class="columns small-12 medium-4 large-3 text-right">
					<a class="icon" rel="upload-photo" data-code="1" data-naming="34Front">
						<i class="fa fa-camera"></i></a>
				</div>
			</div>
			
			<div class="row">
				<div class="columns small-12 medium-8 large-9">
					<p class="number <?= $auction_files[6] ?>">6</p>
					<p role="title" class="<?= $auction_files[6] ?>">Tire</p>
				</div>
				
				<div class="columns small-12 medium-4 large-3 text-right">
					<a class="icon" rel="upload-photo" data-code="6" data-naming="Tire">
						<i class="fa fa-camera"></i></a>
				</div>
			</div>
			
			<div class="row">
				<div class="columns small-12 medium-8 large-9">
					<p class="number <?= $auction_files[7] ?>">7</p>
					<p role="title" class="<?= $auction_files[7] ?>">Interior Driver Side</p>
				</div>
				
				<div class="columns small-12 medium-4 large-3 text-right">
					<a class="icon" rel="upload-photo" data-code="7" data-naming="Interior">
						<i class="fa fa-camera"></i></a>
				</div>
			</div>
			
			<div class="row">
				<div class="columns small-12 medium-8 large-9">
					<p class="number <?= $auction_files[8] ?>">8</p>
					<p role="title" class="<?= $auction_files[8] ?>">Console</p>
				</div>
				
				<div class="columns small-12 medium-4 large-3 text-right">
					<a class="icon" rel="upload-photo" data-code="8" data-naming="Console">
						<i class="fa fa-camera"></i></a>
				</div>
			</div>
			
			<div class="row">
				<div class="columns small-12 medium-8 large-9">
					<p class="number <?= $auction_files[91] ?>">9</p>
					<p role="title" class="damage-title <?= $auction_files[91] ?>">Damages</p>
				</div>
				
				<div class="columns small-12 medium-4 large-3 text-right">
					<a class="icon damage-btn-upload" rel="upload-photo" data-code="91" data-naming="Damages">
						<i class="fa fa-camera"></i></a>
				</div>
			</div>
			
			<?php $auction_files = array_slice($auction_files, 9, null, true); ksort($auction_files); ?>
			<?php end($auction_files); $last_key = key($auction_files); $last_key = substr($last_key, 1); ?>
			<?php for($n = 2; $n <= $last_key;  $n++ ){ ?>
				<?php $code = '9'.$n; ?>
				<div class="row">
					<div class="columns small-12 medium-8 large-9">
						<p class="number <?= $auction_files[$code] ?>"> <?= $n + 8 ?> </p>
						<p role="title" class="damage-title <?= $auction_files[$code] ?>">Damages</p>
					</div>
					
					<div class="columns small-12 medium-4 large-3 text-right">
						<a class="icon damage-btn-upload" rel="upload-photo" data-code="<?= $code ?>" data-naming="Damages">
							<i class="fa fa-camera"></i></a>
					</div>
				</div>
			<?php } ?>

			<div class="row">
				<div class="columns small-12">
					<p class="number damage-btn-add float-right"><a rel="add-photo-row"><i class="fa fa-plus"></i></a></p>
				</div>
			</div>
			
		</form>
	</div>

	<div class="row" style="margin-top: 24px;">
		<div class="small-12 text-center">
			<a class="call-to-action-green next-photo">
			<span><?= $next ?></span></a>	
		</div>
	</div>
</div>

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
(function(){
	"use strict";
	var compulsory_photos_count = <?= $compulsory_photos_count ?>; 
	$(document).on('ready', function() {
			var auction_id   = "<?= $auction_id ?>";
			var auction_car  = "<?= $auction_car ?>";
			var auction_vin  = "<?= $auction_vin ?>";
			var auction_name; var auction_code; var std_filename;

			$('[rel="add-photo-row"]').on('click', function() {
					var row = $(this).closest('.row').prev().html();
					var number = parseInt($(row).find('.number').text()); console.log(number + 1);
					var damage_code = parseInt($(row).find('[rel="upload-photo"]').data('code')); console.log(damage_code + 1);
					var new_row = $(this).closest('.row').before('<div class="row">' + row + '</div>');
					$(this).closest('.row').prev().find('.number').text(number + 1);
					$(this).closest('.row').prev().find('[rel="upload-photo"]').attr('data-code', damage_code + 1);
					$(this).closest('.row').prev().find('.number').removeClass('active');
					$(this).closest('.row').prev().find('.damage-title').removeClass('active');

			});

			$('.next-photo').on('click', function() {
					var mandatory_photos; 
					var found_count = 0;
					var completed   = false;
					var pattern     = /active/i;
	  				var found; 
  					for (var n = 2; n <= 5; n++) {
  						var photo_sequence = "#photo_"+n; console.log(photo_sequence);
  						mandatory_photos = $(photo_sequence).attr('class');
  						found = mandatory_photos.match( pattern );
  						if(found){ found_count++; } console.log(found_count);

  						if(found_count==4){ completed = true; }
  						else{ completed = false; }
  					}

	  				if(completed){
	  					window.location = "<?= site_url('auction/'.$auction_id.'/edit/'.$auction_car) ?>";
	  				}else{
	  					$('#edit-info-title').html("Incomplete Required Photos");
						$('#edit-info-text').html("You must add Front Side, Back Side, Driver Side, and Passenger Side Pictures of your car.");
					    $('#modal_edit_info').foundation('open');
	  				}
			});

			$(document).on('click', '[rel="button-modal-info"]', function() {
				$('#modal_edit_info').foundation('close');
			});
				
			$('[rel="upload-photo"]').on('click', function() {
					$('.row').removeAttr('id');
					$(this).closest('.row').attr('id', 'current-photo');
					var text = $(this).closest('.row').find('[role="title"]').text();
					auction_name = $(this).data('naming');
					auction_code = $(this).data('code');
					std_filename = "QUANTO_" + auction_vin + "_" + auction_name + "_"; 
					console.log(auction_code + "/" + auction_name + " for " + std_filename);
					$('#upload-modal').find('h4').html(text + '<br><small>(Drop image file here or click to upload)</small>');
					$('#upload-modal').foundation('open');
			});

			//Handle and Bind Event 'click' on dynamically created element
			$(document).on('click', '.damage-btn-upload', function() {
					$('.row').removeAttr('id');
					$(this).closest('.row').attr('id', 'current-photo');
					var text = $(this).closest('.row').find('[role="title"]').text();
					auction_name = $(this).data('naming');
					auction_code = $(this).data('code');
					if(parseInt(auction_code) > 90){
						std_filename = "QUANTO_" + auction_vin + "_" + auction_name + "_" + auction_code;
					}else{
						std_filename = "QUANTO_" + auction_vin + "_" + auction_name + "_";
					} 
					console.log(auction_code + "/" + auction_name + " for " + std_filename);
					$('#upload-modal').find('h4').html(text + '<br><small>(Drop image file here or click to upload)</small>');
					$('#upload-modal').foundation('open');
			});
			
			$('.fa-spin').hide();
			
			$('#upload-modal').on('closed.zf.reveal', function() {
					$(this).find('.dz-message').remove();
					$(this).find('.dz-image-preview').remove();
					$(this).find('h4').show();
				});
			
			var preview = $('#dz-preview').html();
			$('#dz-preview').remove();
			
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
				std_filename = std_filename + "." + ext;
				console.log(file); console.log(std_filename);
			}).on('sending', function(file, xhr, formData){
				formData.append("std_filename", std_filename);
				formData.append("auction_name", auction_name);
				formData.append("auction_code", auction_code);
				console.log(std_filename);
				//$('[rel="upload"]').find('i').addClass('fa-spin');
				$('.fa-spin').show();
			}).on("success", function(file, response) {
					var pattern = /compulsory_photos/i;
					$('.fa-spin').hide();
					$('#upload-modal').find('.dz-success-mark').show();
					$('[rel="upload"]').removeClass('spin').hide();
					$('#current-photo').find('p').addClass('active');
					var compulsory = $('#current-photo').find('p').attr('class').match( pattern );
					var compulsory_notif = false;
					if(compulsory){ compulsory_photos_count++; compulsory_notif = true; }
					if(compulsory_photos_count == 4 && compulsory_notif){
						$('#edit-info-title').html("Completed Required Photos");
						$('#edit-info-text').html("Required photos are completed. Make your listing more attractive to dealers by adding more photos.");
					    $('#modal_edit_info').foundation('open');
					}
					console.log(response.data.multimedia_uri);
			});
		});
	
})();
</script>   