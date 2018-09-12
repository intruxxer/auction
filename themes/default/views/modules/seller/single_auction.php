<div class="columns small-12">
	<div class="row">
		<div class="columns small-12">
			<div class="box-carousel">
				<div class="carousel seller-auction">
				<?php foreach ($data->multimedia as $key => $picture) { ?>
					<div id="single-auction-<?= $picture->id ?>" class="item" data-value="<?= $picture->multimedia_code ?>">
						<img src="<?= $picture->filename;?>">
					</div>
				<?php } ?>
				</div>
				
				<p></p>
			</div>
			
			<h2><?= $data->auction->item_title ?></h2>

			<div class="row">
				<div class="columns small-12 medium-8 large-9">
					<p>Detail</p>
					<ul class="spec">
						<li class="fuel">
							<?php if(empty($data->sale->fuel_type)){ echo 'N/A'; ?>
							<?php }else{ echo $data->sale->fuel_type; } ?>	
						</li>
						<li class="odometer">
							<?php if(empty($data->sale->mileage)){ echo 'N/A'; ?>
							<?php }else{ echo $data->sale->mileage. ' '.$data->sale->mileage_type; } ?>	
						</li>
						<li class="transmission">
							<?php if(empty($data->sale->transmission)){ echo 'N/A'; ?>
							<?php }else{ echo ucwords($data->sale->transmission); } ?>	
						</li>
						<!-- <li class="capacity">
							<?php if(empty($data->sale->passenger)){ echo '0 people'; ?>
							<?php }else{ echo $data->sale->passenger.' people'; } ?>
						</li> -->
					</ul>
				</div>
			</div>
			
			<div class="row">
				<div class="columns small-12 ">
					<p>Notes</p>
				</div>
				
				<div class="columns small-12">
					<p><?= $data->declaration_details; ?></p>
				</div>
				
				<hr>
			</div>
			
			<div class="row">
				<?php if($data->auction->status == "1.1"){ ?>
				<?php 	if($data->auction->start_time >= date('Y-m-d H:i:s')){ $cta = 'call-to-action-green unset-auction'; }else{ $cta = 'call-to-action'; } ?>
					<div class="small-6 columns"> 
						<a class="call-to-action" href="<?= site_url('auction/'.$data->auction->auction_id.'/edit/'.$data->auction->car_sale_id) ?>">
						<span>Edit</span></a>
					</div>
					<div class="small-6 columns"> 
						<a 	id="btn-auction-<?= $data->auction->auction_id ?>" class="<?= $cta; ?>" 
							data-auction="<?= $data->auction->auction_id; ?>"
						   	href="<?= site_url('auction/'.$data->auction->auction_id.'/detail/seller/'.$data->auction->car_sale_id) ?>">
						<span>Auction</span></a>
					</div>
				<?php }else{ ?>
					<div class="small-6 columns">
						<a class="call-to-action-green" href="<?= site_url('auction/history/'.$data->auction->auction_id.'/seller') ?>">
						<span>Live Auction</span></a>
					</div>
					<div class="small-6 columns"> 
						<?php 	if($data->auction->unread_messages > 0)
						  		{ $unread_badge = '<span class="badge">'.$data->auction->unread_messages.'</span>'; }
						  		else
						  		{ $unread_badge = ''; } 
						?>
						<a class="call-to-action-green" href="<?= site_url('auction/'.$data->auction->auction_id.'/inbox/seller') ?>">
						<span>Notification</span><?= $unread_badge ?></a>
					</div>
				<?php	}
				?>	
			</div>
		</div>
	</div>
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

})();
</script> 
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