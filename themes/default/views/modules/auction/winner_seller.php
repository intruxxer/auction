<div class="columns small-12">
	<div class="row">
		<div class="columns small-12">
			<div class="carousel">
				<?php foreach($data->multimedia as $m) { ?>
				<div class="item">
					<img src="<?php echo $m; ?>">
				</div>
				<?php } ?>
			</div>
			
			<h2 class="text-center"><?= $data->item_title; ?></h2>
			
			<p class="text-center"><?= $data->dealer_first_name.' '.$data->dealer_last_name; ?></p>
			
			<div class="row">
				<div class="columns small-12 medium-8 medium-centered">
					<div class="row">
						<hr>
						
						<div class="columns small-12 large-6">
							<p><?= $data->dealer_company; ?></p>
						</div>
						
						<div class="columns small-12 large-6 text-right">
							<p><a><?= $data->company_website; ?></a></p>
						</div>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="columns small-12 medium-8 medium-centered">
					<p class="winning-bid"><?= $data->currency.' '.number_format($data->bid_value); ?></p>
					<!--
					<p class="text-center"><a>I have not been contacted by this bidder within 48 hours</a></p>
					-->
				</div>
			</div>
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