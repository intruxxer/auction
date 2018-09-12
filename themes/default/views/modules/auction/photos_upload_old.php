<div class="columns small-12">
	<div class="row uncollapse">
		<div class="columns small-12 small-uncentered medium-10 medium-centered large-8 text-center">
			<h1>List Car</h1>
		</div>
	</div>
	<div class="row">
		<form enctype="multipart/form-data" method="POST" action="<?= $upload_photo_url ?>" class="columns small-12">
			
			<input type="hidden" name="seller_id" value="<?= $seller_id?>"/>
			<input type="hidden" name="vin" value="<?= $data->vin;?>"/>
			<input type="hidden" name="year" value="<?= $data->year;?>"/>
			<input type="hidden" name="make" value="<?= $data->make;?>"/>
			<input type="hidden" name="model" value="<?= $data->model;?>"/>
			<input type="hidden" name="trim" value="<?= $data->trim;?>"/>
			<input type="hidden" name="trim_ids" value="<?= $trim_ids.'/-';?>"/>
			<input type="hidden" name="trim_models" value="<?= $trim_models;?>"/>
			<input type="hidden" name="transmission" value="<?= $transmission;?>"/>
			<input type="hidden" name="drivetrain" value="<?= $data->drivetrain;?>"/>
			<input type="hidden" name="body_style" value="<?= $data->body_style;?>"/>
			<input type="hidden" name="form" value="web"/>
			
            <!-- <input type="hidden" name="exterior_color" value="<?= $data->exterior_color;?>"/> -->
			<!-- <input type="hidden" name="interior_color" value="<?= $data->interior_color;?>"/> -->
			<!-- <input type="hidden" name="cylinders" value="<?= $data->cylinders;?>"/> -->
			<!-- <input type="hidden" name="fuel_type" value="<?= $data->fuel_type;?>"/> -->
			<!-- <input type="hidden" name="doors" value="<?= $data->doors;?>"/> -->
			
			<div class="row">
				<div class="columns small-12 medium-8 large-9">
					<p>3/4 Front ( Main Photo )</p>
				</div>
				<div class="columns small-12 medium-4 large-3 text-right">
					<input type="file" name="34_front" />
				</div>
				<hr>
			</div>

			<!-- <form id="upload-car-photo"> -->

			<!--
			<div class="row">
				<div class="columns small-12 medium-8 large-9">
					<p class="number active">1</p>
					<p class="active">3/4 Front ( Main Photo )</p>
				</div>
				
				<div class="columns small-12 medium-4 large-3 text-right">
					<a class="icon" rel="upload-photo" data-open="upload-modal"><i class="fa fa-camera"></i></a>
				</div>
			</div>
			-->
			
			<div class="row">
				<div class="columns small-12 medium-8 large-9">
					<p>Front</p>
				</div>
				
				<div class="columns small-12 medium-4 large-3 text-right">
					<input type="file" name="pictures[]" />
				</div>
				<hr>
			</div>
			
			<div class="row">
				<div class="columns small-12 medium-8 large-9">
					<p>Driver Side</p>
				</div>
				
				<div class="columns small-12 medium-4 large-3 text-right">
					<input type="file" name="pictures[]" />
				</div>
				<hr>
			</div>
			
			<div class="row">
				<div class="columns small-12 medium-8 large-9">
					<p>Back</p>
				</div>
				
				<div class="columns small-12 medium-4 large-3 text-right">
					<input type="file" name="pictures[]" />
				</div>
				<hr>
			</div>
			
			<div class="row">
				<div class="columns small-12 medium-8 large-9">
					<p>Passenger Side</p>
				</div>
				
				<div class="columns small-12 medium-4 large-3 text-right">
					<input type="file" name="pictures[]" />
				</div>
				<hr>
			</div>
			
			<div class="row">
				<div class="columns small-12 medium-8 large-9">
					<p>Tire</p>
				</div>
				
				<div class="columns small-12 medium-4 large-3 text-right">
					<input type="file" name="pictures[]" />
				</div>
				<hr>
			</div>
			
			<div class="row">
				<div class="columns small-12 medium-8 large-9">
					<p>Interior Driver Side</p>
				</div>
				
				<div class="columns small-12 medium-4 large-3 text-right">
					<input type="file" name="pictures[]" />
				</div>
				<hr>
			</div>
			
			<div class="row">
				<div class="columns small-12 medium-8 large-9">
					<p>Console</p>
				</div>
				
				<div class="columns small-12 medium-4 large-3 text-right">
					<input type="file" name="pictures[]" />
				</div>
				<hr>
			</div> 
			
			<div class="row" style="margin-top: 24px;">
				<div class="small-12 text-center">
					<button class="call-to-action"><span>Continue</span></button>	
				</div>
			</div>
		</form>
	</div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/dropzone.min.js"></script>

<!-- upload modal -->
<div class="reveal" id="upload-modal" data-reveal>
	<div class="dropzone" id="dropzone">
		<h3>Drop file here or click to upload</h3>
	</div>
</div>

<!-- end upload modal -->
<script>
(function(){
	"use strict";
	
	$(document).on('ready', function() {
			$('[rel="add-photo-row"]').on('click', function() {
					var row = $(this).closest('.row').prev().html();
					var number = parseInt($(row).find('.number').text());
					
					var new_row = $(this).closest('.row').before('<div class="row">' + row + '</div>');
					
					$(this).closest('.row').prev().find('.number').text(number + 1);
				});
				
			$('[rel="upload-photo"]').on('click', function() {
					$(this).closest('.row').attr('id', 'current-photo');
					
					var text = $(this).closest('.row').find('[role="title"]').text();
					
					$('#upload-modal').find('h4').html(text + '<br><small>(Drop image file here or click to upload)</small>');
					
					$('#upload-modal').foundation('open');
				});
				
			
			$('#upload-modal').on('closed.zf.reveal', function() {
					$(this).find('.dz-message').remove();
					$(this).find('.dz-image-preview').remove();
					$(this).find('h4').show();
				});
			
			var preview = $('#dz-preview').html();
			$('#dz-preview').remove();
			
			Dropzone.autoDiscover = false;
		
			var dropzone = new Dropzone("#dropzone",{
				url: "<?= $upload_photo_url ?>",
				method: "post",
				acceptedFiles: "image/*",
				paramName: "userfile",
				autoProcessQueue: false,
				previewTemplate: preview,
				thumbnailWidth: 480,
				thumbnailHeight: 270,
			});
			
			dropzone.on("addedfile", function(file) {
				$('#upload-modal').find('h4').hide();
				
				$('[rel="upload"]').on('click', function() {
						dropzone.processQueue();
					}).show();
					
			}).on('sending', function(){
				$('[rel="upload"]').find('i').addClass('spin').unbind();
				
			}).on("success", function() {
					$('#upload-modal').find('.dz-success-mark').show();
					
					$('[rel="upload"]').removeClass('spin').hide();
					
					$('#current-photo').find('p').addClass('active');
				});
			
		});
	
})();
</script>