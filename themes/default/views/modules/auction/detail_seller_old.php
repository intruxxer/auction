<div class="columns small-12">
	<div class="row">
		<div class="columns small-12">
			<div class="carousel">
				<?php foreach($car_multimedia as $m) { ?>
					<div class="item">
						<img src="<?php echo $m->filename; ?>">
					</div>
				<?php } ?>
			</div>
			
			<h2><?= $car_auction->item_title; ?></h2>
			
			<p><?= $car_sale->doors.' Doors '.$car_sale->body_style; ?></p>
			
			
			<h4><?php if($car_declaration_details) { echo 'Remarks: ' . $car_declaration_details; }
						else{ echo 'Remarks: N/A'; } ?></h4>
			
			<ul class="spec">
				<li class="fuel">
					<?php if($car_sale->fuel_type){ echo ucwords($car_sale->fuel_type); }
							else{ echo 'N/A'; } ?>
				</li>
				
				<li class="odometer">
					<?php if($car_sale->mileage) { echo number_format($car_sale->mileage). ' '
					.ucwords($car_sale->mileage_type); } 
							else{ echo '0 Mi'; } ?>
				</li>
				
				<li class="transmission"><?php if($car_sale->transmission) { echo ucwords(strtolower($car_sale->transmission)); }
						else{ echo 'N/A'; } ?>
				</li>
				
				<li class="capacity"><?php echo '0 Person';  ?></li>
			</ul>
			
			<h4>Description</h4>
			
			<p><?php if($car_condition->condition_details) { echo $car_condition->condition_details; }
						else{ echo 'N/A'; } ?>
			</p>
			
			<ul class="accordion" data-accordion>
				<li class="accordion-item" data-accordion-item>
					<a href="#" class="accordion-title">Detail</a>
					
					<div class="accordion-content car-detail" data-tab-content>
						<div class="row">
							<div class="columns small-6 large-8">
								<p>As-Is</p>
							</div>
							
							<div class="columns small-6 large-4 text-right">
								<?php if($car_sale->as_is == 1) { ?>
									<a class="button orange"><i class="fa fa-check"></i></a>
								<?php } else { ?>
									<a class="button orange"><i class="fa fa-close"></i></a>
								<?php } ?>
							</div>
							
							<hr>
						</div>
						
						<div class="row">
							<div class="columns small-6 large-8">
								<p>Make</p>
							</div>
							
							<div class="columns small-6 large-4 text-right">
								<p class="disabled"><?= $car_sale->make; ?></p>
							</div>
							
							<hr>
						</div>
						
						<div class="row">
							<div class="columns small-6 large-8">
								<p>Model</p>
							</div>
							
							<div class="columns small-6 large-4 text-right">
								<p class="disabled"><?= $car_sale->model; ?></p>
							</div>
							
							<hr>
						</div>
						
						<div class="row">
							<div class="columns small-6 large-8">
								<p>Trim</p>
							</div>
							
							<div class="columns small-6 large-4 text-right">
								<p class="disabled"><?= $car_sale->trim; ?></p>
							</div>
							
							<hr>
						</div>
						
						<div class="row">
							<div class="columns small-6 large-8">
								<p>Year</p>
							</div>
							
							<div class="columns small-6 large-4 text-right">
								<p class="disabled"><?= $car_sale->year; ?></p>
							</div>
							
							<hr>
						</div>
						
						<div class="row">
							<div class="columns small-6 large-8">
								<p>Milage</p>
							</div>
							
							<div class="columns small-6 large-4 text-right">
								<p><a>
									<?php if($car_sale->mileage) { echo number_format($car_sale->mileage). ' '
									.ucwords($car_sale->mileage_type); } 
											else{ echo '0 Mi'; } ?>
								</a></p>
							</div>
							
							<hr>
						</div>
						
						<div class="row">
							<div class="columns small-6 large-8">
								<p>Price</p>
							</div>
							
							<div class="columns small-6 large-4 text-right">
								<p class="disabled">
									<?php if($car_auction->price) { echo '$ '.number_format($car_auction->price); } 
											else{ echo '$ 0'; } ?>
								</p>
							</div>
						</div>
					</div>
				</li>
				
				<li class="accordion-item" data-accordion-item>
					<a href="#" class="accordion-title">Exterior</a>
					
					<div class="accordion-content car-detail" data-tab-content>
						<div class="row">
							<div class="columns small-6 large-8">
								<p>Color</p>
							</div>
							
							<div class="columns small-6 large-4 text-right">
								<p><a>
									<?php if($car_sale->exterior_color) { echo $car_sale->exterior_color; } 
											else{ echo 'N/A'; } ?>
								</a></p>
							</div>
						</div>
					</div>
				</li>

				<li class="accordion-item" data-accordion-item>
					<a href="#" class="accordion-title">Interior</a>
					
					<div class="accordion-content car-detail" data-tab-content>
						<div class="row">
							<div class="columns small-6 large-8">
								<p>Materials</p>
							</div>
							
							<div class="columns small-6 large-4 text-right">
								<?php if($car_sale->interior_material != array("")) { 
									foreach($car_sale->interior_material as $material) { ?>
										<a class="button orange"><?= $material?></a>
									<?php } 
								} else { ?>
									<p><a>N/A</a></p>
								<?php } ?>
							</div>
							
							<hr>
						</div>
						
						<div class="row">
							<div class="columns small-6 large-8">
								<p>Color</p>
							</div>
							
							<div class="columns small-6 large-4 text-right">
								<p><a><?php if($car_sale->interior_color) { echo $car_sale->interior_color; } 
											else{ echo 'N/A'; } ?>
								</a></p>
							</div>
						</div>
					</div>
				</li>
				
				<li class="accordion-item" data-accordion-item>
					<a href="#" class="accordion-title">Mechanical</a>
					
					<div class="accordion-content car-detail" data-tab-content>
						<div class="row">
							<div class="columns small-6 large-8">
								<p>Transmission</p>
							</div>
							
							<div class="columns small-6 large-4 text-right">
								<?php if($car_sale->transmission != "" ) { ?>
									<a class="button orange"><?= ucwords(strtolower($car_sale->transmission)); ?></a>
								<?php } else { ?>
									<p><a>N/A</a></p>
								<?php } ?>
							</div>
							
							<hr>
						</div>
						
						<div class="row">
							<div class="columns small-6 large-8">
								<p>Drivetrain</p>
							</div>
							
							<div class="columns small-6 large-4 text-right">
								<?php if($car_sale->drivetrain != "" ) { ?>
									<a class="button orange"><?= ucwords(strtolower($car_sale->drivetrain)); ?></a>
								<?php } else { ?>
									<p><a>N/A</a></p>
								<?php } ?>
							</div>
							
							<hr>
						</div>
						
						<div class="row">
							<div class="columns small-6 large-8">
								<p>Cylinders</p>
							</div>
							
							<div class="columns small-6 large-4 text-right">
								<?php if($car_sale->cylinders != 0 ) { ?>
									<a class="button orange"><?= $car_sale->cylinders; ?></a>
								<?php } else { ?>
									<p><a>N/A</a></p>
								<?php } ?>
							</div>
							
							<hr>
						</div>
						
						<div class="row">
							<div class="columns small-6 large-8">
								<p>Displacement</p>
							</div>
							
							<div class="columns small-6 large-4 text-right">
								<?php if($car_sale->displacement != "" ) { ?>
									<p><a><?= $car_sale->displacement; ?></a></p>
								<?php } else { ?>
									<p><a>N/A</a></p>
								<?php } ?>
							</div>
							
							<hr>
						</div>
						
						<div class="row">
							<div class="columns small-6 large-8">
								<p>Fuel Type</p>
							</div>
							
							<div class="columns small-6 large-4 text-right">
								<?php if($car_sale->fuel_type != "" ) { ?>
									<a class="button orange"><?= ucwords(strtolower($car_sale->fuel_type)); ?></a>
								<?php } else { ?>
									<p><a>N/A</a></p>
								<?php } ?>
							</div>
						</div>
					</div>
				</li>
				
				<li class="accordion-item" data-accordion-item>
					<a href="#" class="accordion-title">Options</a>
					
					<div class="accordion-content car-detail" data-tab-content>
						<div class="row">
							<div class="columns small-12">
								<?php if($car_condition->options != array()) { 
									foreach($car_condition->options as $options) { ?>
										<a class="button orange"><?= $options?></a>
									<?php } 
								} else { ?>
									<p><a>N/A</a></p>
								<?php } ?>
							</div>
						</div>
					</div>
				</li>
				
				<li class="accordion-item" data-accordion-item>
					<a href="#" class="accordion-title">Declarations</a>
					
					<div class="accordion-content car-detail" data-tab-content>
						<?php foreach($car_declaration as $d) { ?>
						<div class="row">
							<div class="columns small-6 large-8">
								<p><?= $d->question;?></p>
							</div>
							
							<div class="columns small-6 large-4 text-right">
								<?php if($d->answer == "1" ) { ?>
									<a class="button orange">True</a>
								<?php } elseif($d->answer == "2") { ?>
									<a class="button orange">False</a>
								<?php } elseif($d->answer == "3") { ?>
									<a class="button orange">Unknown</a>
								<?php } else { ?>
									<p><a>N/A</a></p>
								<?php } ?>
							</div>
							
							<hr>
						</div>
						<?php } ?>
						<div class="row">
							<div class="columns small-12">
								<h4>Declaration Detail</h4>
								<?php if($car_declaration_details != NULL ) { ?>
									<p><?= $car_declaration_details; ?></p>
								<?php } else { ?>
									<p><a>N/A</a></p>
								<?php } ?>
							</div>
						</div>
					</div>
					
				</li>
				
				<li class="accordion-item" data-accordion-item>
					<a href="#" class="accordion-title">Conditions</a>
					
					<div class="accordion-content car-detail" data-tab-content>
						<div class="row">
							<div class="columns small-12">
								<p>Needs repair</p>
								<?php if($car_condition->needs_repair != array()) { 
									foreach($car_condition->needs_repair as $repair) { ?>
										<a class="button orange"><?= $repair?></a>
									<?php } 
								} else { ?>
									<p><a>N/A</a></p>
								<?php } ?>
							</div>
							
							<hr>
						</div>
						
						<div class="row">
							<div class="columns small-6 large-8">
								<p>Windshield Condition</p>
							</div>
							
							<div class="columns small-6 large-4 text-right">
								<?php if($car_condition->windshield_condition != array()) { 
									foreach($car_condition->windshield_condition as $windshield) { ?>
										<a class="button orange"><?= $windshield?></a>
									<?php } 
								} else { ?>
									<p><a>N/A</a></p>
								<?php } ?>
							</div>
							
							<hr>
						</div>
						
						<div class="row">
							<div class="columns small-6 large-8">
								<p>Tire Condition</p>
							</div>
							
							<div class="columns small-6 large-4 text-right">
								<?php if($car_condition->tire_condition != "" ) { ?>
									<a class="button orange"><?= ucwords(strtolower($car_condition->tire_condition)); ?></a>
								<?php } else { ?>
									<p><a>N/A</a></p>
								<?php } ?>
							</div>
							
							<hr>
						</div>
						
						<div class="row">
							<div class="columns small-6 large-8">
								<p>Airbag Condition</p>
							</div>
							
							<div class="columns small-6 large-4 text-right">
								<?php if($car_condition->airbags_condition != "" ) { ?>
									<a class="button orange"><?= ucwords(strtolower($car_condition->airbags_condition)); ?></a>
								<?php } else { ?>
									<p><a>N/A</a></p>
								<?php } ?>
							</div>
							
							<hr>
						</div>
						
						<div class="row">
							<div class="columns small-6 large-8">
								<p>Anti-lock Breaking System Condition</p>
							</div>
							
							<div class="columns small-6 large-4 text-right">
								<?php if($car_condition->antilock_breaks_condition != "" ) { ?>
									<a class="button orange"><?= ucwords(strtolower($car_condition->antilock_breaks_condition)); ?></a>
								<?php } else { ?>
									<p><a>N/A</a></p>
								<?php } ?>
							</div>
							
							<hr>
						</div>
						
						<div class="row">
							<div class="columns small-12">
								<h4>Detail</h4>
								<?php if($car_condition->condition_details != NULL ) { ?>
									<p><?= $car_condition->condition_details; ?></p>
								<?php } else { ?>
									<p><a>N/A</a></p>
								<?php } ?>
							</div>
						</div>
					</div>
				</li>
			</ul>

			<div class="row">
				<div class="columns small-3">&nbsp;</div>
				<div class="columns small-3">
					<a class="call-to-action delete-auction" data-auction="<?= $auction_id;?>" data-car="<?= $auction_car;?>"><span>Delete</span></a>
				</div>
				<div class="columns small-3">
					<a class="call-to-action live-auction" data-auction="<?= $auction_id;?>"><span>Auction</span></a>
				</div>
				<div class="columns small-3">&nbsp;</div>
			</div>
		</div>
	</div>
</div>
<div class="reveal tiny" id="modal_confirm_delete" data-reveal>
	<div class="row">
		<div class="columns small-12 text-center">
			<h4>Are you sure you want to delete?</h4>
			<div class="button-group">
				<a class="button" rel="button-modal-confirm-delete" data-value="no">No</a>
				<a class="button" rel="button-modal-confirm-delete" data-value="yes">Yes</a>
			</div>
		</div>
	</div>
</div>
<div class="reveal tiny" id="modal_active_auction" data-reveal></div>
<script type="text/javascript">
	var complete 		= true;
	var declare_answers = <?= json_encode($declare_answers); ?>;
	console.log(declare_answers);

	declare_answers.forEach(function(declare){
		if(declare == ""){
			complete = false;
		}
		console.log(complete);
	});

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
					'<h4>Auction is activated</h4>' + '<p>Auction is active on ' + data.start_time + ' - ' + data.endtime + '</p>' 
					+ '<a class="button" rel="button-modal-confirm-ok-auction" data-value="ok">OK</a>')
					.foundation('open');
				}
				else
					$('#modal_active_auction').html(
					'<h4>Active Auction</h4>' + '<p>Auction is already active on upcoming auction. </p>' 
					+ '<a class="button" rel="button-modal-confirm-ok" data-value="ok">OK</a>')
					.foundation('open');
			})
			.fail(function(data) { })
			.always(function(data){ console.log(data); });
		}
		else{
			$('#modal_active_auction').html(
			'<h4>Active Auction</h4>' + '<p>Please complete your car declaration</p>' 
			+ '<a class="button" rel="button-modal-confirm-ok" data-value="ok">OK</a>')
			.foundation('open');
		}
			
	});

	$(document).on('click', '[rel="button-modal-confirm-ok-auction"]', function() {
		$('#modal_active_auction').foundation('close'); 
		window.location.href = "<?= site_url('seller/preference');?>";
	});

	$(document).on('click', '[rel="button-modal-confirm-ok"]', function() {
		$('#modal_active_auction').foundation('close'); 
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