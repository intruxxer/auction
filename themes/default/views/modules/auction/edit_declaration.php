<div class="columns small-12">
	<div class="row">
		<div class="columns small-12 text-center">
			<h2>Declarations</h2>
		</div>
	</div>
	
	<form id="car-declaration-form" class="car-detail">
		<?php foreach ($data->declarations as $num => $d) { ?>
		<div class="row">
			<div class="columns small-12">
				<p><?= $d->question ?></p>
				<?php foreach ($d->answers as $a) { ?>
					<?php if(count($d->answers) == 3){ ?>
						<?php if($a=='1') { ?>
	                	<a class="button declare-btn <?= $answer[$num]->true_orange; ?>" data-num="<?= $num ?>" data-value="1">True</a>  
	                	<?php } elseif($a=='2') { ?>
	                	<a class="button declare-btn <?= $answer[$num]->false_orange; ?>" data-num="<?= $num ?>" data-value="2">False</a>  
	                	<?php } elseif($a=='3') { ?>
	                	<a class="button declare-btn <?= $answer[$num]->unknown_orange; ?>" data-num="<?= $num ?>" data-value="3">Unknown</a>  
	                	<?php } ?>
	                <?php } ?>
	                <?php if(count($d->answers) == 2){ ?>
	                	<?php if($a=='1') { ?>
	                	<a class="button declare-btn <?= $answer[$num]->true_orange; ?>" data-num="<?= $num ?>" data-value="1">Yes</a>  
	                	<?php } elseif($a=='2') { ?>
	                	<a class="button declare-btn <?= $answer[$num]->false_orange; ?>" data-num="<?= $num ?>" data-value="2">No</a>  
	                	<?php } ?>
	                <?php } ?>
              	<?php } ?>
              	<?php if(count($d->answers) == 2){ ?>
              			<a class="button declare-btn <?= $answer[$num]->unknown_orange; ?>" data-num="<?= $num ?>" data-value="3">Unknown</a> 
              	<?php } ?>
			</div>
			
			<hr>
		</div>
		<?php } ?>
		<div class="row">
			<div class="columns small-12">
				<p>Details</p>
				<textarea id="declaration-detail"><?= $data->declaration_details ?></textarea>
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
	var declare_answers = <?= $answers_array ?>;
	console.log(declare_answers);

	$( document ).on( "click", '.declare-btn', function( e ) {
		  var declare_classes = $(this).attr('class'); 
		  var declare_index   = $(this).data('num');
		  var declare_value   = $(this).data('value');
		  var pattern = /orange/i;
		  var found = declare_classes.match( pattern );
		  if(!found){
		  	$(this).siblings().removeClass('orange');
		  	$(this).addClass('orange');
		  	declare_answers[declare_index] = declare_value;
		  }else{ }
		  console.log(declare_answers);
	});

	$('#car-declaration-form').submit(function(e) {
			var declaration_detail = $('#declaration-detail').val();

			var formData = {
				"car_sale_id"     : <?= $car_sale_id ?>,
				"details"         : declaration_detail,
				"answers" 		  : declare_answers //declare_answers.toString()
			}; 
			console.log(formData); 

			$.ajax({
			        type        : 'POST', 
			        url         : '<?= $update_declaration_url ?>', 
			        data        : formData,
			        dataType    : 'json',
			        encode      : true
			    }).done(function(resp) { 
			    	$('#edit-info-title').html("Declaration");
					$('#edit-info-text').html("Your Declarations have been updated.");
				    $('#modal_edit_info').foundation('open');
			    	
			    }).fail(function(resp) {
				    $('#edit-info-title').html("Car Interior");
					$('#edit-info-text').html("Error on updating your declarations.");
				    $('#modal_edit_info').foundation('open');
				}).always(function(resp) {
			    	console.log(resp); 
			});

			e.preventDefault();
	});

	$('#car-declaration-form').on('keyup keypress', function(e) {
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