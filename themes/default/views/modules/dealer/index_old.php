<div class="columns small-12">
	
	<section>
		<div class="row">
			<div class="columns small-12 text-center">
				<h1>Statistics</h1>
			</div>
		</div>
		<?php if($statistics->total_bid) { ?>
		<div class="row">
			<div class="columns small-12">
				<div id="statistic-container">
					<div class="left">
						<div id="lost-chart-container">
							<canvas id="lost-chart"></canvas>
						</div>
						
						<div id="win-chart-container">
							<canvas id="win-chart"></canvas>
						</div>
					</div>
					
					<div class="right">
						<p class="legend won">Won <?php echo $statistics->won ?></p>
						
						<p class="legend lost">Lost <?php echo $statistics->lost ?></p>
						
						<p class="value">Average Value<br><?php echo $statistics->average ?></p>
						
						<a class="button green" href="">View History</a>
					</div>
				</div>
			</div>
		</div>
		<?php }else{ ?>
			<p class="text-center">You haven't completed any auction before.</p>
		<?php } ?>
	</section>
	
	<section>
		<div class="row">
			<div class="columns small-12">
				<h2 class="header-bar">Auction</h2>
				
				<?php if ($auction_active) { ?> 
					<div class="carousel dealer-auction">
						<?php foreach ($auctions as $a) { ?>
						<div class="item">
							<h3><?= $a->item_title ?></h3>
							<img src="<?php echo $a->car_details->front34; ?>">
							<p class="countdown-clock text-center">00:00:00</p>
							<div class="row">
								<div class="columns small-12 medium-8 medium-centered">
									<div class="row bids">
										<div class="columns small-12 medium-6">
											<p>Current Bid</p>
										</div>
										
										<div class="columns small-12 medium-6">
											<p class="text-right">$<?= number_format($a->highest_bid); ?></p>
										</div>
										
										<hr>
									</div>
									<div class="row">
										<div class="columns small-12 medium-6">
											<p>My Last Bid</p>
										</div>
										
										<div class="columns small-12 medium-6">
											<p class="text-right">$<?= number_format($a->my_last_bid); ?></p>
										</div>
										
										<hr>
									</div>
									
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

								</div>
							</div>
							<div class="row">
								<div class="columns small-12 medium-8 medium-centered text-centered">
									<a class="call-to-action-green" 
									   href="<?= site_url('auction/'.$a->auction_id.'/detail/dealer/'.$a->car_details->car_sale_id) ?>">
										<span>Detail</span>
									</a>
								</div>
							</div>
						</div>
						<?php } ?>
					</div>
				<?php } else { ?>
					<p class="text-center">Next auction will start in:</p>
					<p id="countdown-clock" class="text-center">00:00:00</p>
				<?php } ?> 
				<?php if($auction_active && count($auctions) < 1){ ?>
				<p class="text-center">There is no auction created/matching to your criteria.</p>
				<?php } ?>
			</div>
		</div>
	</section>
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
<script>
(function(){
	"use strict";
	<?php if($statistics->total_bid) { ?>

	Chart.defaults.global.legend.display = false;
	Chart.defaults.global.tooltips.enabled = false;
	
	var lost_ctx = document.getElementById("lost-chart").getContext('2d');
	var lostChart = new Chart(lost_ctx, {
	  type: 'doughnut',
	  data: {
	    labels: ["M"],
	    datasets: [{
	      backgroundColor: [
	        "#4a6d82",
	        "#f2f2f2"
	      ],
	      data: [<?= $statistics->lost ?>, <?= $statistics->won ?>]
	    }]
	  },
	  options: {
		  cutoutPercentage: 80,
		  rotation: 0 * Math.PI
	  }
	});
	
	var win_ctx = document.getElementById("win-chart").getContext('2d');
	var winChart = new Chart(win_ctx, {
	  type: 'doughnut',
	  data: {
	    labels: ["M"],
	    datasets: [{
	      backgroundColor: [
	        "#fc510b",
	        "#f2f2f2"
	      ],
	      data: [<?= $statistics->won ?>, <?= $statistics->lost ?>]
	    }]
	  },
	  options: {
		  cutoutPercentage: 75,
		  rotation: 0 * Math.PI
	  }
	});
	<?php } ?>

	var start_auction = '<?= date('Y/m/d H:i:s', strtotime($auction_time->start_live_auction . '+'.$auction_day.' day'))?>';
	var end_auction   = '<?= date('Y/m/d H:i:s', strtotime($auction_time->end_live_auction . '+'.$auction_day.' day'))?>';

  	if ($('#countdown-clock').length > 0) {
		$('#countdown-clock').countdown(start_auction)
			.on('update.countdown', function(event) {
				var format = '%H:%M:%S';
				if(event.offset.totalDays > 0) {
			    	format = '%-d day%!d ' + format;
			  	}
			  	
			  	if(event.offset.weeks > 0) {
			    	format = '%-w week%!w ' + format;
			  	}
			  	
			  	$(this).html(event.strftime(format));
			  	$('.countdown-clock').html(event.strftime(format));
			});
	}
	
	if ($('.carousel').length > 0) {
		$('.carousel').slick(
			{
				infinite: false,
				prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-arrow-left"></i></button>',
				nextArrow: '<button type="button" class="slick-next"><i class="fa fa-arrow-right"></i></button>'
			});
			
		$('.carousel .countdown-clock').countdown(end_auction)
			.on('update.countdown', function(event) {
				var format = '%H:%M:%S';
				if(event.offset.totalDays > 0) {
			    	format = '%-d day%!d ' + format;
			  	}
			  	
			  	if(event.offset.weeks > 0) {
			    	format = '%-w week%!w ' + format;
			  	}
			  	
			  	$(this).html(event.strftime(format));
			  	$('.countdown-clock').html(event.strftime(format));
			});
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