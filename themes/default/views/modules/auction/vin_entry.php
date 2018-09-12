<div class="columns small-12">
	<div class="row uncollapse">
		<div class="columns small-12 small-uncentered medium-10 medium-centered large-8 text-center">
			<h1>List Car</h1>
			<h2>Enter VIN</h2>
		</div>
	</div>
	
	<form method="POST" id="vin-form" action="">
		<div class="row">
			<div class="columns small-12 small-uncentered medium-10 medium-centered large-8 text-center">
				<input type="text" name="vin_code" placeholder="Enter Vehicle's VIN">
				<button class="call-to-action-green btn-vin-query" type="submit"><span>SUBMIT</span></button>
			</div>
		</div>
	</form>
	
	<!--
	<div class="row">
		<div class="columns small-12 small-uncentered medium-10 medium-centered large-8 text-center">
			<p>Data provided by</p>
		</div>
	</div> -->
</div>
<div class="reveal tiny" id="modal_vin_confirmation" data-reveal>
	<div class="row">
		<div class="columns small-12 text-center">
			<h4>Is this VIN correct?</h4>
			<hr>
			<p id="vin-confirm-text"></p>
			<div class="button-group">
				<a id="ok-button" class="button green" rel="button-modal-confirm" data-value="true">YES</a>
				<a id="no-button" class="button green" rel="button-modal-confirm" data-value="false">NO</a>
			</div>
		</div>
	</div>
</div>
<div class="reveal tiny" id="modal_vin_info" data-reveal>
	<div class="row">
		<div class="columns small-12 text-center">
			<h4 id="vin-info-title"></h4>
			<hr>
			<p id="vin-info-text"></p>
			<div class="button-group">
				<a id="close-button" class="button green" rel="button-modal-info" data-value="close">Close</a>
			</div>
		</div>
	</div>
</div>
<?php if($vin_error_message){ ?>
	<script type="text/javascript">
		$( document ).ready(function() {
		    $('#vin-info-title').html("VIN Information");
			$('#vin-info-text').html("<?= 'Sorry, '.$vin_error_message." Please fix your VIN Input."; ?>");
		    $('#modal_vin_info').foundation('open');
		    $('#close-button').click(function () {
			    $('#modal_vin_info').foundation('close');
			    return false;
			});
		});
	</script>
<?php } else if($error) { ?>
	<script type="text/javascript">
		$( document ).ready(function() {
		    $('#vin-info-title').html("VIN Information");
			$('#vin-info-text').html("<?= $error; ?>");
		    $('#modal_vin_info').foundation('open');
		    $('#close-button').click(function () {
			    $('#modal_vin_info').foundation('close');
			    return false;
			});
		});
	</script>
<?php } else { ?>
	<script type="text/javascript">
		var decision = false;
		var vin_no   = '';
		$( document ).on( "click", '[rel="button-modal-confirm"]', function( e ) {
			decision = $(this).data('value');
			if(decision){
				$('#modal_vin_confirmation').foundation('close');
				$('#vin-form').submit();
			}else{
				$('#modal_vin_confirmation').foundation('close');
			}
		});

		$( document ).on( "click", ".btn-vin-query", function( e ) {
			vin_no = $('[name="vin_code"]').val();
			if(vin_no==''){
				$('#vin-info-title').html("VIN Information");
				$('#vin-info-text').html("Sorry, You must enter a VIN No.");
			    $('#modal_vin_info').foundation('open');
			}    
			else{
				$('#vin-confirm-text').html(vin_no);
	    		$('#modal_vin_confirmation').foundation('open');
			}
			e.preventDefault();
		});

		//Disabling Keypress ENTER to submit VIN
		$('#vin-form').on('keyup keypress', function(e) {
		  var keyCode = e.keyCode || e.which;
		  if (keyCode === 13) { 
		    e.preventDefault();
		    return false;
		  }
		});

		$( document ).on( "click", '[rel="button-modal-info"]', function( e ) {
			$('#modal_vin_info').foundation('close');
		});
	</script>
<?php } ?>