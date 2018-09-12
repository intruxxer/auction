
<div class="columns small-12">

<?php if(!$live) { ?>	
	<section>
		<div class="row is-hidden">
			<div class="columns small-12">
				<div id="next-auction">
					<p class="text-center">Next auction will start in:</p>
					<p class="countdown-clock" class="text-center">00:00:00</p>
				</div>
			</div>
		</div>
	</section>
<?php } ?>

	<section>
		<div class="row">
			<div class="columns small-12">
				
				<div class="tabs-content" data-tabs-content="example-tabs">
					<div class="tabs-panel is-active" id="panel1">
				    	<div class="cars-on-auction">
							<?php foreach($data as $a){ 
								$server_time = date('Y-m-d H:i:s', strtotime($a->server_time));
								$auction_end = date('Y-m-d H:i:s', strtotime($a->endtime)); ?>
								<?php if($a->status != "2") { ?>
									<div class="item">
										<div class="left">
											<img src="<?= $a->car_details->front34;?>">
										</div>
										
										<div class="right">
											<h3><?= $a->item_title ?></h3>
												
											<ul class="spec">												
												<li class="odometer">
													<?php if($a->car_details->mileage) { echo number_format($a->car_details->mileage). ' '
													      .ucwords($a->car_details->mileage_type); }
 														  else{ echo '0 Mi'; }
													?>
												</li>
											</ul>
											
											
											<div class="row">
												<?php if($a->status == "1.1"){ 
														if($a->start_time >= date('Y-m-d H:i:s')){ $cta = 'call-to-action-green unset-auction'; }
														else { $cta = 'call-to-action'; } 
												?>
												<div class="columns large-6 large-centered">
													<div class="row small-up-2 quick-bids">
														<div class="column column-block">
															<a class="call-to-action" 
															   href="<?= site_url('auction/'.$a->auction_id.'/edit/'.$a->car_details->car_sale_id) ?>">
															<span>Edit</span>
															</a>
														</div>
														<div class="column column-block">
															<a 	id="btn-auction-<?= $a->auction_id ?>" 
																class="<?= $cta ?>" data-auction="<?= $a->auction_id; ?>"
															   	href="<?= site_url('auction/'.$a->auction_id
															   	         .'/detail/seller/'.$a->car_details->car_sale_id) ?>">
															<span>Auction</span>
															</a>
														</div>
													</div>
												</div>
												<?php	} else { 
													if($server_time < $auction_end ) { ?>

														<div class="columns large-6 large-centered">
															<div class="row small-up-2 quick-bids">
																<div class="column column-block">
																	<a class="call-to-action-green" 
																	   href="<?= site_url('auction/history/'.$a->auction_id.'/seller') ?>">
																	<span>Live Auction</span>
																	</a>
																</div>
																<div class="column column-block">
																	<?php if($a->unread_messages > 0){ 
																		$unread_badge = '<span class="badge">'.$a->unread_messages.'</span>';
																	} ?>
																	<a class="call-to-action-green" 
																	   href="<?= site_url('auction/'.$a->auction_id.'/inbox/seller') ?>">
																	<span>Notification</span><?= $unread_badge ?>
																	</a>
																</div>
															</div>
														</div>
													<?php } else { ?>
														<div class="columns large-6 large-centered">
															<div class="row small-up-2 quick-bids">
																<div class="column column-block">
																	<a class="call-to-action" 
																	   href="<?= site_url('auction/'.$a->auction_id.'/edit/'.$a->car_details->car_sale_id) ?>">
																	<span>Edit</span>
																	</a>
																</div>
																<div class="column column-block">
																	<a 	id="btn-auction-<?= $a->auction_id ?>" 
																		class="<?= $cta ?>" data-auction="<?= $a->auction_id; ?>"
																	   	href="<?= site_url('auction/'.$a->auction_id
																	   	         .'/detail/seller/'.$a->car_details->car_sale_id) ?>">
																	<span>Auction</span>
																	</a>
																</div>
															</div>
														</div>
												<?php } } ?>
											</div>
											
											<?php if($live) { 
													if( $server_time < $auction_end ){ ?>
														<div class="footer">
															<div class="row small-up-2">
																<div class="column column-block text-center">
																	<p>
																		<i class="fa fa-clock-o"></i> 
																		<span id="countdown-clock-<?= $a->auction_id; ?>">
																			N/A
																		</span>
																	</p>
																</div>
																
																<div class="column column-block text-center">
																	<p><i class="fa fa-usd"></i> <?= number_format($a->highest_bid); ?></p>
																</div>
															</div>
														</div>
													
														<script>
															(function(){
																"use strict";
																var server_time   = moment("<?= $auction_time->server_time_auction ?>");
																var auction_end   = moment("<?= date('Y-m-d H:i:s', strtotime($a->endtime)) ?>");
																
																var auction_remain_time     = Math.abs(server_time.diff(auction_end, 'seconds'));
																var auction_local_end_time  = moment().add(auction_remain_time, 'seconds').format('YYYY/MM/DD HH:mm:ss');

																var end_auction_epoch = <?= strtotime($a->endtime); ?>;
																if(end_auction_epoch > 0){
																	//var end_auction_time  = '<?= date('Y/m/d H:i:s', strtotime($a->endtime . '+0 day'))?>';
																	var end_auction_time = auction_local_end_time;
																  	if ($('#countdown-clock-<?= $a->auction_id; ?>').length > 0) {
																		$('#countdown-clock-<?= $a->auction_id; ?>').countdown(end_auction_time)
																			.on('update.countdown', function(event) {
																				if(event.offset.totalSeconds < 2){
																					window.location.href = "<?= site_url('seller/index'); ?>";
																				}else{
																					var format = '%H:%M:%S';
																					if(event.offset.totalDays > 0) {
																				    	format = '%-d day%!d ' + format;
																				  	}
																				  	
																				  	if(event.offset.weeks > 0) {
																				    	format = '%-w week%!w ' + format;
																				  	}
																				  	
																				  	$(this).html(event.strftime(format));
																			  	}
																			});
																	}
																}else{ }

															})();
														</script>
											<?php } } ?>
										</div>
									</div>
									
								<?php } else { ?>
									<div class="item past-auction">
										<div class="row">
											<div class="columns small-12 medium-6">
												<h4><?= $a->item_title ?></h4>
											</div>	
											<div class="columns small-12 medium-6 text-right">
												<a class="button blue" 
												   href="<?= site_url('auction/'.$a->auction_id.'/winner/seller'); ?>">Details</a>
											</div>
										</div>
									</div>		
								<?php } ?>
							<?php } ?>
									<div class="row" id="past-auctions">
										<div class="columns small-12">
											<h3 class="text-center">Past Auctions</h3>
										</div>
									</div>
						</div>

				  	</div>
				</div>
			</div>
		</div>
	</section>
</div>
<div class="reveal tiny info-window" id="modal_unset_auction" data-reveal>
	<div class="row">
		<div class="columns small-12 text-center">
			<h4>Auction Removed</h4>
			<hr>
			<p id="response-unset-auction"></p>
			<div class="button-group">
				<a class="button green" rel="button-modal-info" data-value="close">Close</a>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">$( "#past-auctions" ).insertBefore( $( ".past-auction" ).first() );</script>


<script>
	$( document ).on('click', '.unset-auction', function(e) {
		var auction_id = $(this).data('auction');

		var auction_data = {
	        'auction_id' : auction_id
	    };
	    console.log(auction_data);
		$.ajax({
	        type        : "POST", 
	        url         : "<?= $post_unset_auction ?>", 
	        data        : auction_data,
	        dataType    : 'json',
	        encode      : true
	    }).done(function(data) { }).fail(function(data) { }).always(function(data) {
	    	console.log(data); 
	    	if(data.status=='success'){
	    		$('#response-unset-auction').text('Successfully removed from auction.');
				$('#modal_unset_auction').foundation('open');
				$('#btn-auction-'+auction_id).removeClass('call-to-action-green');
				$('#btn-auction-'+auction_id).addClass('call-to-action');
	    	}
		});
		
		e.preventDefault();
	});

	$(document).on('click', '[rel="button-modal-info"]', function() {
		$('#modal_unset_auction').foundation('close'); 
		window.location.href = "<?= site_url('seller');?>";
	});
</script>

<script type="text/javascript">
	var server_time   = moment("<?= $auction_time->server_time_auction ?>");
	var auction_start = moment("<?= date('Y-m-d H:i:s', strtotime($auction_time->start_live_auction . '+'.$auction_day.' day')) ?>");
	var auction_end   = moment("<?= date('Y-m-d H:i:s', strtotime($auction_time->end_live_auction . '+'.$auction_day.' day'))?>");
	
	var auction_remain_time = Math.abs(server_time.diff(auction_start, 'seconds'));
	var auction_local_time  = moment().add(auction_remain_time, 'seconds').format('YYYY/MM/DD HH:mm:ss');
  	if ($('.countdown-clock').length > 0) {
		$('.countdown-clock').countdown(auction_local_time)
			.on('update.countdown', function(event) {
				if(event.offset.totalSeconds < 2){
					window.location.reload(true);
				}
				else{
					var format = '%H:%M:%S';
					if(event.offset.totalDays > 0) {
				    	format = '%-d day%!d ' + format;
				  	}
				  	
				  	if(event.offset.weeks > 0) {
				    	format = '%-w week%!w ' + format;
				  	}
				  	
				  	$(this).html(event.strftime(format));
				  	$('.countdown-clock').html(event.strftime(format));
			  	}
			});
	}
</script>