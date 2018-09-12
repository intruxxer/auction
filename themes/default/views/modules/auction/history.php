<div class="columns small-12">

	<div class="row">
		<div class="columns small-12">
			<div class="carousel">
			<?php foreach($data->car_details->multimedia as $m) { ?>
				<div class="item">
					<img src="<?php echo $m; ?>">
				</div>
			<?php } ?>
			</div>
			
			<div class="row auction-progress">
				<div class="columns small-12 medium-8 medium-centered large-6">
					<div class="row">
						<div class="columns small-12 medium-6">
							<?php
								if(strtotime($data->endtime) < strtotime(date('Y-m-d H:i:s'))){ ?>

								<p>00:00:00</p>
							<?php	} else { ?>
								<p id="countdown-clock-<?= $data->auction_id; ?>"></p>
							<?php }?>
							
							
							<p><small>Time Remaining</small></p>
						</div>
						
						<div class="columns small-12 medium-6">
							<p><?= number_format($data->current_bid); ?></p>
							
							<p><small>Current Bid</small></p>
						</div>
					</div>
				</div>
			</div>
			
			<h2><?= $data->item_title; ?></h2>
			
			<p><?= $data->car_details->doors.' Doors '.$data->car_details->body_style; ?></p>
			
			<h4>Detail</h4>

			<ul class="spec">
				<li class="fuel">
					<?php if($data->car_details->fuel_type){ echo ucwords($data->car_details->fuel_type); }
					      else{ echo 'N/A'; } ?> 
				</li>
				
				<li class="odometer">
					<?php if($data->car_details->mileage) { echo number_format($data->car_details->mileage). ' '
					      .ucwords($data->car_details->mileage_type); }
							  else{ echo '0 Mi'; }
					?>
				</li>
				
				<li class="transmission">
					<?php if($data->car_details->transmission) { echo ucwords(strtolower($data->car_details->transmission)); }
							else{ echo 'N/A'; } ?>
				</li>
				
				<li class="capacity"><?php if($data->car_details->passengers) { echo ucwords(strtolower($data->car_details->passengers)).' Person'; }
							else{ echo '0 Person'; } ?></li>
			</ul>
			
			<h4>Description</h4>
			
			<p><?php if($data->description) { echo ucwords(strtolower($data->description)); }
				else{ echo 'Remarks : N/A'; } ?>
			</p>
			
			<ul class="accordion bid-history" data-accordion>
				<li class="accordion-item is-active" data-accordion-item>
					<a href="#" class="accordion-title">Bid History</a>
					
					<div class="accordion-content" data-tab-content>
					<?php foreach($data->history as $a) {?>
						<div class="row">
							<div class="columns small-12 medium-6">
								<p><i class="fa fa-clock-o"></i>&nbsp;&nbsp;&nbsp;<?= date('H:i:s', strtotime($a->created_on)); ?></p>
							</div>
							
							<div class="columns small-12 medium-6 text-right">
								<p><i class="fa fa-dollar"></i>&nbsp;&nbsp;&nbsp;<?= number_format($a->amounts); ?></p>
							</div>
							
							<hr>
						</div>
					<?php } ?>
					</div>
				</li>
			</ul>
		</div>
	</div>
</div>
<script>
(function(){
  "use strict";

  $('.carousel').slick({
	  arrows: false,
	  dots: true,
	  infinite:false});
})();
</script>
<script>
(function(){
	"use strict";
	var end_auction_epoch = <?= strtotime($data->endtime); ?>;
	if(end_auction_epoch > 0){
		var end_auction_time  = '<?= date('Y/m/d H:i:s', strtotime($data->endtime . '+0 day'))?>';
	  	if ($('#countdown-clock-<?= $data->auction_id; ?>').length > 0) {
			$('#countdown-clock-<?= $data->auction_id; ?>').countdown(end_auction_time)
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