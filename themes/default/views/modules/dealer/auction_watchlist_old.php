<div class="columns small-12">
	<section>
		<div class="row">
			<div class="columns small-12">
				<ul class="tabs" data-tabs id="example-tabs">
					<li class="tabs-title auction is-active">
						<a href="#panel1" aria-selected="true"><span>Auction</span></a>
					</li>
					<li class="tabs-title wishlist">
						<a href="#panel2"><span>Watchlist<span></a>
					</li>
				</ul>
				
				<div class="tabs-content" data-tabs-content="example-tabs">
					<div class="tabs-panel is-active" id="panel1">
						<h2 class="bar text-center" style="background: <?= $list_color; ?>"><?= $list_title; ?></h2>
				    	<div class="cars-on-auction">
				    	<?php foreach ($auctions as $key => $a) { ?>
				    		<?php if(true){ ?>
				    		<div class="item">
								<div class="left">
									<img src="<?= $a->car_details->front34 ?>">
								</div>
								
								<div class="right">
									<h3><?= $a->item_title ?></h3>
									<p><?php if($a->car_details->details) { echo 'Remarks: ' . $a->car_details->details; }
											 else{ echo 'Remarks: N/A'; } ?>
									</p>
									<ul class="spec">
										<li class="fuel">
											<?php if($a->car_details->fuel_type){ echo ucwords($a->car_details->fuel_type); }
												  else{ echo 'N/A'; } ?>
										</li>
										<li class="odometer">
											<?php if($a->car_details->mileage) { echo number_format($a->car_details->mileage). ' '
													      .ucwords($a->car_details->mileage_type); }
												  else{ echo '0 Mi'; }
											?>
										</li>
										<li class="transmission"><?= ucwords(strtolower($a->car_details->transmission)); ?></li>
										<li class="capacity"><?php echo '0 Person';  ?></li>
									</ul>
									
								<?php if($live) { ?>
									<div class="row small-up-3 quick-bids">
										<div class="column column-block">
											<a class="button green add-bid" 
											   data-bid="<?= $a->trade_options[0]; ?>"
											   data-auction="<?= $a->auction_id; ?>" 
											   data-dealer="<?= $dealer_id; ?>">
												$<?= $a->trade_options[0]; ?>
											</a>
										</div>
										
										<div class="column column-block">
											<a class="button green add-bid" 
											   data-bid="<?= $a->trade_options[1]; ?>"
											   data-auction="<?= $a->auction_id; ?>" 
											   data-dealer="<?= $dealer_id; ?>">
												$<?= $a->trade_options[1]; ?>
											</a>
										</div>
										
										<div class="column column-block">
											<a class="button green add-bid" 
											   data-bid="<?= $a->trade_options[2]; ?>"
											   data-auction="<?= $a->auction_id; ?>" 
											   data-dealer="<?= $dealer_id; ?>">
												$<?= $a->trade_options[2]; ?>
											</a>
										</div>
									</div>
								<?php } ?>	
									<div class="row small-up-2">
										<div class="column column-block">
											<a class="call-to-action" 
											   href="<?= site_url('auction/'.$a->auction_id.'/detail/dealer/'.$a->car_details->car_sale_id) ?>">
											   <span>Details</span></a>
										</div>
										
										<div class="column column-block">
											<?php if(!$a->on_watchlist){ $add_remove = 'add'; }else{ $add_remove = 'remove'; }?>
											<a id="btn-watchlist-<?= $a->auction_id ?>" class="call-to-action add-remove-watchlist" 
											   data-auction="<?= $a->auction_id; ?>" 
											   data-dealer="<?= $dealer_id; ?>" 
											   data-watchlist="<?= $add_remove ?>">
												<span>
													<?= ucwords($add_remove); ?>&nbsp;&nbsp;&nbsp;
													<img src="<?php echo base_url(); ?>assets/img/icon-button-watchlist.png">
												</span>
											</a>
										</div>
									</div>
									
									<div class="footer">
										<div class="row small-up-2">
											<div class="column column-block text-center">
												<p><i class="fa fa-clock-o"></i> 
												<?php if($live) { ?>
													<span id="countdown-clock-<?= $a->auction_id; ?>">00:00:00</span>
												<?php } else { ?>
													<span>-</span>
												<?php } ?>
												</p>
											</div>
											
											<div class="column column-block text-center">
												<?php if($live) { ?>
													<p><i class="fa fa-usd"></i> <?= number_format($a->highest_bid); ?></p>
												<?php } else { ?>
													<p><i class="fa fa-usd"></i> - </p>
												<?php } ?>
											</div>
										</div>
									</div>
									<script>
										(function(){
											"use strict";
											var end_auction_epoch = <?= strtotime($a->endtime); ?>;
											if(end_auction_epoch > 0){
												var end_auction_time  = '<?= date('Y/m/d H:i:s', strtotime($a->endtime . '+0 day'))?>';
											  	if ($('#countdown-clock-<?= $a->auction_id; ?>').length > 0) {
													$('#countdown-clock-<?= $a->auction_id; ?>').countdown(end_auction_time)
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
								</div>
							</div>
							<?php } ?>
				    	<?php } ?>
						</div>
				  	</div>
				  	
				  	<div class="tabs-panel" id="panel2">
						<h2 class="bar text-center" style="background: <?= $list_color; ?>">Watchlist</h2>
				    	<div class="cars-on-auction">
				    	<?php foreach ($auctions as $key => $a) { ?>
				    		<?php if(true){ ?>
							<div id="watchlist-<?= $a->auction_id ?>" class="item"
							<?php if(!$a->on_watchlist){ echo 'style=display:none;'; }else{} ?> >
								<div class="left">
									<img src="<?= $a->car_details->front34 ?>">
								</div>
								
								<div class="right">
									<h3><?= $a->item_title ?></h3>
									<p><?php if($a->car_details->details) { echo 'Remarks: ' . $a->car_details->details; }
											 else{ echo 'Remarks: N/A'; } ?>
									</p>
									<ul class="spec">
										<li class="fuel">
											<?php if($a->car_details->fuel_type){ echo ucwords($a->car_details->fuel_type); }
												  else{ echo 'N/A'; } ?>
										</li>
										<li class="odometer">
											<?php if($a->car_details->mileage) { echo number_format($a->car_details->mileage). ' '
													      .ucwords($a->car_details->mileage_type); }
												  else{ echo '0 Mi'; }
											?>
										</li>
										<li class="transmission"><?= ucwords(strtolower($a->car_details->transmission)); ?></li>
										<li class="capacity"><?php echo '0 Person';  ?></li>
									</ul>
									
									<?php if($live) { ?>
									<div class="row small-up-3 quick-bids">
										<div class="column column-block">
											<a class="button green add-bid" 
											   data-bid="<?= $a->trade_options[0]; ?>"
											   data-auction="<?= $a->auction_id; ?>" 
											   data-dealer="<?= $dealer_id; ?>">
												$<?= $a->trade_options[0]; ?>
											</a>
										</div>
										
										<div class="column column-block">
											<a class="button green add-bid" 
											   data-bid="<?= $a->trade_options[1]; ?>"
											   data-auction="<?= $a->auction_id; ?>" 
											   data-dealer="<?= $dealer_id; ?>">
												$<?= $a->trade_options[1]; ?>
											</a>
										</div>
										
										<div class="column column-block">
											<a class="button green add-bid" 
											   data-bid="<?= $a->trade_options[2]; ?>"
											   data-auction="<?= $a->auction_id; ?>" 
											   data-dealer="<?= $dealer_id; ?>">
												$<?= $a->trade_options[2]; ?>
											</a>
										</div>
									</div>
									<?php } ?>
									<div class="row small-up-2">
										<div class="column column-block" >
											<a class="call-to-action"
											   href="<?= site_url('auction/detail/'.$a->auction_id.'/dealer') ?>"><span>Details</span></a>
										</div>
										
										<div class="column column-block">
											<a class="call-to-action remove-watchlist" 
											   data-auction="<?= $a->auction_id; ?>" data-dealer="<?= $dealer_id; ?>">
												<span>
													Remove&nbsp;&nbsp;&nbsp;
													<img src="<?php echo base_url(); ?>assets/img/icon-button-watchlist.png">
												</span>
											</a>
										</div>
									</div>
									
									<div class="footer">
										<div class="row small-up-2">
											<div class="column column-block text-center">
												<p><i class="fa fa-clock-o"></i> 
												<?php if($live) { ?>
													<span id="countdown-clock-w-<?= $a->auction_id; ?>">00:00:00</span>
												<?php } else { ?> 
													<span>-</span>
												<?php } ?>
												</p>
											</div>
											
											<div class="column column-block text-center">
												<?php if($live) { ?>
													<p><i class="fa fa-usd"></i> <?= number_format($a->highest_bid); ?></p>
												<?php } else { ?>
													<p><i class="fa fa-usd"></i> -</p>
												<?php } ?>
											</div>
										</div>
									</div>
									<script>
										(function(){
											"use strict";
											var end_auction_epoch = <?= strtotime($a->endtime); ?>;
											if(end_auction_epoch > 0){
												var end_auction_time  = '<?= date('Y/m/d H:i:s', strtotime($a->endtime . '+0 day'))?>';
											  	if ($('#countdown-clock-w-<?= $a->auction_id; ?>').length > 0) {
													$('#countdown-clock-w-<?= $a->auction_id; ?>').countdown(end_auction_time)
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
								</div>
							</div>
							<?php } ?>
						<?php } ?>
						</div>
				  	</div>
				</div>
			</div>
		</div>
	</section>
</div>
<div class="reveal tiny info-window" id="modal_watchlist" data-reveal>
	<div class="row">
		<div class="columns small-12 text-center">
			<h4>Watchlist</h4>
			<hr>
			<p id="response-watchlist"></p>
			<div class="button-group">
				<a class="button green" rel="button-modal-info" data-value="close">Close</a>
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
				<a class="button green" rel="button-modal-info" data-value="close">Close</a>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
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

	$( document ).on('click', '.remove-watchlist', function(e) {
		var auction_id = $(this).data('auction');
		var dealer_id  = $(this).data('dealer');
		var watchlistData = {
	        'dealer_id'  : dealer_id,
	        'auction_id' : auction_id
	    };
	    console.log(watchlistData);
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
				$('#btn-watchlist-'+auction_id).data('watchlist', 'add');
				var add_content = 'Add&nbsp;&nbsp;&nbsp;<img src="<?php echo base_url(); ?>assets/img/icon-button-watchlist.png">';
				$('#btn-watchlist-'+auction_id).find('span').html(add_content);
	    	}
		});
	});

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
	});
</script>