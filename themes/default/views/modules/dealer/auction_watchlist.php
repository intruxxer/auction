<div class="columns small-12">

<!-- <?php if(!$live || ($live && $empty_auction)) { ?>	
	<section>
		<div class="row">
			<div class="columns small-12">
				<div id="next-auction">
					<?php if($live && $empty_auction) { ?>
						<p class="text-center">Auction will end in:</p>
					<?php } else { ?>
						<p class="text-center">Next auction will start in:</p>
					<?php } ?>
					<p class="countdown-clock" class="text-center">00:00:00</p>
				</div>
			</div>
		</div>
	</section>
<?php } ?> -->

	<section>
		<div class="row">
			<div class="columns small-12">
				<!-- TABS -->
				<ul class="tabs" data-tabs id="example-tabs">
					<li class="tabs-title auction is-active">
						<a id="auction-header" href="#auctionpanel" aria-selected="true"></a>
					</li>
					<li class="tabs-title wishlist">
						<a id="watchlist-header" href="#watchlistpanel"></a>
					</li>
					<li class="tabs-title wishlist">
						<a id="won-header" href="#wonauctionpanel"></a>
					</li>
				</ul>

				<!-- FILTERS -->
				<p style="color:#81b723"><a style="color:#81b723" href="<?= site_url('dealer/preference'); ?>"><u>Filters</u></a> : 
					<?php if($body_styles != array() || $brands != array()) { ?>
						<?php foreach ($body_styles as $a) { ?>
							<a class="button green selected-preference btn-style" data-style="<?= $a ?>"><?= $a; ?></a>
						<?php } ?>
						<?php foreach ($brands as $b) { ?>
							<a class="button green selected-preference btn-brand" data-brand="<?= $b ?>"><?= $b; ?></a>
						<?php } ?>
					<?php } else { ?>
						Shows All
					<?php } ?>
				</p>

				<!-- TABS CONTENT -->
				<div class="tabs-content" data-tabs-content="example-tabs">
					<!-- AUCTION -->
					<div class="tabs-panel is-active" id="auctionpanel">
				    	<div class="cars-on-auction">
				    	<?php foreach ($auctions as $key => $a) { ?>
				    		<div class="item">
								<div class="left">
									<a href="<?= site_url('auction/detail/'.$a->auction_id.'/dealer') ?>"> <img src="<?= $a->car_details->front34 ?>" ></a>
								</div>
								<div class="right">
									<a href="<?= site_url('auction/detail/'.$a->auction_id.'/dealer') ?>"><h3><?= $a->item_title ?></h3></a>
									<ul class="spec">
										<li><?= $a->car_details->trim ?></li>
										<li class="odometer">
											<?php if($a->car_details->mileage) { echo number_format($a->car_details->mileage).' '.ucwords($a->car_details->mileage_type); }
												  else{ echo '0 Mil'; }
											?>
										</li>
										
											<?php 
											if($live) { $proxy_info = $a->proxy_status && $a->proxy_value > 0; }
											else { $proxy_info = $a->proxy_status || $a->proxy_value > 0; }
											if( $proxy_info ) 
												  { $proxy_color = 'green'; $proxy_word = 'Remove Proxy'; $proxy_class="has-proxy"; ?>
											<li id="proxy-bid-txt-<?= $a->auction_id ?>" class="proxy">By Proxy: $<?= number_format($a->proxy_value) ?></li>
											<?php }else 
												  { $proxy_color = 'gray'; $proxy_word = 'Use Proxy Bid'; $proxy_class="no-proxy";  ?>
											<li id="proxy-bid-txt-<?= $a->auction_id ?>" class="proxy" style="display: none;"></li>
											<?php } ?>

									</ul>

									<?php if ($live) { ?>
									<div class="row quick-bids">

										<div class="column large-4">
											<?php if(!$a->on_watchlist){ $add_remove = 'add'; $is_active = ''; }
												  else{ $add_remove = 'remove'; $is_active = 'is-active'; }?>
											<a id="btn-watchlist-<?= $a->auction_id ?>" 
											   class="button watchlist add-remove-watchlist <?= $is_active ?>" 
											   data-auction="<?= $a->auction_id; ?>" 
											   data-dealer="<?= $dealer_id; ?>" 
											   data-watchlist="<?= $add_remove ?>">
												<span>Watch</span>
											</a>
										</div>

										<div class="column large-4">
											<a class="button green" rel="bid" id="place-bid-<?= $a->auction_id ?>">Place Bid</a>
										</div>
										
										<div class="column large-8">
											<div class="is-hidden bid-container">
												<div class="proxy-bid-container">
													<div class="input-group">
														<input type="text" class="input-group-field bid-val-<?= $a->auction_id; ?>" placeholder="Place Bid" name="bid_val">
														
														<div class="input-group-button">
															<button class="button blue add-bid" data-auction="<?= $a->auction_id ?>" data-dealer="<?= $dealer_id; ?>" >Submit</button>
														</div>
													</div>
												</div>
												
												<div class="proxy-bid-container" id="proxy-bid-container-<?= $a->auction_id ?>">
													<?php if($a->proxy_status && $a->proxy_value > 0) { 
																$checked   = 'checked="checked"';
																$is_hidden = ""; 
																$proxy_val = $a->proxy_value; 
														} else { 
														  		$checked   = "";
														  		$is_hidden = "is-hidden";
														  		$proxy_val = "";  }
													?>

													<div class="faux">
														<input type="checkbox" <?= $checked; ?> id="proxy-bid-<?= $a->auction_id ?>" role="proxy-bid-use" data-auction="<?= $a->auction_id ?>" data-dealer="<?= $dealer_id; ?>" data-proxy=<?= $proxy_val; ?> >
														<label for="proxy-bid-<?= $a->auction_id ?>">Use Proxy Bid</label>
													</div>

													<div class="<?= $is_hidden; ?> input-group proxy_value_container">
														<input type="text" class="input-group-field proxy_value" 
													   name="proxy_value" id="proxy-value-<?= $a->auction_id ?>" placeholder="Proxy Bid" value="<?= $proxy_val; ?>" >
														

														<div class="input-group-button">
															<button class="button blue add-proxy-bid" 
															    data-auction="<?= $a->auction_id ?>" 
															    data-dealer="<?= $dealer_id ?>" >
																Submit
															</button>
														</div>
													</div>
												</div>

											</div>
										</div>
									</div>
									<div class="footer">
										<div class="row small-up-2">
											<div class="column column-block text-center">
												<p><i class="fa fa-clock-o"></i> 
													<span id="countdown-clock-<?= $a->auction_id; ?>" data-endtime="<?= $a->endtime; ?>">00:00:00</span>
												</p>
											</div>
											<div class="column column-block text-center">
												<p id="highest-value-<?= $a->auction_id ?>">
													<i class="fa fa-usd"></i> <?= number_format($a->highest_bid); ?>
												</p>
											</div>
										</div>
									</div>
									<?php } ?>

									<?php if(!$live){ ?>
									<div class="row small-up-3 quick-bids">
										<div class="column column-block">
										
											<?php if(!$a->on_watchlist){ $add_remove = 'add'; $is_active = ''; }
												  else{ $add_remove = 'remove'; $is_active = 'is-active'; }?>
											<a id="btn-watchlist-<?= $a->auction_id ?>" 
											   class="button watchlist add-remove-watchlist <?= $is_active ?>" 
											   data-auction="<?= $a->auction_id; ?>" 
											   data-dealer="<?= $dealer_id; ?>" 
											   data-watchlist="<?= $add_remove ?>">
												<span>Watch</span>
											</a>
										
										</div>
										<div class="column column-block">
											<a id="proxy-bid-btn-<?= $a->auction_id ?>" class="button <?= $proxy_color.' '.$proxy_class ?>"  
											   rel="proxy-bid" data-auction="<?= $a->auction_id ?>" data-dealer="<?= $dealer_id; ?>" >
												<?= $proxy_word ?>
											</a>
										</div>
										<div class="column column-block">
											<a class="button blue" 
											   href="<?= site_url('auction/'.$a->auction_id.'/detail/dealer/'.$a->car_details->car_sale_id) ?>">
											   Details</a>
										</div>
									</div>

									<div class="row is-hidden" id="proxy-bid-container-<?= $a->auction_id ?>">
										<div class="columns large-6 large-centered">
											<div class="input-group proxy_value_container">
												
												<?php if($a->proxy_status && $a->proxy_value > 0) { $proxy_val = $a->proxy_value; }
												else { $proxy_val = ""; }?>

												<input type="text" class="input-group-field proxy_value" 
													   name="proxy_value" placeholder="Proxy Bid" value="<?= $proxy_val; ?>" >

												<div class="input-group-button">
													<button class="button blue add-proxy-bid" 
													        data-auction="<?= $a->auction_id ?>" 
													        data-dealer="<?= $dealer_id ?>" >
													Submit
													</button>
												</div>
											</div>
										</div>
									</div>

									<?php } ?>
									<script>
										(function(){
											"use strict";
											var endtime       = $('#countdown-clock-<?= $a->auction_id; ?>').data("endtime");

											var server_time   = moment("<?= $auction_time->server_time_auction ?>");
											// var auction_end   = moment("<?= date('Y-m-d H:i:s', strtotime($a->endtime)) ?>");
											var auction_end   = moment(endtime);
											console.log(auction_end);

											var auction_remain_time     = Math.abs(server_time.diff(auction_end, 'seconds'));
											var auction_local_end_time  = moment().add(auction_remain_time, 'seconds').format('YYYY/MM/DD HH:mm:ss');
											var end_auction_epoch = <?= strtotime($a->endtime); ?>;
											if(end_auction_epoch > 0){
												var end_auction_time = auction_local_end_time;
											  	if ($('#countdown-clock-<?= $a->auction_id; ?>').length > 0) {
													$('#countdown-clock-<?= $a->auction_id; ?>').countdown(end_auction_time)
														.on('update.countdown', function(event) {
															if(event.offset.totalSeconds < 2){
																// window.location.reload(true);
																window.location.href = "<?= site_url('dealer/auction'); ?>";
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
								</div>
							</div>
				    	<?php } ?>
						</div>

						<?php if ($num_auction > 0) { ?>
						<div class="row">
							<div class="columns small-12 text-center">
								<ul class="pagination" role="navigation" aria-label="Pagination">
									<?php $prev_page = (int) $cur_page - 1; $first_page = 1; 
										if( $prev_page < $first_page) { $disabled = 'disabled'; $prev_page = $first_page; } else { $disabled = ''; }?>
									<li class="pagination-previous <?= $disabled ?>"><a href="<?= site_url('dealer/auction/'.$first_page);?>"><i class="fa fa-angle-double-left"></i></a></li>
									<li class="<?= $disabled ?>"><a href="<?= site_url('dealer/auction/'.$prev_page);?>"><i class="fa fa-angle-left"></i></a></li>
									
									<?php for ($i=1; $i<=$num_pages ; $i++) { 
											if($cur_page == $i) { $current = 'current'; } else { $current = ''; } ?>
										<li class="<?= $current ?>"><a href="<?= site_url('dealer/auction/'.$i);?>"><?= $i ?></a></li>
									<?php } ?>
									
									<?php $next_page = (int) $cur_page + 1; $last_page = (int) $i - 1; 
										if( $next_page > $last_page) { $disabled = 'disabled'; $next_page = $last_page; } else { $disabled = ''; }?>
									<li class="pagination-next <?= $disabled ?>"><a href="<?= site_url('dealer/auction/'.$next_page);?>"><i class="fa fa-angle-right"></i></a></a></li>
									<li class="pagination-next <?= $disabled ?>"><a href="<?= site_url('dealer/auction/'.$last_page);?>"><i class="fa fa-angle-double-right"></i></a></a></li>
								</ul>
							</div>
						</div>
						<?php } ?>
				  	</div> 
				  	<script type="text/javascript">
				  		var num_auction = "(<?= $num_auction ?>)";
				  		$("#auction-header").text("Auction " + num_auction);
				  	</script>
				  	<!-- END AUCTION -->
				  	
				  	<!-- WATCH -->
				  	<div class="tabs-panel" id="watchlistpanel">
				    	<div class="cars-on-auction">
				    	<?php $num_watchlist = 0; foreach ($watchlist as $key => $a) { ?>
							<div id="watchlist-<?= $a->auction_id ?>" class="item" 
								<?php if(!$a->on_watchlist){ echo 'style=display:none;'; }else{ $num_watchlist++; } ?> >
								<div class="left">
									<a href="<?= site_url('auction/detail/'.$a->auction_id.'/dealer') ?>"><img src="<?= $a->car_details->front34 ?>"></a>
								</div>
								
								<div class="right">
									<a href="<?= site_url('auction/detail/'.$a->auction_id.'/dealer') ?>" ><h3><?= $a->item_title ?></h3></a>
									<ul class="spec">
										<li><?= $a->car_details->trim ?></li>
										<li class="odometer">
											<?php if($a->car_details->mileage) { echo number_format($a->car_details->mileage). ' '.ucwords($a->car_details->mileage_type); }
												  else{ echo '0 Mil'; }
											?>
										</li>
										<?php if($live) { $proxy_info = $a->proxy_status && $a->proxy_value > 0; }
											else { $proxy_info = $a->proxy_status || $a->proxy_value > 0; }
											if( $proxy_info )
											 	{ $proxy_color = 'green'; $proxy_word = 'Remove Proxy'; $proxy_class="has-proxy"; ?>
										<li id="proxy-bid-w-txt-<?= $a->auction_id ?>" class="proxy">By Proxy: $<?= number_format($a->proxy_value) ?></li>
										<?php }else 
											  { $proxy_color = 'gray'; $proxy_word = 'Use Proxy Bid'; $proxy_class="no-proxy";  ?>
										<li id="proxy-bid-w-txt-<?= $a->auction_id ?>" class="proxy" style="display: none;"></li>
										<?php } ?>
									</ul>
									<?php if($live) { ?>
									<div class="row quick-bids">

										<div class="column large-4">
											<a class="button watchlist remove-watchlist is-active" 
											   data-auction="<?= $a->auction_id; ?>" data-dealer="<?= $dealer_id; ?>">
												<span>
													Clear
												</span>
											</a>
										</div>

										<div class="column large-4">
											<a class="button green" rel="bid" id="place-bid-w-<?= $a->auction_id ?>">Place Bid</a>
										</div>
										
										<div class="column large-8">
											<div class="is-hidden bid-container">
												<div class="proxy-bid-container">
													<div class="input-group">
														<input type="text" class="input-group-field bid-val-w-<?= $a->auction_id; ?>" placeholder="Place Bid" name="bid_val" >
														
														<div class="input-group-button">
															<button class="button blue add-bid-w" 
															data-auction="<?= $a->auction_id ?>" 
															data-dealer="<?= $dealer_id; ?>" >Submit
															</button>
														</div>
													</div>
												</div>
												
												<div class="proxy-bid-container" id="proxy-bid-container-<?= $a->auction_id ?>">
													<?php if($a->proxy_status && $a->proxy_value > 0) { 
																$checked   = 'checked="checked"';
																$is_hidden = ""; 
																$proxy_val = $a->proxy_value; 
														} else { 
														  		$checked   = "";
														  		$is_hidden = "is-hidden";
														  		$proxy_val = "";  }
													?>

													<div class="faux">
														<input type="checkbox" <?= $checked; ?> id="proxy-bid-w-<?= $a->auction_id ?>" role="proxy-bid-use" data-auction="<?= $a->auction_id ?>" data-dealer="<?= $dealer_id; ?>" data-proxy="<?= $proxy_val; ?>" >
														<label for="proxy-bid-w-<?= $a->auction_id ?>">Use Proxy Bid</label>
													</div>

													<div class="<?= $is_hidden; ?> input-group proxy_value_container">
														<input type="text" class="input-group-field proxy_value" 
													   name="proxy_value" id="proxy-value-<?= $a->auction_id ?>" placeholder="Proxy Bid" value="<?= $proxy_val; ?>" >
														

														<div class="input-group-button">
															<button class="button blue add-proxy-bid" 
															    data-auction="<?= $a->auction_id ?>" 
															    data-dealer="<?= $dealer_id ?>" >
																Submit
															</button>
														</div>
													</div>
												</div>

											</div>
										</div>
									</div>
									<div class="footer">
										<div class="row small-up-2">
											<div class="column column-block text-center">
												<p><i class="fa fa-clock-o"></i> 
													<span id="countdown-clock-w-<?= $a->auction_id; ?>" data-endtime="<?= $a->endtime; ?>">00:00:00</span>
												</p>
											</div>
											<div class="column column-block text-center">
												<p id="highest-value-w-<?= $a->auction_id ?>">
													<i class="fa fa-usd"></i><?= number_format($a->highest_bid); ?>
												</p>
											</div>
										</div>
									</div>
									<?php } ?>

									<?php if(!$live) { ?>
									<div class="row small-up-3 quick-bids">
										<div class="column column-block">
											<a class="button watchlist remove-watchlist is-active" 
											   data-auction="<?= $a->auction_id; ?>" data-dealer="<?= $dealer_id; ?>">
												<span>
													Clear
												</span>
											</a>
										</div>
										<div class="column column-block">
											<a id="proxy-bid-w-btn-<?= $a->auction_id ?>" class="button <?= $proxy_color.' '.$proxy_class ?>"  
											   rel="proxy-w-bid" data-auction="<?= $a->auction_id ?>" data-dealer="<?= $dealer_id; ?>">
												<?= $proxy_word ?>
											</a>
										</div>
										<div class="column column-block" >
											<a class="button blue"
											   href="<?= site_url('auction/detail/'.$a->auction_id.'/dealer') ?>">Details</a>
										</div>
									</div>
									<div class="row is-hidden" id="proxy-bid-w-container-<?= $a->auction_id ?>">
										<div class="columns large-6 large-centered">
											<div class="input-group proxy_value_container">

											   <?php if($a->proxy_status && $a->proxy_value > 0) { 
															$proxy_val = $a->proxy_value; } else { $proxy_val = "";  }?>
														
												<input type="text" class="input-group-field proxy_value" 
													   name="proxy_value" placeholder="Proxy Bid" value="<?= $proxy_val; ?>" >

												<div class="input-group-button">
													<button class="button blue add-proxy-bid" 
													        data-auction="<?= $a->auction_id ?>" 
													        data-dealer="<?= $dealer_id ?>" >
													Submit
													</button>
												</div>
											</div>
										</div>
									</div>
									<?php } ?>
									<script>
										(function(){
											"use strict";
											var server_time   = moment("<?= $auction_time->server_time_auction ?>");
											var auction_end   = moment("<?= date('Y-m-d H:i:s', strtotime($a->endtime)) ?>");
											
											var auction_remain_time     = Math.abs(server_time.diff(auction_end, 'seconds'));
											var auction_local_end_time  = moment().add(auction_remain_time, 'seconds').format('YYYY/MM/DD HH:mm:ss');

											var end_auction_epoch = <?= strtotime($a->endtime); ?>;
											if(end_auction_epoch > 0){
												var end_auction_time = auction_local_end_time;
											  	if ($('#countdown-clock-w-<?= $a->auction_id; ?>').length > 0) {
													$('#countdown-clock-w-<?= $a->auction_id; ?>').countdown(end_auction_time)
														.on('update.countdown', function(event) {
															if(event.offset.totalSeconds < 2){
																// window.location.reload(true);
																window.location.href = "<?= site_url('dealer/auction'); ?>";
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
														  	}
														});
												}
											}else{ }

										})();
									</script>
								</div>
							</div>
						<?php }?>
						</div>
				  	</div><!-- END WATCHLIST -->

				  	<!-- WON -->
				  	<div class="tabs-panel" id="wonauctionpanel">
				    	<div class="cars-on-auction">
				    	<?php foreach ($won_auctions as $key => $a) { ?>
				    		<div class="item">
								<div class="left">
									<img src="<?= $a->front34 ?>">
								</div>
								<div class="right">
									<h3><?= $a->year." ".$a->make." ".$a->model ?></h3>
									<ul class="spec">
										<li><?= $a->trim ?></li>
									</ul>
									<p class="won-calendar">
										<i class="fa fa-calendar"></i> <?= date('j F Y', strtotime($a->auction_time)) ?></p>
									<div class="row small-up-3 quick-bids">
										<div class="column column-block">
											<a class="button blue" 
											   href="<?= site_url('auction/'.$a->auction_id.'/winner/dealer/') ?>">
											   Details</a>
										</div>
									</div>
								</div>
							</div>
				    	<?php } ?>
						</div>
				  	</div>
				  	<script type="text/javascript">
				  		var num_auction_won = "(<?= $num_auction_won ?>)";
				  		$("#won-header").text("Won " + num_auction_won);
				  	</script>
				  	<!-- END WON -->

				</div><!-- END TABS CONTENT -->
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
				<a class="button green" rel="button-modal-info-watchlist" data-value="close">Close</a>
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
<div class="reveal tiny" id="modal_outbid" data-reveal>
	<div class="row">
		<div class="columns small-12 text-center">
			<h4 id="outbid-info-title"></h4>
			<hr>
			<p id="outbid-info-text"></p>
			<div class="button-group">
				<a class="button green" rel="button-outbid-info" data-value="close">Close</a>
			</div>
		</div>
	</div>
</div>
<div class="reveal tiny info-window" id="modal_confirm_bid" data-reveal>
	<div class="row">
		<div class="columns small-12 text-center">
			<h4 id="response-confirm-title"></h4>
			<hr>
			<p id="response-confirm-text"></p>
			<div class="button-group">
				<a class="button green" rel="button-confirm-no" data-value="close">Cancel</a>
				<a class="button green" rel="button-confirm-bid" data-value="yes">Confirm</a>
			</div>
		</div>
	</div>
</div>

<!--  REMOVE PROXY USING UNCHECKLIST PROXY BID -->
<script>
	var origtext;
	var origclass;
	$('[rel="bid"]').on('click', function() {
			var item = $(this).closest('.item');
			
			if ($(this).hasClass('is-active')) {
				$(this).text(origtext);
				$(this).attr('class', origclass);
			} else {
				origtext = $(this).text();
				$(this).text('Cancel');
				if ($(this).hasClass('gray') || $(this).hasClass('green')) {
					origclass = $(this).attr('class');
					$(this).attr('class', "button orange is-active");
				}
			}
			
			if (item.hasClass('is-active')) {
				item.removeClass('is-active');
				item.find('.bid-container').addClass('is-hidden');
			} else {
				item.addClass('is-active');
				item.find('.bid-container').removeClass('is-hidden');
			}
		});
		
	$('[role="proxy-bid-use"]').on('change', function(){
		if($(this)[0]['checked']) {
			$(this).closest('.faux').next().removeClass('is-hidden');
			$(this).removeClass('uncheck');
			$(this).addClass('check');
			
		} else {
			console.log('Call API to remove proxy');
			var auction_id = $(this).data('auction');
			var dealer_id  = $(this).data('dealer');
			var proxy_data = $(this).data('proxy');
			console.log(proxy_data);
			if( proxy_data != "" ){
				remove_proxy(auction_id,dealer_id);
			}
			$(this).removeClass('check');
			$(this).addClass('uncheck');
			$(this).closest('.faux').next().addClass('is-hidden');
		}
	});

	function remove_proxy(auction_id,dealer_id){
		console.log('auction_id : '+auction_id);
		console.log('dealer_id : '+dealer_id);

		var proxyBidData = {
        'dealer_id'     : dealer_id,
        'auction_id'    : auction_id
	    };
	    console.log(proxyBidData); 
	    $.ajax({
	        type        : "POST", 
	        url         : "<?= $post_dealer_removeproxybid ?>", 
	        data        : proxyBidData,
	        dataType    : 'json',
	        encode      : true
	    }).done(function(resp) { }).fail(function(resp) { }).always(function(resp) {
	    	console.log(resp); 
		   if(resp.status=='success'){
		   		var auction_info = "Proxy Bid Removed";
		   		var response_bid = "Proxy Bid is Succefully Removed.";
		   		$('#response-bid-title').text(auction_info);
		   		$('#response-bid-text').text(response_bid);
				$('#modal_bid').foundation('open');
				$('#place-bid-'+auction_id).removeClass('green');
				$('#place-bid-'+auction_id).addClass('gray');
				$('#place-bid-w-'+auction_id).removeClass('gray');
				$('#place-bid-w-'+auction_id).addClass('green');
				// $('#proxy-bid-container-'+auction_id).addClass('is-hidden');
				$('#proxy-bid-btn-'+auction_id).addClass('gray no-proxy');
				$('#proxy-bid-btn-'+auction_id).removeClass('green orange has-proxy');
				$('#proxy-bid-btn-'+auction_id).text('Use Proxy Bid');
				$('#proxy-bid-txt-'+auction_id).text('');
				$('#proxy-bid-txt-'+auction_id).hide();
				// $('#proxy-bid-w-container-'+auction_id).addClass('is-hidden');
				$('#proxy-bid-w-btn-'+auction_id).addClass('gray no-proxy');
				$('#proxy-bid-w-btn-'+auction_id).removeClass('green orange has-proxy');
				$('#proxy-bid-w-btn-'+auction_id).text('Use Proxy Bid');
				$('#proxy-bid-w-txt-'+auction_id).text('');
				$('#proxy-bid-w-txt-'+auction_id).hide();
				$('.bid-container').addClass('is-hidden');
				$('#place-bid-'+auction_id).removeClass('orange');
				$('#place-bid-'+auction_id).text('Place Bid');
				
				window.location.href = "<?= site_url('dealer/auction'); ?>";
		   }else{
		   		var auction_info = "Proxy Bid Not Removed";
		   		var response_bid = "Proxy Bid is failed to remove.";
		   		$('#response-bid-title').text(auction_info);
		   		$('#response-bid-text').text(response_bid);
				$('#modal_bid').foundation('open');
				window.location.href = "<?= site_url('dealer/auction'); ?>";
		   }
		});
	}
</script>

<!-- EVENT LISTENER & OUTBID NOTIFICATION -->
<script type="text/javascript">
	var live       = <?= $live; ?>;
	if(localStorage.getItem(0) === null){
		var object = { 'summarized': 1, 'notif': 1, 'bid': 0, 'name': 'auction name' }
		localStorage.setItem(0, JSON.stringify(object));
	}

	var streamURL  = "<?= $get_dealer_auction_stream; ?>";
	if (!!window.EventSource) {
	  var evtSource  = new EventSource(streamURL); //, {withCredentials : true}
	} // Else, Result to xhr polling 
	
	var auction_names = "";
	evtSource.onmessage = function(e) {
		var watchlist = JSON.parse(e.data); console.log(watchlist);

		if(watchlist.won_proxy == '1'){
			if(live){

				$('#proxy-bid-'+watchlist.auction_id).attr( 'checked', true );
				$('#proxy-bid-'+watchlist.auction_id).closest('.faux').next().removeClass('is-hidden');
				$('#proxy-value-'+watchlist.auction_id).val(watchlist.proxy_val);
				$('#proxy-bid-'+watchlist.auction_id).attr( 'data-proxy', watchlist.proxy_val );

			}else{
	 			$('#proxy-bid-container-'+watchlist.auction_id).addClass('is-hidden');
	 			$('#proxy-bid-w-container-'+watchlist.auction_id).addClass('is-hidden');
	 			$('#proxy-bid-btn-'+watchlist.auction_id).removeClass('orange');
	 			$('#proxy-bid-w-btn-'+watchlist.auction_id).removeClass('orange');
			}

			$('#proxy-bid-btn-'+watchlist.auction_id).removeClass('gray no-proxy');
			$('#proxy-bid-btn-'+watchlist.auction_id).addClass('green has-proxy');
			$('#proxy-bid-btn-'+watchlist.auction_id).text('Remove Proxy');
			$('#proxy-bid-txt-'+watchlist.auction_id).text('By Proxy: $' + watchlist.proxy_val);
			$('#proxy-bid-txt-'+watchlist.auction_id).show();
			$('#proxy-bid-w-btn-'+watchlist.auction_id).removeClass('gray no-proxy');
			$('#proxy-bid-w-btn-'+watchlist.auction_id).addClass('green has-proxy');
			$('#proxy-bid-w-btn-'+watchlist.auction_id).text('Remove Proxy');
			$('#proxy-bid-w-txt-'+watchlist.auction_id).text('By Proxy: $' + watchlist.proxy_val);
			$('#proxy-bid-w-txt-'+watchlist.auction_id).show();

		}else{
			
			if(live){
				$('#proxy-bid-'+watchlist.auction_id).attr( 'data-proxy', '' );
				
				if($('#place-bid-'+watchlist.auction_id).hasClass('orange') ){
					if($('#proxy-bid-'+watchlist.auction_id).hasClass('check')){

						$('#proxy-bid-'+watchlist.auction_id).attr( 'checked', true );
						$('#proxy-bid-'+watchlist.auction_id).closest('.faux').next().removeClass('is-hidden');

					}else{
						$('#proxy-bid-'+watchlist.auction_id).closest('.faux').next().addClass('is-hidden');

						$('#proxy-bid-'+watchlist.auction_id).attr( 'checked', false );
					}

				}else{
					$('#proxy-bid-'+watchlist.auction_id).removeClass('check');
					$('#proxy-bid-'+watchlist.auction_id).removeClass('uncheck');
				}

				$('#proxy-bid-btn-'+watchlist.auction_id).addClass('gray no-proxy');
				$('#proxy-bid-btn-'+watchlist.auction_id).removeClass('green has-proxy');
				$('#proxy-bid-txt-'+watchlist.auction_id).text('');
				$('#proxy-bid-txt-'+watchlist.auction_id).hide();
				$('#proxy-bid-w-btn-'+watchlist.auction_id).addClass('gray no-proxy');
				$('#proxy-bid-w-btn-'+watchlist.auction_id).removeClass('green has-proxy');
				$('#proxy-bid-w-txt-'+watchlist.auction_id).text('');
				$('#proxy-bid-w-txt-'+watchlist.auction_id).hide();

			}else{
				if($('#proxy-bid-btn-'+watchlist.auction_id).hasClass('orange') ){
					$('#proxy-bid-btn-'+watchlist.auction_id).text('Cancel');
				}else{
					$('#proxy-bid-btn-'+watchlist.auction_id).text('Use Proxy Bid');
				}

				if($('#proxy-bid-w-btn-'+watchlist.auction_id).hasClass('orange') ){
					$('#proxy-bid-w-btn-'+watchlist.auction_id).text('Cancel');
				}else{
					$('#proxy-bid-w-btn-'+watchlist.auction_id).text('Use Proxy Bid');
				}

				// SHOW PROXY TEXT BEFORE LIVE IF DEALER HAS PROXY
				if(watchlist.dealer_prox != "" && $('#proxy-bid-btn-'+watchlist.auction_id).hasClass('has-proxy') ){
					$('#proxy-bid-btn-'+watchlist.auction_id).removeClass('gray no-proxy');
					$('#proxy-bid-btn-'+watchlist.auction_id).addClass('green has-proxy');
					$('#proxy-bid-txt-'+watchlist.auction_id).text('By Proxy: $' + watchlist.dealer_prox);
					$('#proxy-bid-txt-'+watchlist.auction_id).show();
					$('#proxy-bid-w-btn-'+watchlist.auction_id).removeClass('gray no-proxy');
					$('#proxy-bid-w-btn-'+watchlist.auction_id).addClass('green has-proxy');
					$('#proxy-bid-w-txt-'+watchlist.auction_id).text('By Proxy: $' + watchlist.dealer_prox);
					$('#proxy-bid-w-txt-'+watchlist.auction_id).show();

					$('#proxy-bid-btn-'+watchlist.auction_id).text('Remove Proxy');
				}else{
					$('#proxy-bid-btn-'+watchlist.auction_id).addClass('gray no-proxy');
					$('#proxy-bid-btn-'+watchlist.auction_id).removeClass('green has-proxy');
					$('#proxy-bid-txt-'+watchlist.auction_id).text('');
					$('#proxy-bid-txt-'+watchlist.auction_id).hide();
					$('#proxy-bid-w-btn-'+watchlist.auction_id).addClass('gray no-proxy');
					$('#proxy-bid-w-btn-'+watchlist.auction_id).removeClass('green has-proxy');
					$('#proxy-bid-w-txt-'+watchlist.auction_id).text('');
					$('#proxy-bid-w-txt-'+watchlist.auction_id).hide();
				}
			}
				
			
		}

		if(watchlist.dealer_win == '1'){
			$('#place-bid-'+watchlist.auction_id).removeClass('gray');
			$('#place-bid-'+watchlist.auction_id).addClass('green');
			$('#place-bid-w-'+watchlist.auction_id).removeClass('gray');
			$('#place-bid-w-'+watchlist.auction_id).addClass('green');
		}else{
			$('#place-bid-'+watchlist.auction_id).removeClass('green');
			$('#place-bid-'+watchlist.auction_id).addClass('gray');
			$('#place-bid-w-'+watchlist.auction_id).removeClass('green');
			$('#place-bid-w-'+watchlist.auction_id).addClass('gray');

			var data   = localStorage.getItem(watchlist.auction_id);
			data       = JSON.parse(data);

			if (localStorage.getItem(watchlist.auction_id) === null) {
				var object = { 'summarized': 0, 'notif': 0, 'bid': 0, 'name': watchlist.auction_name }
			  	localStorage.setItem(watchlist.auction_id, JSON.stringify(object));
			}else{
				if(live){
					if(data['summarized'] == 0 && data['bid'] == 1){
						auction_names = auction_names + "\n" + data['name'];
						// console.log(auction_names);
						data['summarized'] = 1;
						localStorage.setItem(watchlist.auction_id, JSON.stringify(data));

						$('#outbid-info-title').text("You've Been Outbid");
			   			$('#outbid-info-text').text(auction_names + " \n You have been outbid by another dealer. Current bid $"+commaSeparateNumber(watchlist.bid_value));

			   			if(auction_names != ""){
							$('#modal_outbid').foundation('open');
							$(document).on('click', '[rel="button-outbid-info"]', function() {
								data['notif'] = 1;
								localStorage.setItem(watchlist.auction_id, JSON.stringify(data));
								auction_names = "";
								$('#modal_outbid').foundation('close');
								$('#proxy-bid-txt-'+watchlist.auction_id).text('');
								$('#proxy-bid-txt-'+watchlist.auction_id).hide();
								$('#proxy-bid-w-txt-'+watchlist.auction_id).text('');
								$('#proxy-bid-w-txt-'+watchlist.auction_id).hide();
							});	
						}
					}
				}
			}
		}

		$('#highest-value-'+watchlist.auction_id).html('<i class="fa fa-usd"></i>'+commaSeparateNumber(watchlist.bid_value));
		$('#highest-value-w-'+watchlist.auction_id).html('<i class="fa fa-usd"></i>'+commaSeparateNumber(watchlist.bid_value));
	}
	
	evtSource.onerror = function(e) {
	  $('.add-bid').addClass('gray');
	};

	function commaSeparateNumber(val){
	    while (/(\d+)(\d{3})/.test(val.toString())){
	      val = val.toString().replace(/(\d+)(\d{3})/, '$1'+','+'$2');
	    }
	    return val;
	}

</script>

<!-- ADD & REMOVE PROXY BID -->
<script type="text/javascript">
	
	$('[rel="proxy-bid"]').on('click', function() {
		var auction_id  = $(this).data('auction');
		if ($(this).hasClass('no-proxy')) {
			if (!$(this).hasClass('is-active')) {
				if (!$('#proxy-bid-container-'+auction_id).hasClass('is-hidden')) {
					$('#proxy-bid-container-'+auction_id).addClass('is-hidden');
					$(this).removeClass('orange');
					$(this).addClass('gray');
					$(this).text('Use Proxy Bid');

				} else {
					$('#proxy-bid-container-'+auction_id).removeClass('is-hidden');
					$(this).removeClass('gray');
					$(this).addClass('orange');
					$(this).text('Cancel');
				}
			}
		}
	});

	$('[rel="proxy-w-bid"]').on('click', function() {
		var auction_id  = $(this).data('auction');
		if ($(this).hasClass('no-proxy')) {
			if (!$(this).hasClass('is-active')) {
				if (!$('#proxy-bid-w-container-'+auction_id).hasClass('is-hidden')) {
					$('#proxy-bid-w-container-'+auction_id).addClass('is-hidden');
					$(this).removeClass('orange');
					$(this).addClass('gray');
					$(this).text('Use Proxy Bid');
					
				} else {
					$('#proxy-bid-w-container-'+auction_id).removeClass('is-hidden');
					$(this).removeClass('gray');
					$(this).addClass('orange');
					$(this).text('Cancel');
				}
			}
		}
	});

	$('.add-proxy-bid').on('click', function(){
		var auction_id  = $(this).data('auction');
		var dealer_id   = $(this).data('dealer');
		var proxy_value = $(this).closest('.proxy_value_container').find('.proxy_value').val();
		console.log(proxy_value);
		var live        = <?= $live; ?>;

		if(proxy_value=="0" || proxy_value=="" || parseInt(proxy_value) < 100 || parseInt(proxy_value) > 999000){
			$('#response-bid-title').text("Proxy Bid Limit Exceeded");
	   		$('#response-bid-text').text("Please enter a proxy bid between value $100-999,000.");
			$('#modal_bid').foundation('open');

			// IF HAS PROXY AND THE INPUT VALUE IS EMPTY DO : 
			// remove_proxy(auction_id,dealer_id);
		} else {
			//SHOW CONFIRMATION MODAL
			$('#response-confirm-title').text('Proxy Bid');
			$('#response-confirm-text').text('Are you sure you want to place a proxy bid of $'+proxy_value+' ?');
			$('#modal_confirm_bid').foundation('open');

			$(document).on('click', '[rel="button-confirm-bid"]', function() {
				$('#modal_confirm_bid').foundation('close');

				var proxyBidData = {
		        	'dealer_id'     : dealer_id,
		        	'auction_id'    : auction_id,
		        	'proxy_value'   : proxy_value
			    };
			    console.log(proxyBidData); 
			    $.ajax({
			        type        : "POST", 
			        url         : "<?= $post_dealer_addproxybid ?>", 
			        data        : proxyBidData,
			        dataType    : 'json',
			        encode      : true
			    }).done(function(resp) { }).fail(function(resp) { }).always(function(resp) {
			    	console.log(resp); 
				   if(resp.status=='success'){
				   		var auction_info = "Proxy Bid Succefully Placed";
				   		var response_bid = "Thank you for your proxy bid. By submitting a proxy bid of $" + proxy_value 
				   			         + " you have authorized automatic bidding in $100 increments up to a maximum of $" + proxy_value + ".";
				   		$('#response-bid-title').text(auction_info);
				   		$('#response-bid-text').text(response_bid);
						$('#modal_bid').foundation('open');
						$('#place-bid-'+auction_id).removeClass('gray');
						$('#place-bid-'+auction_id).addClass('green');
						$('#place-bid-w-'+auction_id).removeClass('gray');
						$('#place-bid-w-'+auction_id).addClass('green');
						if(live){
							$('.bid-container').addClass('is-hidden');
				 			$('#place-bid-'+auction_id).removeClass('orange');
				 			$('#place-bid-'+auction_id).text('Place Bid');
						}else{
				 			$('#proxy-bid-container-'+auction_id).addClass('is-hidden');
						}
						$('#proxy-bid-btn-'+auction_id).removeClass('gray orange');
						$('#proxy-bid-btn-'+auction_id).addClass('green');
						$('#proxy-bid-w-btn-'+auction_id).addClass('green');
						
						//update localStorage
						var data   = localStorage.getItem(auction_id);
						data       = JSON.parse(data);
						console.log(data);
						if (localStorage.getItem(auction_id) !== null) {
							data['summarized'] 	= 0;
							data['notif']  		= 0;
							data['bid']			= 1;
						  	localStorage.setItem(auction_id, JSON.stringify(data));
						}else{
							var object = { 'summarized': 0, 'notif': 0, 'bid': 1, 'name': watchlist.auction_name }
							localStorage.setItem(auction_id, JSON.stringify(object));
						}

						window.location.href = "<?= site_url('dealer/auction'); ?>";

				   }
				   else if(resp.status=='error'){
				   		var pattern = /proxy bid is lower/i;
		  				var found   = resp.error_message.match( pattern );
		  				if(!found){
		  					$('#response-bid-title').text("Proxy Bid Error");
		  					window.location.href = "<?= site_url('dealer/auction'); ?>";
		  				} else {
		  					$('#response-bid-title').text("You've Been Outbid by Proxy");
		  				}
				   		$('#response-bid-text').text(resp.error_message);
						$('#modal_bid').foundation('open');
				   }
				});
			});
		}
	});

	$(document).on('click', '.has-proxy', function(e){
		var auction_id  = $(this).data('auction');
		var dealer_id   = $(this).data('dealer');
		var proxyBidData = {
        'dealer_id'     : dealer_id,
        'auction_id'    : auction_id
	    };
	    console.log(proxyBidData); 
	    $.ajax({
	        type        : "POST", 
	        url         : "<?= $post_dealer_removeproxybid ?>", 
	        data        : proxyBidData,
	        dataType    : 'json',
	        encode      : true
	    }).done(function(resp) { }).fail(function(resp) { }).always(function(resp) {
	    	console.log(resp); 
		   if(resp.status=='success'){
		   		var auction_info = "Proxy Bid Removed";
		   		var response_bid = "Proxy Bid is Succefully Removed.";
		   		$('#response-bid-title').text(auction_info);
		   		$('#response-bid-text').text(response_bid);
				$('#modal_bid').foundation('open');
				$('#place-bid-'+auction_id).removeClass('green');
				$('#place-bid-'+auction_id).addClass('gray');
				$('#place-bid-w-'+auction_id).removeClass('gray');
				$('#place-bid-w-'+auction_id).addClass('green');
				$('#proxy-bid-btn-'+auction_id).text('Use Proxy Bid');
				$('#proxy-bid-w-btn-'+auction_id).addClass('gray');
				$('#proxy-bid-w-btn-'+auction_id).removeClass('green orange');
				
				window.location.href = "<?= site_url('dealer/auction'); ?>";
		   }else{
		   		var auction_info = "Proxy Bid Not Removed";
		   		var response_bid = "Proxy bid is failed to remove.";
		   		$('#response-bid-title').text(auction_info);
		   		$('#response-bid-text').text(response_bid);
				$('#modal_bid').foundation('open');
		   }
		});
	});
</script>

<!-- ADD/REMOVE WATCHLIST -->
<script type="text/javascript">
	var server_time   = moment("<?= $auction_time->server_time_auction ?>");
	var auction_start = moment("<?= date('Y-m-d H:i:s', strtotime($auction_time->start_live_auction . '+'.$auction_day.' day')) ?>");
	var auction_end   = moment("<?= date('Y-m-d H:i:s', strtotime($auction_time->end_live_auction . '+'.$auction_day.' day'))?>");

	var empty_auction = <?= $empty_auction; ?>;
	var live 		  = <?= $live; ?>;

	if(empty_auction && live){
		var auction_remain_time = Math.abs(server_time.diff(auction_end, 'seconds'));
	} else {
		var auction_remain_time = Math.abs(server_time.diff(auction_start, 'seconds'));
	}

	var auction_local_time  = moment().add(auction_remain_time, 'seconds').format('YYYY/MM/DD HH:mm:ss');
  	if ($('.countdown-clock').length > 0) {
		$('.countdown-clock').countdown(auction_local_time)
			.on('update.countdown', function(event) {
				if(event.offset.totalSeconds < 2){
					// window.location.reload(true);
					window.location.href = "<?= site_url('dealer/auction'); ?>";
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

	var num_watchlist = "<?= $num_watchlist ?>";
	$("#watchlist-header").text("Watchlist (" + num_watchlist + ")");

	$( document ).on('click', '.add-remove-watchlist', function(e) {
		var auction_id = $(this).data('auction');
		var dealer_id  = $(this).data('dealer');
		var watchlist_status = $(this).data('watchlist');
		var watchlistData = {
	        'dealer_id'  : dealer_id,
	        'auction_id' : auction_id
	    };
	    //console.log(watchlistData);
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
			$(this).addClass('is-active');
			num_watchlist = parseInt(num_watchlist) + 1; console.log(num_watchlist);
			$("#watchlist-header").text("Watchlist (" + num_watchlist + ")");

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
			$(this).removeClass('is-active');
			num_watchlist = parseInt(num_watchlist) - 1; //console.log(num_watchlist);
			$("#watchlist-header").text("Watchlist (" + num_watchlist + ")");
		}
	});

	$( document ).on('click', '.remove-watchlist', function(e) {
		var auction_id = $(this).data('auction');
		var dealer_id  = $(this).data('dealer');
		var watchlistData = {
	        'dealer_id'  : dealer_id,
	        'auction_id' : auction_id
	    };
	    //console.log(watchlistData);
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
				$('#btn-watchlist-'+auction_id).removeClass('is-active');
				num_watchlist = parseInt(num_watchlist) - 1; console.log(num_watchlist);
				$("#watchlist-header").text("Watchlist (" + num_watchlist + ")");
	    	}
		});
	});

	$(document).on('click', '[rel="button-modal-info-watchlist"]', function() {
		$('.info-window').foundation('close');
		location.reload();
	});

	$( document ).on('click', '.add-bid', function(e) {
		var auction_id = $(this).data('auction');
		var dealer_id  = $(this).data('dealer');
		var bid_value  = $('.bid-val-'+auction_id).val();
		var bidData    = {
	        'dealer_id'     : dealer_id,
	        'auction_id'    : auction_id,
	        'tradein_value' : bid_value
	    };
	    console.log(bidData); 

	    if(bid_value=="0" || bid_value=="" || parseInt(bid_value) < 100 || parseInt(bid_value) > 999000){
			$('#response-bid-title').text("Proxy Bid Limit Exceeded");
	   		$('#response-bid-text').text("Please enter a proxy bid between value $100-999,000.");
			$('#modal_bid').foundation('open');
		} else {
			//SHOW CONFIRMATION MODAL
			$('#response-confirm-title').text('Confirm Bid');
			$('#response-confirm-text').text('Are you sure you want to place a bid of $'+bid_value+' ?');
			$('#modal_confirm_bid').foundation('open');

			$(document).on('click', '[rel="button-confirm-bid"]', function() {
				$('#modal_confirm_bid').foundation('close');
				$.ajax({
			        type        : "POST", 
			        url         : "<?= $post_dealer_addbid ?>", 
			        data        : bidData,
			        dataType    : 'json',
			        encode      : true
			    }).done(function(resp) { }).fail(function(resp) { }).always(function(resp) {
			    	console.log(resp); 
				   if(resp.status=='success'){
				 		var response_bid; 
				 		var highest_bid = resp.data.bid.car_tradein_value;
				 		var endtime 	= resp.data.auction.endtime;

				 		$('#highest-value-'+auction_id).html('<i class="fa fa-usd"></i>'+highest_bid.toLocaleString());
				 		$('#highest-value-w-'+auction_id).html('<i class="fa fa-usd"></i>'+highest_bid.toLocaleString());

				 		window.location.href = "<?= site_url('dealer/auction'); ?>";
				 	// 	$('#countdown-clock-'+auction_id).countdown(endtime)
						// .on('update.countdown', function(event) {
						// 	if(event.offset.totalSeconds < 2){
						// 		window.location.reload(true);
						// 	}else{
						// 		var format = '%H:%M:%S';
						// 		if(event.offset.totalDays > 0) {
						// 	    	format = '%-d day%!d ' + format;
						// 	  	}
							  	
						// 	  	if(event.offset.weeks > 0) {
						// 	    	format = '%-w week%!w ' + format;
						// 	  	}
							  	
						// 	  	$(this).html(event.strftime(format));
						//   	}
						// });

						// $('#countdown-clock-w-'+auction_id).countdown(endtime)
						// .on('update.countdown', function(event) {
						// 	if(event.offset.totalSeconds < 2){
						// 		window.location.reload(true);
						// 	}else{
						// 		var format = '%H:%M:%S';
						// 		if(event.offset.totalDays > 0) {
						// 	    	format = '%-d day%!d ' + format;
						// 	  	}
							  	
						// 	  	if(event.offset.weeks > 0) {
						// 	    	format = '%-w week%!w ' + format;
						// 	  	}
							  	
						// 	  	$(this).html(event.strftime(format));
						//   	}
						// });

				 		$('.bid-container').addClass('is-hidden');
				 		$('#place-bid-'+auction_id).removeClass('orange');
				 		$('#place-bid-'+auction_id).text('Place Bid');

				   		if(resp.data.auction.won_dealer_id==bidData.dealer_id){
				   			response_bid = "Thank you for placing your bid. By bidding $" + bid_value 
				   			             + ", you are now the highest bidder";
				   		}else{
				   			response_bid = "Thank you for placing your bid. Unfortunately, another dealer has outbid. Current bid is $" + highest_bid + ".";
				   		}
				   		var auction_info = "Highest Bid \r" + resp.data.bid.car_sold_year + " " + resp.data.bid.car_sold_maker + " " + resp.data.bid.car_sold_model;
				   		$('#response-bid-title').text(auction_info);
				   		$('#response-bid-text').text(response_bid);
						$('#modal_bid').foundation('open');

						//update localStorage
						var data   = localStorage.getItem(auction_id);
						data       = JSON.parse(data);
						console.log(data);
						if (localStorage.getItem(auction_id) !== null) {
							data['summarized'] 	= 0;
							data['notif']  		= 0;
							data['bid']    		= 1;
						  	localStorage.setItem(auction_id, JSON.stringify(data));
						}else{
							var object = { 'summarized': 0, 'notif': 0, 'bid': 1, 'name': watchlist.auction_name }
							localStorage.setItem(auction_id, JSON.stringify(object));
						}

				   }else{
				   		if(resp.status=='error'){
				   			$('#response-bid-title').text('Bid Error');
					   		$('#response-bid-text').text(resp.error_message);
							$('#modal_bid').foundation('open');
				   		}
				   }
				});
			});

			$(document).on('click', '[rel="button-confirm-no"]', function() {
				$('#modal_confirm_bid').foundation('close');
			});
		}
	    
	});

	$( document ).on('click', '.add-bid-w', function(e) {
		var auction_id = $(this).data('auction');
		var dealer_id  = $(this).data('dealer');
		var bid_value  = $('.bid-val-w-'+auction_id).val();
		var bidData    = {
	        'dealer_id'     : dealer_id,
	        'auction_id'    : auction_id,
	        'tradein_value' : bid_value
	    };
	    console.log(bidData); 

	    if(bid_value=="0" || bid_value=="" || parseInt(bid_value) < 100 || parseInt(bid_value) > 999000){
			$('#response-bid-title').text("Proxy Bid Limit Exceeded");
	   		$('#response-bid-text').text("Please enter a proxy bid between value $100-999,000.");
			$('#modal_bid').foundation('open');
		} else {
			//SHOW CONFIRMATION MODAL
			$('#response-confirm-title').text('Confirm Bid');
			$('#response-confirm-text').text('Are you sure you want to place a bid of $'+bid_value+' ?');
			$('#modal_confirm_bid').foundation('open');

			$(document).on('click', '[rel="button-confirm-bid"]', function() {
				$('#modal_confirm_bid').foundation('close');
				$.ajax({
			        type        : "POST", 
			        url         : "<?= $post_dealer_addbid ?>", 
			        data        : bidData,
			        dataType    : 'json',
			        encode      : true
			    }).done(function(resp) { }).fail(function(resp) { }).always(function(resp) {
			    	console.log(resp); 
				   if(resp.status=='success'){
				 		var response_bid; 
				 		var highest_bid = resp.data.bid.car_tradein_value;
				 		var endtime 	= resp.data.auction.endtime;
				 		
				 		$('#highest-value-'+auction_id).html('<i class="fa fa-usd"></i>'+highest_bid.toLocaleString());
				 		$('#highest-value-w-'+auction_id).html('<i class="fa fa-usd"></i>'+highest_bid.toLocaleString());

				 		window.location.href = "<?= site_url('dealer/auction'); ?>";
				 	// 	$('#countdown-clock-'+auction_id).countdown(endtime)
						// .on('update.countdown', function(event) {
						// 	if(event.offset.totalSeconds < 2){
						// 		window.location.reload(true);
						// 	}else{
						// 		var format = '%H:%M:%S';
						// 		if(event.offset.totalDays > 0) {
						// 	    	format = '%-d day%!d ' + format;
						// 	  	}
							  	
						// 	  	if(event.offset.weeks > 0) {
						// 	    	format = '%-w week%!w ' + format;
						// 	  	}
							  	
						// 	  	$(this).html(event.strftime(format));
						//   	}
						// });

						// $('#countdown-clock-w-'+auction_id).countdown(endtime)
						// .on('update.countdown', function(event) {
						// 	if(event.offset.totalSeconds < 2){
						// 		window.location.reload(true);
						// 	}else{
						// 		var format = '%H:%M:%S';
						// 		if(event.offset.totalDays > 0) {
						// 	    	format = '%-d day%!d ' + format;
						// 	  	}
							  	
						// 	  	if(event.offset.weeks > 0) {
						// 	    	format = '%-w week%!w ' + format;
						// 	  	}
							  	
						// 	  	$(this).html(event.strftime(format));
						//   	}
						// });

				 		$('.bid-container').addClass('is-hidden');
				 		$('#place-bid-w-'+auction_id).removeClass('orange');
				 		$('#place-bid-w-'+auction_id).text('Place Bid');
				 		
				   		if(resp.data.auction.won_dealer_id==bidData.dealer_id){
				   			response_bid = "Thank you for placing your bid. By bidding $" + bid_value 
				   			             + ", you are now the highest bidder";
				   		}else{
				   			response_bid = "Thank you for placing your bid. Unfortunately, another dealer has outbid. Current bid is $" + highest_bid + ".";
				   		}
				   		var auction_info = "Highest Bid \r" + resp.data.bid.car_sold_year + " " + resp.data.bid.car_sold_maker + " " + resp.data.bid.car_sold_model;
				   		
				   		$('#response-bid-title').text(auction_info);
				   		$('#response-bid-text').text(response_bid);
						$('#modal_bid').foundation('open');

						//update localStorage
						var data   = localStorage.getItem(auction_id);
						data       = JSON.parse(data);
						console.log(data);
						if (localStorage.getItem(auction_id) !== null) {
							data['summarized'] 	= 0;
							data['notif']  		= 0;
							data['bid']    		= 1;
						  	localStorage.setItem(auction_id, JSON.stringify(data));
						}else{
							var object = { 'summarized': 0, 'notif': 0, 'bid': 1, 'name': watchlist.auction_name }
							localStorage.setItem(auction_id, JSON.stringify(object));
						}

				   }else{
				   		if(resp.status=='error'){
				   			$('#response-bid-title').text('Bid Error');
					   		$('#response-bid-text').text(resp.error_message);
							$('#modal_bid').foundation('open');
				   		}
				   }
				});
			});

			$(document).on('click', '[rel="button-confirm-no"]', function() {
				$('#modal_confirm_bid').foundation('close');
			});
		}
	    
	});

	$(document).on('click', '[rel="button-modal-info"]', function() {
		$('.info-window').foundation('close');
	});
	
</script>

<!-- PREFERENCE -->
<script>
	var updated = false;
	$( document ).on('click', '.selected-preference', function(e) {
		$(this).remove();
		var body_styles = $(".btn-style").map(function() {
		    style = $(this).data("style");
		    return [style];
		}).get();
		var brands = $(".btn-brand").map(function() {
		    brands = $(this).data("brand");
		    return [brands];
		}).get();
		console.log("brands : " + brands);

		var preferenceData = {
		        'dealer_id'       : <?= $dealer_id ?>,
		        'body_styles'     : body_styles,
		        'brands'          : brands
		    };
		    console.log(preferenceData);

		$.ajax({
		        type        : "POST", 
		        url         : "<?= $post_dealer_preference ?>", 
		        data        : preferenceData,
		        dataType    : 'json',
		        encode      : true
		    }).done(function(data) { 
		    	$('#edit-info-title').html("Purchase Preferences");
				$('#edit-info-text').html("Your Car's Preferences have been updated.");
			    $('#modal_edit_info').foundation('open');
			    updated = true;
		    }).fail(function(data) {
			    $('#edit-info-title').html("Purchase Preferences");
				$('#edit-info-text').html("Error on updating your car's preferences.");
			    $('#modal_edit_info').foundation('open');
			}).always(function(data) {
		    	console.log(data); 
			});
		e.preventDefault();
	});

	$(document).on('click', '[rel="button-modal-info"]', function() {
		$('#modal_edit_info').foundation('close');
		if(updated==true){ window.location = "<?= site_url('dealer'); ?>"; }
	});
</script>