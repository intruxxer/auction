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
			
			<h2 class="text-center"><?= $car_auction->item_title; ?></h2>
			
			<?php if ($live) { ?> 
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
						<p id="highest-value" class="text-right"><?= '$ '.number_format($car_auction->current_bid); ?></p>
					</div>
					
					<hr>
				</div>
			
				<div class="row bids">
					<div class="columns small-12 medium-6">
						<p>My Last Bid</p>
					</div>
					
					<div class="columns small-12 medium-6">
						<p id="my-value" class="text-right"><?= '$ '.number_format($car_auction->my_last_bid); ?></p>
					</div>
					
					<hr>
				</div>
				
				<div class="row bids">
					<div class="columns small-12 medium-6">
						<p>By Proxy</p>
					</div>
					
					<div class="columns small-12 medium-6">
					<?php if($car_auction->my_proxy_value > 0) { ?>
						<p id="my_proxy_value" class="text-right"><?= '$ '.number_format($car_auction->my_proxy_value); ?></p>
					<?php }else{ ?>
						<p id="my_proxy_value" class="text-right"><?= 'N/A'; ?></p>
					<?php } ?>
					</div>
					
					<hr>
				</div>
			
			<?php } ?>

			<?php if(!$won) { ?>
				<div class="row">
					<div class="columns large-6 large-centered">
						<div class="row small-up-3 quick-bids">
							<div class="column column-block">
								<?php if(!$car_auction->on_watchlist){ $add_remove = 'watch'; $is_active = ''; }
								      else{ $add_remove = 'remove'; $is_active = 'is-active'; }  ?>
								<a id="btn-watchlist" 
								   class="button watchlist add-remove-watchlist <?= $is_active ?>" 
								   data-auction="<?= $car_auction->auction_id; ?>" 
								   data-dealer="<?= $dealer_id; ?>" 
								   data-watchlist="<?= $add_remove ?>">
									<span>Watch</span>
								</a>
							</div>
							<?php if(!$live) { ?>
								<?php if($car_auction->my_proxy_value > 0)
								  { $proxy_color = 'green'; $proxy_word = 'Remove Proxy'; $proxy_class="has-proxy"; } 
								  else 
								  { $proxy_color = 'gray'; $proxy_word = 'Use Proxy Bid'; $proxy_class="no-proxy"; }
								?>
								<div class="column column-block">
									<a id="proxy-bid-btn" class="button <?= $proxy_color.' '.$proxy_class ?>"  
									   rel="proxy-bid" data-auction="<?= $car_auction->auction_id ?>" data-dealer="<?= $dealer_id; ?>" data-proxy="<?= $car_auction->my_proxy_value; ?>" >
										<?= $proxy_word ?>
									</a>
								</div>
							<?php } else {  ?>
								<div class="column column-block">
									<a class="button green" rel="bid">Place Bid</a>
								</div>
								
								<div class="row">
									<div class="large-12">
										<div class="is-hidden bid-container">
											<div class="proxy-bid-container">
												<div class="input-group">
													<input type="text" class="input-group-field bid-val-<?= $car_auction->auction_id; ?>" placeholder="Place Bid" name="bid_val" >
													
													<div class="input-group-button">
														<button class="button blue add-bid" 
														data-auction="<?= $car_auction->auction_id ?>" 
														data-dealer="<?= $dealer_id; ?>" >Submit
														</button>
													</div>
												</div>
											</div>
											
											<div class="proxy-bid-container" id="proxy-bid-container-<?= $car_auction->auction_id ?>">
												<?php if($car_auction->my_proxy_value > 0) { 
															$checked   = 'checked="checked"';
															$is_hidden = ""; 
															$proxy_val = $car_auction->my_proxy_value; 
													} else { 
													  		$checked   = "";
													  		$is_hidden = "is-hidden";
													  		$proxy_val = "";  }
												?>

												<div class="faux">
													<input type="checkbox" <?= $checked; ?> id="proxy-bid-2-<?= $car_auction->auction_id ?>" role="proxy-bid-use" data-auction="<?= $car_auction->auction_id ?>" data-dealer="<?= $dealer_id; ?>" data-proxy="<?= $proxy_val; ?>" >
													<label for="proxy-bid-2-<?= $car_auction->auction_id ?>">Use Proxy Bid</label>
												</div>

												<div class="<?= $is_hidden; ?> input-group proxy_value_container">
													<input type="text" class="input-group-field proxy_value" 
												   name="proxy_value" placeholder="Proxy Bid" value="<?= $proxy_val; ?>" >
													

													<div class="input-group-button">
														<button class="button blue add-proxy-bid" 
														    data-auction="<?= $car_auction->auction_id ?>" 
														    data-dealer="<?= $dealer_id ?>" >
															Submit
														</button>
													</div>
												</div>
											</div>

										</div>
									</div>
								</div>
							<?php  } ?>
						</div>
					</div>
				
				
					<div class="row is-hidden" id="proxy-bid-container">
						<div class="columns large-6 large-centered">
							<div class="input-group proxy_value_container">
								<input type="text" class="input-group-field proxy_value" name="proxy_value" placeholder="Proxy Bid" id="proxy-value-<?= $car_auction->auction_id ?>" value="<?= $proxy_val; ?>" >
								<div class="input-group-button">
									<button class="button blue add-proxy-bid" 
									        data-auction="<?= $car_auction->auction_id; ?>" data-dealer="<?= $dealer_id ?>" >
									Submit
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
			<div class="row">
				<div class="columns small-12 medium-8 large-9">
					<p>Trim</p>
				</div>
				<div class="columns small-12 medium-4 large-3 text-right">
					<p><?= $car_details->trim; ?></p>
				</div>
				<hr>
			</div>
			
			<div class="row">
				<div class="columns small-12 medium-8 large-9">
					<p>Mileage</p>
				</div>
				
				<div class="columns small-12 medium-4 large-3 text-right">
					<p><?php if($car_details->mileage) { echo number_format($car_details->mileage). ' '
						       .ucwords($car_details->mileage_type); } 
							 else{ echo '0 Km'; } 
					    ?></p>
				</div>
				
				<hr>
			</div>
			
			<div class="row">
				<div class="columns small-12 medium-8 large-9">
					<p>Exterior</p>
				</div>
				
				<div class="columns small-12 medium-4 large-3 text-right">
					<p><?php if($car_details->exterior_color) { echo $car_details->exterior_color; } 
						     else{ echo 'N/A'; } 
					    ?></p>
				</div>
				
				<hr>
			</div>
			
			<div class="row">
				<div class="columns small-12 medium-8 large-9">
					<p>Interior</p>
				</div>
				
				<div class="columns small-12 medium-4 large-3 text-right">
					<p><?php if($car_details->interior_color) { echo $car_details->interior_color; } 
						     else{ echo 'N/A'; } 
					    ?></p>
				</div>
				
				<hr>
			</div>
			
			<div class="row">
				<div class="columns small-12 medium-8 large-9">
					<p>Transmission</p>
				</div>
				
				<div class="columns small-12 medium-4 large-3 text-right">
					<?php if($car_details->transmission != "" ) { ?>
						<p><?= ucwords(strtolower($car_details->transmission)); ?></p>
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
					<?php if($car_details->drivetrain != "" ) { ?>
						<p><?= ucwords(strtolower($car_details->drivetrain)); ?></p>
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
					<?php if($car_details->fuel_type != "" ) { ?>
						  <p><?= ucwords(strtolower($car_details->fuel_type)); ?></p>
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
					<?php if($car_details->has_accident){ ?>
					<p><?= $car_details->has_accident ?>
						<?php if($car_details->has_accident == 'Yes') { ?>
							<br><?= 'Repairs: $'.$car_details->value_repair; 
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
					<?php if($car_declaration_details != NULL ) { ?>
						<p><?= $car_declaration_details; ?></p>
					<?php } else { ?>
						<p><a>N/A</a></p>
					<?php } ?>
				</div>
				
				<hr>
			</div>
			<?php if ($live) { ?>
			<div class="row">
				<div class="column column-block">
					<!-- <a class="call-to-action-green contact-seller"><span>Contact Seller</span></a> -->
				</div>
			</div>
			<?php } ?>
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
				<a class="button green" rel="button-modal-bid-info" data-value="close">Close</a>
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
<script>
	var origtext;
	var origclass;
	
	$('[rel="bid"]').on('click', function() {
			if (!$(this).hasClass('is-active')) {
				$(this).addClass('button orange is-active');
				$(this).text('Cancel');
				$('.bid-container').removeClass('is-hidden');
			} else {
				$(this).text('Place Bid');
				$(this).removeClass('orange is-active');
				$(this).addClass('green');
				$('.bid-container').addClass('is-hidden');
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
			if(proxy_data != ""){
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

				$('#place-bid').removeClass('green');
				$('#place-bid').addClass('gray');

				$('#proxy-bid-btn').addClass('gray no-proxy');
				$('#proxy-bid-btn').removeClass('green orange has-proxy');
				$('#proxy-bid-btn').text('Use Proxy Bid');
				$('#proxy-bid-txt').text('');
				$('#proxy-bid-txt').hide();

				$('.bid-container').addClass('is-hidden');
				$('#place-bid').removeClass('orange');
				$('#place-bid').text('Place Bid');
				
				// window.location.href = "<?= site_url('dealer/auction'); ?>";

		   }else{
		   		var auction_info = "Proxy Bid Not Removed";
		   		var response_bid = "Proxy Bid is failed to remove.";
		   		$('#response-bid-title').text(auction_info);
		   		$('#response-bid-text').text(response_bid);
				$('#modal_bid').foundation('open');

		   }
		});
	}
</script>

<!-- EVENT LISTENER & OUTBID NOTIFICATION -->
<script type="text/javascript">
	var live       = <?= $live; ?>;
	console.log(live);
	if(localStorage.getItem(0) === null){
		var object = { 'summarized': 1, 'notif': 1, 'bid': 0, 'name': 'auction name' }
		localStorage.setItem(0, JSON.stringify(object));
	}

	var streamURL  = "<?= $get_dealer_single_auction_stream; ?>";
	if (!!window.EventSource) {
	  var evtSource  = new EventSource(streamURL); //, {withCredentials : true}
	} // Else, Result to xhr polling 
	
	var auction_names = "";
	evtSource.onmessage = function(e) {
		var watchlist = JSON.parse(e.data); console.log(watchlist);

		if(watchlist.won_proxy == '1'){
			if(live == 1){

				$('#proxy-bid-2-'+watchlist.auction_id).attr( 'checked', true );
				$('#proxy-bid-2-'+watchlist.auction_id).closest('.faux').next().removeClass('is-hidden');
				$('#proxy-bid-2-'+watchlist.auction_id).attr( 'data-proxy', watchlist.proxy_val );
				$('#my_proxy_value').text('$'+commaSeparateNumber(watchlist.dealer_prox));
				$('.proxy_value').val(watchlist.dealer_prox);

			}else{
	 			$('#proxy-bid-container').addClass('is-hidden');
	 			$('#proxy-bid-btn').removeClass('orange');
	 			$('#proxy-value-container').addClass('is-hidden');
			}

			$('#proxy-bid-btn').removeClass('gray no-proxy');
			$('#proxy-bid-btn').addClass('green has-proxy');
			$('#proxy-bid-btn').text('Remove Proxy');
			$('#proxy-bid-txt').text('By Proxy: $' + commaSeparateNumber(watchlist.proxy_val));
			$('#proxy-bid-txt').show();

		}else{
			
			if(live == 1){
				$('#proxy-bid-2-'+watchlist.auction_id).attr( 'data-proxy', "" );
				$('#my_proxy_value').text('N/A');
				// $('#proxy-bid-2'+watchlist.auction_id).attr( 'checked', false );

				if($('[rel="bid"]').hasClass('orange') ){

					if($('#proxy-bid-2-'+watchlist.auction_id).hasClass('check')){
						$('#proxy-bid-2-'+watchlist.auction_id).attr( 'checked', true );
						$('#proxy-bid-2-'+watchlist.auction_id).closest('.faux').next().removeClass('is-hidden');
					}else{
						$('#proxy-bid-2'+watchlist.auction_id).attr( 'checked', false );
						$('#proxy-bid-2'+watchlist.auction_id).closest('.faux').next().addClass('is-hidden');
						$('.proxy_value').val('');
					}

				}else{
					
					$('#proxy-bid').removeClass('check');
					$('#proxy-bid').removeClass('uncheck');
				}

				$('#proxy-bid-btn').addClass('gray no-proxy');
				$('#proxy-bid-btn').removeClass('green has-proxy');
				$('#proxy-bid-btn').text('Place Bid');
				$('#proxy-bid-txt').text('');
				$('#proxy-bid-txt').hide();

			}else{
				if($('#proxy-bid-btn').hasClass('orange') ){
					$('#proxy-bid-btn').text('Cancel');
				}else{
					$('#proxy-bid-btn').text('Use Proxy Bid');
				}

				// SHOW PROXY TEXT BEFORE LIVE IF DEALER HAS PROXY
				if(watchlist.dealer_prox != "" && $('#proxy-bid-btn').hasClass('has-proxy') ){
					$('#proxy-bid-btn').removeClass('gray no-proxy');
					$('#proxy-bid-btn').addClass('green has-proxy');
					$('#proxy-bid-txt').text('By Proxy: $' + commaSeparateNumber(watchlist.dealer_prox));
					$('#proxy-bid-txt').show();

					$('#proxy-bid-btn').text('Remove Proxy');
				}else{
					$('#proxy-bid-btn').addClass('gray no-proxy');
					$('#proxy-bid-btn').removeClass('green has-proxy');
					$('#proxy-bid-txt').text('');
					$('#proxy-bid-txt').hide();
				}
			}
				
			
		}

		if(watchlist.dealer_win == '1'){
			$('#place-bid').removeClass('gray');
			$('#place-bid').addClass('green');
		}else{
			$('#place-bid').removeClass('green');
			$('#place-bid').addClass('gray');

			var data   = localStorage.getItem(watchlist.auction_id);
			data       = JSON.parse(data);

			if (localStorage.getItem(watchlist.auction_id) === null) {
				var object = { 'summarized': 0, 'notif': 0, 'bid': 0, 'name': watchlist.auction_name }
			  	localStorage.setItem(watchlist.auction_id, JSON.stringify(object));
			}else{
				if(live == 1){
					if(data['summarized'] == 0 && data['bid'] == 1){
						auction_names 		= auction_names + "\n" + data['name'];
						data['summarized'] 	= 1;
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
								$('#proxy-bid-txt').text('');
								$('#proxy-bid-txt').hide();
							});	
						}
					}
				}
			}
		}

		$('#highest-value').html('<i class="fa fa-usd"></i>'+commaSeparateNumber(watchlist.bid_value));
		$('#my-value').html('<i class="fa fa-usd"></i>'+commaSeparateNumber(watchlist.my_value));
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
										
			var server_time = moment("<?= $auction_time->server_time_auction ?>");
			var auction_end = moment("<?= date('Y-m-d H:i:s', strtotime($car_auction->endtime)) ?>");
			
			var auction_remain_time     = Math.abs(server_time.diff(auction_end, 'seconds'));
			var auction_local_end_time  = moment().add(auction_remain_time, 'seconds').format('YYYY/MM/DD HH:mm:ss');

			var end_auction_epoch = <?= strtotime($car_auction->endtime); ?>;
			if(end_auction_epoch > 0){
				//var end_auction_time  = '<?= date('Y/m/d H:i:s', strtotime($a->endtime . '+0 day'))?>';
				var end_auction_time = auction_local_end_time;
			  	if ($('#countdown-clock-<?= $car_auction->auction_id; ?>').length > 0) {
					$('#countdown-clock-<?= $car_auction->auction_id; ?>').countdown(end_auction_time)
						.on('update.countdown', function(event) {
							if(event.offset.totalSeconds < 2){
								window.location = "<?= site_url('dealer'); ?>";
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
	});
		
	$('[rel="proxy-bid"]').on('click', function() {
		if ($(this).hasClass('no-proxy')) {

			$(this).removeClass('gray');
			$(this).addClass('orange is-active');
			$(this).text('Cancel');

			if ($(this).hasClass('is-active')) {
				if (!$('#proxy-bid-container').hasClass('is-hidden')) {
					$('#proxy-bid-container').addClass('is-hidden');
					$(this).text('Use Proxy Bid');
					$(this).removeClass('orange is-active');
					$(this).addClass('gray');
					
				} else {
					$('#proxy-bid-container').removeClass('is-hidden');
				}
			}
		}
	});
})();
</script>   

<script>

$('.add-proxy-bid').on('click', function(){
	var auction_id  = $(this).data('auction');
	var dealer_id   = $(this).data('dealer');
	var proxy_value = $(this).closest('.proxy_value_container').find('.proxy_value').val();
	var live        = <?= $live; ?>;
	console.log(proxy_value);

	if(proxy_value=="0" || proxy_value=="" || parseInt(proxy_value) < 100 || parseInt(proxy_value) > 999000){
		$('#response-bid-title').text("Proxy Bid Limit Exceeded");
   		$('#response-bid-text').text("Please enter a Proxy Bid between value $100-999,000.");
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
			   		var auction_info = "Proxy Bid is Succefully Placed";
		   			var response_bid = "Thank you for placing a proxy bid. By adding $" + proxy_value 
		   			         + " proxy bid value, You have authorized a maximum $" + proxy_value + " autobid to be placed on the auction."
		   			         + " The Autobid will be placed incrementally $100 upon incoming bid from other dealers.";
			   		$('#response-bid-title').text(auction_info);
			   		$('#response-bid-text').text(response_bid);
					$('#modal_bid').foundation('open');
					$('#place-bid').removeClass('gray');
					$('#place-bid').addClass('green');
					if(live){
						$('.bid-container').addClass('is-hidden');
			 			$('#place-bid').removeClass('orange');
			 			$('#place-bid').text('Place Bid');
					}else{
			 			$('#proxy-bid-container').addClass('is-hidden');
					}

					$('#proxy-bid-btn').removeClass('gray orange');
					$('#proxy-bid-btn').addClass('green');

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

					window.location.href = "<?= site_url('auction/detail/'.$auction_id.'/dealer'); ?>";

			   }
			   else if(resp.status=='error'){
			   		var pattern = /proxy bid is lower/i;
	  				var found   = resp.error_message.match( pattern );
	  				if(!found)
	  					$('#response-bid-title').text("Proxy Bid Error");
	  				else
	  					$('#response-bid-title').text("You've Been Outbid by Proxy");
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
			$('#place-bid').removeClass('green');
			$('#place-bid').addClass('gray');
			$('#proxy-bid-container').addClass('is-hidden');
			$('#proxy-bid-btn').removeClass('green has-proxy');
			$('#proxy-bid-btn').addClass('gray no-proxy');
			$('#proxy-bid-btn').text('Use Proxy Bid');
			$('#my_proxy_value').text('N/A');
	   }else{
	   		var auction_info = "Proxy Bid Not Removed";
	   		var response_bid = "Proxy Bid is failed to remove.";
	   		$('#response-bid-title').text(auction_info);
	   		$('#response-bid-text').text(response_bid);
			$('#modal_bid').foundation('open');
	   }
	});
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
	   		$('#response-bid-text').text("Please enter a Proxy Bid between value $100-999,000.");
			$('#modal_bid').foundation('open');
		} else {
			//SHOW CONFIRMATION MODAL
			$('#response-confirm-title').text('Bid Confirm');
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
				 		var response_bid; var highest_bid = resp.data.bid.car_tradein_value;
				 		$('#highest-value-'+auction_id).html('<i class="fa fa-usd"></i>'+highest_bid.toLocaleString());
				 		$('#highest-value-w-'+auction_id).html('<i class="fa fa-usd"></i>'+highest_bid.toLocaleString());
				   		if(resp.data.auction.won_dealer_id==bidData.dealer_id){
				   			response_bid = "Thanks for placing a bid. By adding $" + bid_value 
				   			             + ", You have bid the auction for $" + highest_bid + " in total.";
				   		}else{
				   			response_bid = "Thanks for placing a bid. Unfortunately, another dealer has outbid. Current bid is $" + highest_bid + ".";
				   		}
				   		var auction_info = "Your " + resp.data.bid.car_sold_year + " " + resp.data.bid.car_sold_maker + " Bid";
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
							data['bid']			= 1;
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

$( document ).on('click', '.add-remove-watchlist', function(e) {
	var auction_id = $(this).data('auction');
	var dealer_id  = $(this).data('dealer');
	var watchlist_status = $(this).data('watchlist');

	var watchlistData = {
        'dealer_id'  : dealer_id,
        'auction_id' : auction_id
    };
    console.log(watchlistData);
    if(watchlist_status=='watch'){
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
				$('.add-remove-watchlist').addClass('is-active'); 
				$('.add-remove-watchlist').data('watchlist', 'remove');
	    	}
		});
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
				$('.add-remove-watchlist').removeClass('is-active');
				$('.add-remove-watchlist').data('watchlist', 'watch');
	    	}
		});
	}
});

$(document).on('click', '[rel="button-modal-info"]', function() {
	$('.info-window').foundation('close');
});

$(document).on('click', '[rel="button-modal-bid-info"]', function() {
	$('.info-window').foundation('close');
	window.location.reload(true);
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

<?php if(!$live) { ?>
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
<?php } ?>