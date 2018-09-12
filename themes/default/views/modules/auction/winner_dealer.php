<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="columns small-12">
	<div class="row">
		<div class="columns small-12">
			<div class="box-carousel">
				<div class="carousel seller-auction">
					<?php foreach($data->multimedia as $m) { ?>
						<div class="item">
							<img src="<?php echo $m; ?>">
						</div>
					<?php } ?>
				</div>
				<p></p>
			</div>

			<h2 class="text-center"><?= $data->item_title; ?></h2>
			
			<div class="row">
				<div class="columns small-12 medium-6 medium-centered text-center">
					<a class="button blue" href="<?= site_url('auction/detail/'.$auction_id.'/dealer/won') ?>" >Details</a>
				</div>
			</div>
			
			<div class="row">
				<div class="columns small-12 medium-6 medium-centered text-center">
					<p class="winning-bid"><?= $data->currency.' '.number_format($data->bid_value); ?></p>
					
					<hr>
					
					<h3><?= $data->seller_name; ?></h3>
					
					<h3><?= $data->seller_cellphone; ?></h3>
					
					<h3><a><?= $data->seller_email; ?></a></h3>
					
					<br>
				</div>
			</div>
			
			<div class="row">
				<div class="columns small-12 medium-6 medium-centered text-center">
					<a class="button blue" href="<?= site_url('auction/'.$auction_id.'/purchase') ?>">Looking to Purchase</a>
				</div>
			</div>
		</div>
	</div>
</div>
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