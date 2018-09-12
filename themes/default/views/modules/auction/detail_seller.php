<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="columns small-12">
	<div class="row">
		<div class="columns small-12">
			<div class="box-carousel">
				<div class="carousel seller-auction">
					<?php foreach($car_multimedia as $m) { ?>
						<div class="item">
							<img src="<?php echo $m->filename; ?>">
						</div>
					<?php } ?>
				</div>
				
				<p></p>
			</div>
			
			<h2><?= $car_auction->item_title; ?></h2>
			
			<div class="row">
				<div class="columns small-12 medium-8 large-9">
					<p>Trim</p>
				</div>

				<div class="columns small-12 medium-4 large-3 text-right">
					<p><?php if($car_sale->trim) { echo number_format($car_sale->trim). ' '
					.ucwords($car_sale->trim); } 
							else{ echo 'N/A'; } ?></p>
				</div>
				
				<hr>
			</div>
			
			<div class="row">
				<div class="columns small-12 medium-8 large-9">
					<p>Mileage</p>
				</div>
				
				<div class="columns small-12 medium-4 large-3 text-right">
					<p><?php if($car_sale->mileage) { echo number_format($car_sale->mileage). ' '
					.ucwords($car_sale->mileage_type); } 
							else{ echo '0 Mi'; } ?></p>
				</div>
				
				<hr>
			</div>
			
			<div class="row">
				<div class="columns small-12 medium-8 large-9">
					<p>Exterior</p>
				</div>
				
				<div class="columns small-12 medium-4 large-3 text-right">
					<p><?php if($car_sale->exterior_color) { echo $car_sale->exterior_color; } 
							else{ echo 'N/A'; } ?></p>
				</div>
				
				<hr>
			</div>
			
			<div class="row">
				<div class="columns small-12 medium-8 large-9">
					<p>Interior</p>
				</div>
				
				<div class="columns small-12 medium-4 large-3 text-right">
					<p><?php if($car_sale->interior_color) { echo $car_sale->interior_color; } 
							else{ echo 'N/A'; } ?></p>
				</div>
				
				<hr>
			</div>
			
			<div class="row">
				<div class="columns small-12 medium-8 large-9">
					<p>Transmission</p>
				</div>
				
				<div class="columns small-12 medium-4 large-3 text-right">
					<p><?php if($car_sale->transmission != "" ) { echo ucwords(strtolower($car_sale->transmission)); } 
					else { echo 'N/A'; }?>
				</div>
				
				<hr>
			</div>
			
			<div class="row">
				<div class="columns small-12 medium-8 large-9">
					<p>Drive Train</p>
				</div>
				
				<div class="columns small-12 medium-4 large-3 text-right">
					<p><?php if($car_sale->drivetrain != "" ) { echo ucwords(strtolower($car_sale->drivetrain)); } 
					else { echo 'N/A'; }?></p>
				</div>
				
				<hr>
			</div>
			
			<div class="row">
				<div class="columns small-12 medium-8 large-9">
					<p>Fuel Type</p>
				</div>
				
				<div class="columns small-12 medium-4 large-3 text-right">
					<p><?php if($car_sale->fuel_type != "" ) { echo ucwords(strtolower($car_sale->fuel_type)); } 
					else { echo 'N/A'; }?></p>
				</div>
				
				<hr>
			</div>
			
			<div class="row">
				<div class="columns small-12 medium-6">
					<p>Options</p>
				</div>
				
				<div class="columns small-12 medium-6 text-right">
					<?php if($car_condition->options != array()) { 
						foreach($car_condition->options as $options) { ?>
							<a class="button green"><?= $options?></a>
						<?php } 
					} else { ?>
						<p><a>N/A</a></p>
					<?php } ?>
				</div>
				
				<hr>
			</div>
			
			<div class="row">
				<div class="columns small-12 medium-6">
					<p>Needs Repair</p>
				</div>
				
				<div class="columns small-12 medium-6 text-right">
					<?php if($car_condition->needs_repair != array()) { 
						foreach($car_condition->needs_repair as $repair) { ?>
							<a class="button green"><?= $repair?></a>
						<?php } 
					} else { ?>
						<p><a>N/A</a></p>
					<?php } ?>
				</div>
				
				<hr>
			</div>
			
			<div class="row">
				<div class="columns small-12 medium-8 large-9">
					<p>Has Accident</p>
				</div>
				
				<div class="columns small-12 medium-4 large-3 text-right">
				<?php if($car_sale->has_accident){ ?>
					<p><?= $car_sale->has_accident ?>
						<?php if($car_sale->has_accident == 'Yes') { ?>
							<br><?= 'Repairs: $'.$car_sale->value_repair; 
						}
					}else{
						echo 'N/A';
						} ?>
					</p>
				</div>
				
				<hr>
			</div>
			
			<div class="row">
				<div class="columns small-12 ">
					<p>Notes</p>
				</div>
				
				<div class="columns small-12">
					<p><?php if($car_declaration_details != NULL ) { echo $car_declaration_details; }
					else{ echo 'N/A'; } ?>
					</p>
				</div>
				
				<hr>
			</div>
			<?php if($car_auction->status != 2){ ?>
			<div class="row">
				<div class="columns small-3">&nbsp;</div>
				<div class="columns small-3">
					<a class="call-to-action delete-auction" data-auction="<?= $auction_id;?>" data-car="<?= $auction_car;?>"><span>Delete</span></a>
				</div>
				<div class="columns small-3">
					<a class="call-to-action-green live-auction" data-auction="<?= $auction_id;?>"><span>Auction</span></a>
				</div>
				<div class="columns small-3">&nbsp;</div>
			</div>
			<?php }else{ ?>
			<div class="row">
				<div class="small-12">
					<a class="call-to-action" href="<?= site_url('auction/'.$auction_id.'/edit/'.$car_auction->car_sale_id) ?>"><span>Edit</span></a>	
				</div>
			</div>
			<?php } ?>
		</div>
	</div>
</div>
<div class="reveal tiny" id="modal_confirm_delete" data-reveal>
	<div class="row">
		<div class="columns small-12 text-center">
			<h4>Are you sure to delete this auction?</h4>
			<div class="button-group">
				<a class="button green" rel="button-modal-confirm-delete" data-value="no">No</a>
				<a class="button green" rel="button-modal-confirm-delete" data-value="yes">Yes</a>
			</div>
		</div>
	</div>
</div>
<div class="reveal tiny" id="modal_active_auction" data-reveal></div>
<script type="text/javascript">
	var complete 		= true;
	var set_live 		= false;
	// var declare_answers = <?= json_encode($declare_answers); ?>;
	// console.log(declare_answers);

	// declare_answers.forEach(function(declare){
	// 	if(declare == ""){
	// 		complete = false;
	// 	}
	// 	console.log(complete);
	// });

	$( document ).on( "click", '.live-auction', function( e ) {
		var auction_id  =  $(this).data('auction');
		var auctionData =  { 'auction_id' : auction_id };
		var auctionURL  =  "<?= site_url('auction/set_auction') ?>/" + auction_id + "/active";

		if(complete){
			$.ajax({ 
			type : "POST", url : auctionURL, data : auctionData, dataType : 'json', encode : true })
			.done(function(data) { 
				if(data.start_time && data.endtime){
					$('#modal_active_auction').html(
					'<h4>Auction is Activated</h4>' + '<p>Auction will live on ' + data.start_time + ' - ' + data.endtime + '</p>' 
					+ '<a class="button green" rel="button-modal-confirm-ok-auction" data-value="ok">OK</a>')
					.foundation('open');
					set_live = true;
				}
				else
					$('#modal_active_auction').html(
					'<h4>Active Auction</h4>' + '<p>Auction is already active on upcoming auction. </p>' 
					+ '<a class="button green" rel="button-modal-confirm-ok" data-value="ok">OK</a>')
					.foundation('open');
					set_live = true;
			})
			.fail(function(data) { })
			.always(function(data){ console.log(data); });
		}
		else{
			$('#modal_active_auction').html(
			'<h4>Active Auction</h4>' + '<p>Please complete your car declaration.</p>' 
			+ '<a class="button green" rel="button-modal-confirm-ok" data-value="ok">OK</a>')
			.foundation('open');
		}
			
	});

	$(document).on('click', '[rel="button-modal-confirm-ok-auction"]', function() {
		$('#modal_active_auction').foundation('close');
		if(set_live){ window.location = "<?= site_url('seller'); ?>"; }
	});

	$(document).on('click', '[rel="button-modal-confirm-ok"]', function() {
		$('#modal_active_auction').foundation('close'); 
		if(set_live){ window.location = "<?= site_url('seller'); ?>"; }
	});

	$( document ).on( "click", '.delete-auction', function( e ) {
		$('#modal_confirm_delete').foundation('open');
	});

	$(document).on('click', '[rel="button-modal-confirm-delete"]', function() {
			var val = $(this).attr('data-value');
			if (val === "yes") { 
				var auction_id   =  $('.delete-auction').data('auction');
				var auction_car  =  $('.delete-auction').data('car');
				var auctionData  =  { 'auction_car' : auction_car };
				var auctionURL   =  "<?= site_url('auction/delete') ?>/" + auction_id + "/" + auction_car;
				$.ajax({ 
					type : "POST", url : auctionURL, data : auctionData, dataType : 'json', encode : true })
					.done(function(data) { window.location = "<?= site_url('seller'); ?>"; } )
					.fail(function(data) { })
					.always(function(data){ });
				
			} else { }
			$('#modal_confirm_delete').foundation('close'); 
	});
</script>
<script>
(function(){
  	"use strict";
  	
  	$(document).on('ready', function() {
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
			  	infinite: false }).on('init', function(event){
					console.log(event);
			});
		});
})();
</script>