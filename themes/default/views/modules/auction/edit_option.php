<div class="columns small-12">
	<div class="row">
		<div class="columns small-12 text-center">
			<h2>Options</h2>
		</div>
	</div>
	
	<form id="car-option-detail" class="car-detail">
		<div class="row">
			<div class="columns small-12">
				<div class="input-group">
					<input class="input-group-field" type="text" name="add_single_option" placeholder="Add Option">
					<div class="input-group-button">
						<button class="button orange add-single-option">SUBMIT</button>
					</div>
				</div>
			</div>
		</div>
			
		<div class="row">
			<div class="columns small-12 tag-cloud">
				<p id="option-label">Options</p>
				<?php foreach($data->option as $o){ ?>
				<a id="btn-option-<?= strtolower($o->name) ?>" class="button all-option <?= $o->orange ?>" data-option="<?= $o->name ?>">
					<?= $o->name ?>
				</a>
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
<div class="reveal tiny" id="modal_pickone" data-reveal>
	<div class="row">
		<div class="columns small-12 text-center">
			<h4>Advise</h4>
			<hr>
			<p>Please enter at least one option for your car.</p>
			<div class="button-group">
				<a class="button" rel="button-modal-info" data-value="close">Close</a>
			</div>
		</div>
	</div>
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
<link   rel="stylesheet" href="<?php echo site_url() ?>assets/css/auto-complete.css">
<script type="text/javascript" src="<?php echo site_url() ?>assets/js/auto-complete.min.js"></script>
<script type="text/javascript">
	new autoComplete({
	    selector: 'input[name="add_single_option"]',
	    minChars: 2,
	    source: function(term, suggest){
	        term = term.toLowerCase();
	        var choices = [<?= $car_option_refs; ?>];
	        var matches = [];
	        for (i=0; i<choices.length; i++)
	            if (~choices[i].toLowerCase().indexOf(term)) matches.push(choices[i]);
	        suggest(matches);
	    }
	});
</script>
<script type="text/javascript">
	var options = [<?= $car_options; ?>];
	var option_refs = [<?= $car_option_refs; ?>];
	console.log(options);

	// Add Seller Preferences
	$('#car-option-detail').submit(function(e) {
		var optionData = {
	        'car_sale_id' : <?= $car_sale_id ?>,
	        'options'     : options
	    };

	    $.ajax({
	        type        : "POST", 
	        url         : "<?= $post_update_option_url ?>", 
	        data        : optionData,
	        dataType    : 'json',
	        encode      : true
	    }).done(function(resp) {
	    	$('#edit-info-title').html("Car Option's Details");
			$('#edit-info-text').html("Your Car's Option Details have been updated.");
		    $('#modal_edit_info').foundation('open');
		}).fail(function(resp) { 
			$('#edit-info-title').html("Car Option's Details");
			$('#edit-info-text').html("Error on updating your car's option details.");
		    $('#modal_edit_info').foundation('open');
		}).always(function(resp) { console.log(resp); });

	    e.preventDefault();
	});

	//Disabling Keypress ENTER to submit Option
	$('#car-option-detail').on('keyup keypress', function(e) {
	  var keyCode = e.keyCode || e.which;
	  if (keyCode === 13) { 
	    e.preventDefault();
	    return false;
	  }
	});

	//Add Single Option
	$('.add-single-option').on("click", function( e ) {
		var an_option = $('input[name="add_single_option"]').val();
		if(!an_option){
			$('#modal_pickone').foundation('open');
			//$('#modal_pickone').html(pick_one).foundation('open');
		}
		else{ 
			var index = options.indexOf(an_option);
			if (index < 0) {
			   options.push(an_option);
			   console.log(options);
			   index = option_refs.indexOf(an_option);
			   if (index < 0) {
				   var html_option = '<a id="btn-option-' + an_option.toLowerCase() + '" class="button all-option orange" data-option="' + an_option  +'">' + an_option +'</a>';
				   $(html_option).insertAfter('#option-label');
			   }else{
			   	   var an_option_id = "#btn-option-" + an_option.toLowerCase();
			   	   $(an_option_id).addClass('orange');
			   }
			}
		}
		
		$('input[name="add_single_option"]').val('');
		console.log(options);
	    e.preventDefault();
	});

	$( document ).on( "click", '.all-option', function( e ) {
	  var option_classes = $(this).attr('class'); 
	  var option = $(this).data('option');
	  var pattern = /orange/i;
	  var found = option_classes.match( pattern );
	  if(!found){
	  	$(this).addClass('orange');
	  	options.push(option);
	  }else{
	  	$(this).removeClass('orange');
	 	var index = options.indexOf(option);
		if (index >= 0) {
		   options.splice( index, 1 );
		}
	  }
	  console.log(options);
	});

	$(document).on('click', '[rel="button-modal-info"]', function() {
		$('#modal_pickone').foundation('close');
		$('#modal_edit_info').foundation('close');
	});
</script>