<div class="columns small-12">
	<div class="row">
		<div class="columns small-12">
			<div class="box-carousel">
				<div class="carousel seller-auction">
					<?php foreach($car_multimedia as $m) { ?>
						<div class="item">
							<img src="<?php echo $m; ?>">
						</div>
					<?php } ?>
				</div>
				
				<p></p>
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
				
				<li class="transmission">
					<?php if($car_sale->transmission) { echo ucwords(strtolower($car_sale->transmission)); }
						else{ echo 'N/A'; } ?>
				</li>
				
				<li class="capacity"><?php echo '0 Person';  ?></li>
			</ul>
		<?php if($live) { ?>
			<p class="countdown-clock">
				<i class="fa fa-clock-o"></i> 
				<span id="countdown-clock-<?= $car_auction->auction_id; ?>">
					N/A
				</span>
			</p>
			
			<div class="row bids">
				<div class="columns small-12 medium-6">
					<p>Current Bid</p>
				</div>
				
				<div class="columns small-12 medium-6">
					<p class="text-right"><?= '$ '.$car_auction->current_bid; ?></p>
				</div>
				
				<hr>
			</div>
			
			<div class="row">
				<div class="columns small-12 medium-6">
					<p>My Lastest Bid</p>
				</div>
				
				<div class="columns small-12 medium-6">
					<p class="text-right"><?= '$ '.$car_auction->my_last_bid; ?></p>
				</div>
				
				<hr>
			</div>
			
			<div class="row">
				<div class="columns small-12">
					<div class="input-group">
						<input class="input-group-field custom-bid" type="text" placeholder="Your bid">
						<div class="input-group-button">
							<button id="custom-bid-btn" class="button green">SUBMIT</button>
						</div>
					</div>
				</div>
			</div>
			
			<br>
			
			<div class="row small-up-3 quick-bids">
				<div class="column column-block">
					<a class="button green add-bid" 
					   data-bid="<?= $car_auction->trade_options[0]; ?>"
					   data-auction="<?= $car_auction->auction_id; ?>" 
					   data-dealer="<?= $dealer_id; ?>">
						$<?= $car_auction->trade_options[0]; ?>
					</a>
				</div>
				
				<div class="column column-block">
					<a class="button green add-bid" 
					   data-bid="<?= $car_auction->trade_options[1]; ?>"
					   data-auction="<?= $car_auction->auction_id; ?>" 
					   data-dealer="<?= $dealer_id; ?>">
						$<?= $car_auction->trade_options[1]; ?>
					</a>
				</div>
				
				<div class="column column-block">
					<a class="button green add-bid" 
					   data-bid="<?= $car_auction->trade_options[2]; ?>"
					   data-auction="<?= $car_auction->auction_id; ?>" 
					   data-dealer="<?= $dealer_id; ?>">
						$<?= $car_auction->trade_options[2]; ?>
					</a>
				</div>
			</div>
		<?php } ?>
			<div class="row small-up-2">
				<div class="column column-block">
					<?php if(!$car_auction->on_watchlist){ $add_remove = 'add'; }else{ $add_remove = 'remove'; }?>
					<a id="btn-watchlist-<?= $car_auction->auction_id ?>" class="call-to-action add-remove-watchlist" 
					   data-auction="<?= $car_auction->auction_id; ?>" 
					   data-dealer="<?= $dealer_id; ?>" 
					   data-watchlist="<?= $add_remove ?>">
						<span>
							<?= ucwords($add_remove); ?>&nbsp;&nbsp;&nbsp;
							<img src="<?php echo base_url(); ?>assets/img/icon-button-watchlist.png">
						</span>
					</a>
				</div>
				
				<div class="column column-block">
					<a class="call-to-action contact-seller"><span>Contact Seller</span></a>
				</div>
			</div>
			
			<br><br><br>

			<div class="row">
				<div class="columns small-12 medium-8 large-9">
					<p>Trim</p>
				</div>
				
				<div class="columns small-12 medium-4 large-3 text-right">
					<p><?= $car_sale->trim; ?></p>
				</div>
				
				<hr

			<div class="row">
				<div class="columns small-12 medium-8 large-9">
					<p>Mileage</p>
				</div>
				
				<div class="columns small-12 medium-4 large-3 text-right">
					<p><?php if($car_sale->mileage) { echo number_format($car_sale->mileage). ' '
						       .ucwords($car_sale->mileage_type); } 
							 else{ echo '0 Km'; } 
					    ?>
					</p>
				</div>
				
				<hr>
			</div>

			<div class="row">
				<div class="columns small-12 medium-8 large-9">
					<p>Exterior</p>
				</div>
				
				<div class="columns small-12 medium-4 large-3 text-right">
					<p><?php if($car_sale->exterior_color) { echo $car_sale->exterior_color; } 
						     else{ echo 'N/A'; } 
					    ?>
					</p>
				</div>
				
				<hr>
			</div>

			<div class="row">
				<div class="columns small-12 medium-8 large-9">
					<p>Interior</p>
				</div>
				
				<div class="columns small-12 medium-4 large-3 text-right">
					<p><?php if($car_sale->interior_color) { echo $car_sale->interior_color; } 
						     else{ echo 'N/A'; } 
					    ?>
					</p>
				</div>
				
				<hr>
			</div>
			
			<div class="row">
				<div class="columns small-12 medium-8 large-9">
					<p>Transmission</p>
				</div>
				
				<div class="columns small-12 medium-4 large-3 text-right">
					<?php if($car_sale->transmission != "" ) { ?>
						<p><?= ucwords(strtolower($car_sale->transmission)); ?></p>
					<?php } else { ?>
						<p>N/A</p>
					<?php } ?>
				</div>
				
				<hr>
			</div>
			
			<div class="row">
				<div class="columns small-12 medium-8 large-9">
					<p>Drive Train</p>
				</div>
				
				<div class="columns small-12 medium-4 large-3 text-right">
					<?php if($car_sale->drivetrain != "" ) { ?>
						<p><?= ucwords(strtolower($car_sale->drivetrain)); ?></p>
					<?php } else { ?>
						<p>N/A</p>
					<?php } ?>
				</div>
				
				<hr>
			</div>
			
			<div class="row">
				<div class="columns small-12 medium-8 large-9">
					<p>Fuel Type</p>
				</div>
				
				<div class="columns small-12 medium-4 large-3 text-right">
					<?php if($car_sale->fuel_type != "" ) { ?>
						  <p><?= ucwords(strtolower($car_sale->fuel_type)); ?></p>
					<?php } else { ?>
						  <p>N/A</p>
					<?php } ?>
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
					<?php } } else { ?>
								<a>N/A</a>
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
					<?php } } else { ?>
						        <a>N/A</a>
					<?php } ?>
				</div>
				
				<hr>
			</div>
			
			<div class="row">
				<div class="columns small-12 medium-8 large-9">
					<p>Has Accident</p>
				</div>
				
				<div class="columns small-12 medium-4 large-3 text-right">
					<?= $car_condition->has_accident; ?>
				</div>
				
				<hr>
			</div>
			
			<div class="row">
				<div class="columns small-12 ">
					<p>Notes</p>
				</div>
				
				<div class="columns small-12">
					<?php if($car_condition->condition_details != NULL ) { ?>
						<p><?= $car_condition->condition_details; ?></p>
					<?php } else { ?>
						<p><a>N/A</a></p>
					<?php } ?>
				</div>
				
				<hr>
			</div>

		</div>
	</div>
</div>
<div class="reveal tiny info-window" id="modal_bid" data-reveal>
	<div class="row">
		<div class="columns small-12 text-center">
			<h4 id="response-bid-title"></h4>
			<hr>
			<p id="response-bid-text"></p>
			<div class="button-group">
				<a class="button" rel="button-modal-info" data-value="close">Close</a>
			</div>
		</div>
	</div>
</div>
<div class="reveal tiny info-window" id="modal_watchlist" data-reveal>
	<div class="row">
		<div class="columns small-12 text-center">
			<h4>Watchlist</h4>
			<hr>
			<p id="response-watchlist"></p>
			<div class="button-group">
				<a class="button" rel="button-modal-info" data-value="close">Close</a>
			</div>
		</div>
	</div>
</div>
<div class="reveal tiny" id="modal_contact_seller" data-reveal></div>
<script>
(function(){
  "use strict";

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
	  
	var end_auction_epoch = <?= strtotime($car_auction->endtime); ?>;
	if(end_auction_epoch > 0){
		var end_auction_time  = '<?= date('Y/m/d H:i:s', strtotime($car_auction->endtime . '+0 day'))?>';
	  	if ($('#countdown-clock-<?= $car_auction->auction_id; ?>').length > 0) {
			$('#countdown-clock-<?= $car_auction->auction_id; ?>').countdown(end_auction_time)
				.on('update.countdown', function(event) {
					var format = '%H:%M:%S';
					if(event.offset.totalDays > 0) {
				    	format = '%-d day%!d ' + format;
				  	}
				  	
				  	if(event.offset.weeks > 0) {
				    	format = '%-w week%!w ' + format;
				  	}
				  	
				  	$(this).html(event.strftime(format));
				});
		}
	}else{

	}

})();
</script>
<script type="text/javascript">
	$( document ).on('click', '.add-bid', function(e) {
		var auction_id = $(this).data('auction');
		var dealer_id  = $(this).data('dealer');
		var bid_value  = $(this).data('bid');
		var bidData    = {
	        'dealer_id'     : dealer_id,
	        'auction_id'    : auction_id,
	        'tradein_value' : bid_value
	    };
	    console.log(bidData); 
	    $.ajax({
	        type        : "POST", 
	        url         : "<?= $post_dealer_addbid ?>", 
	        data        : bidData,
	        dataType    : 'json',
	        encode      : true
	    }).done(function(resp) { }).fail(function(resp) { }).always(function(resp) {
	    	console.log(resp); 
		   if(resp.status=='success'){
		 		var response_bid; var highest_bid = resp.data.bid.car_tradein_value;
		   		if(resp.data.auction.won_dealer_id==bidData.dealer_id){
		   			response_bid = "Thanks for placing a bid. By adding $" + bid_value 
		   			             + ", You have bid the auction for $" + highest_bid + " in total.";
		   		}else{
		   			response_bid = "Thanks for placing a bid. Another dealer has bid the auction for $" + highest_bid + ".";
		   		}
		   		var auction_info = resp.data.bid.car_sold_year + " " + resp.data.bid.car_sold_maker;
		   		$('#response-bid-title').text(auction_info);
		   		$('#response-bid-text').text(response_bid);
				$('#modal_bid').foundation('open');
		   }
		});
	});

	$(document).on('click', '[rel="button-modal-info"]', function() {
		$('.info-window').foundation('close');
		 location.reload();
	});
</script>
<script>
	$(document).on('click', '#custom-bid-btn', function(e) {
		var bid_value 	= $('.custom-bid').val();
		var dealer_id 	= <?= $dealer_id; ?>;
		var auction_id 	= <?= $car_auction->auction_id; ?>;
		var bidData    	= {
	        'dealer_id'     : dealer_id,
	        'auction_id'    : auction_id,
	        'tradein_value' : bid_value
	    };
		console.log(bidData); 
	    $.ajax({
	        type        : "POST", 
	        url         : "<?= $post_dealer_addbid ?>", 
	        data        : bidData,
	        dataType    : 'json',
	        encode      : true
	    }).done(function(resp) { }).fail(function(resp) { }).always(function(resp) {
	    	console.log(resp); 
		   if(resp.status=='success'){
		 		var response_bid; var highest_bid = resp.data.bid.car_tradein_value;
		   		if(resp.data.auction.won_dealer_id==bidData.dealer_id){
		   			response_bid = "Thanks for placing a bid. By adding $" + bid_value 
		   			             + ", You have bid the auction for $" + highest_bid + " in total.";
		   		}else{
		   			response_bid = "Thanks for placing a bid. Another dealer has bid the auction for $" + highest_bid + ".";
		   		}
		   		var auction_info = resp.data.bid.car_sold_year + " " + resp.data.bid.car_sold_maker;
		   		$('#response-bid-title').text(auction_info);
		   		$('#response-bid-text').text(response_bid);
				$('#modal_bid').foundation('open');
		   }
		});
		e.preventDefault();
	});
	
	$(document).on('click', '[rel="button-modal-info"]', function() {
		$('.info-window').foundation('close');
		 location.reload();
	});
	
</script>
<script>
$( document ).on('click', '.add-remove-watchlist', function(e) {
		var auction_id = $(this).data('auction');
		var dealer_id  = $(this).data('dealer');
		var watchlist_status = $(this).data('watchlist');

		var watchlistData = {
	        'dealer_id'  : dealer_id,
	        'auction_id' : auction_id
	    };
	    console.log(watchlistData);
	    if(watchlist_status=='add'){
		    $.ajax({
		        type        : "POST", 
		        url         : "<?= $post_dealer_addwatchlist ?>", 
		        data        : watchlistData,
		        dataType    : 'json',
		        encode      : true
		    }).done(function(data) { }).fail(function(data) { }).always(function(data) {
		    	console.log(data); 
		    	if(data.status=='success'){
		    		$('#response-watchlist').text('Added to watchlist.');
					$('#modal_watchlist').foundation('open');
					$('#watchlist-'+auction_id).show();
		    	}
			});

			$(this).data('watchlist', 'remove');
			var remove_content = 'Remove&nbsp;&nbsp;&nbsp;<img src="<?php echo base_url(); ?>assets/img/icon-button-watchlist.png">';
			$(this).find('span').html(remove_content);
		}
		else{
			$.ajax({
		        type        : "POST", 
		        url         : "<?= $post_dealer_remwatchlist ?>", 
		        data        : watchlistData,
		        dataType    : 'json',
		        encode      : true
		    }).done(function(data) { }).fail(function(data) { }).always(function(data) {
		    	console.log(data); 
		    	if(data.status=='success'){
		    		$('#response-watchlist').text('Removed from watchlist.');
					$('#modal_watchlist').foundation('open');
					$('#watchlist-'+auction_id).hide();
		    	}
			});

			$(this).data('watchlist', 'add');
			var add_content = 'Add&nbsp;&nbsp;&nbsp;<img src="<?php echo base_url(); ?>assets/img/icon-button-watchlist.png">';
			$(this).find('span').html(add_content);
		}
	});

$(document).on('click', '[rel="button-modal-info"]', function() {
	$('.info-window').foundation('close');
});
</script>
<script>
	var live = "<?= $live; ?>";
	console.log(live);
	$( document ).on( "click", '.contact-seller', function( e ) {
		if(live){
			window.location.href = "<?= site_url('auction/notification/'.$car_auction->auction_id.'/dealer/');?>";
		}else{
			$('#modal_contact_seller').html(
			'<h4>Contact Seller</h4>' + '<p>Sorry you can contact seller only when live auction</p>' 
			+ '<a class="button" rel="button-modal-confirm-ok" data-value="ok">OK</a>')
			.foundation('open');
		}
	});

	$(document).on('click', '[rel="button-modal-confirm-ok"]', function() {
		$('#modal_contact_seller').foundation('close'); 
	});
	
</script>
