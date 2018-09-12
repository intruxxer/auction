<div class="columns small-12">
	<div class="row">
		<div class="columns small-12 text-center">
			<h2>Looking to Purchase</h2>
		</div>
	</div>
	
	<form id="seller-preference" class="car-detail" method="post">
		<div class="row">
			<div class="columns small-12 text-center">
			<?php $n = 0; foreach ($body_styles as $style) { ?>
				<?php if(($n%5)==0){ ?> 
					<ul class="options-interest types"> 
				<?php } ?>
						<li data-style="<?php echo $style->name ?>" class="body_style <?php echo $style->active ?>">
							<a>
								<?php $icon_vehicle = str_replace(' ', '', strtolower($style->name)); ?>
								<img src="<?php echo base_url(); ?>assets/img/icon-vehicle-<?= $icon_vehicle; ?>.png">
							</a>
							<?php echo $style->name; ?>
						</li>
				<?php if(($n%4)==0 && ($n!=0)){ ?> 
					</ul> 
				<?php } ?>
			<?php $n++; } ?>
				<p>Choose up to three</p>
			</div>
			
			<hr>
		</div>
		
		<div class="row">
			<div class="columns small-12 tag-cloud">
				<p id="brand-label">Brands</p>
				<?php foreach ($brands as $brand) { ?>
					<?php if(true){ 
						$brand_name = str_replace(" ", "-", $brand->name); ?>
						<a id="btn-brand-<?= strtolower($brand_name) ?>" class="button all-brand <?php echo $brand->green; ?>"
						   data-brand="<?php echo $brand->name ?>" >
							<?php echo $brand->name; ?>
						</a>
					<?php } ?>
				<?php } ?>
				<p class="text-center">Choose up to five</p>
			</div>
			
			<hr>
		</div>

		<div class="row">
			<div class="columns small-12">
				<div class="input-group">
					<input class="input-group-field" type="text" name="add_single_brand" placeholder="Add Brand">
					<div class="input-group-button">
						<a class="button green add-single-brand">Add</a>
					</div>
				</div>
			</div>
		</div>
		
		<div class="row">
			<?php if(empty($new_auction)) { ?>
			<div class="columns small-12 text-center">
				<button class="call-to-action-green"><span>SUBMIT</span></button>
			</div>
			<?php }else{ ?>
			<div class="columns small-6 text-center">
				<a class="call-to-action-green set-preference" data-next="draft"><span>Save Draft</span></a>
			</div>
			<div class="columns small-6 text-center">
				<a class="call-to-action-green set-preference" data-next="live"><span>Post to Auction</span></a>
			</div>
			<?php } ?>
		</div>
		<input type="hidden" name="body_styles" value=""><input type="hidden" name="brands" value="">
	</form>
</div>
<div class="reveal tiny" id="modal_pickone" data-reveal>
	<div class="row">
		<div class="columns small-12 text-center">
			<h4>Advise</h4>
			<hr>
			<p>Please enter at least one brand of car manufactures.</p>
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
<div class="reveal tiny" id="modal_add_brand" data-reveal>
	<div class="row">
		<div class="columns small-12 text-center">
			<h4 id="brand-info-title"></h4>
			<hr>
			<p id="brand-info-text"></p>
			<div class="button-group">
				<a class="button green" rel="button-modal-add-brand" data-value="close">Close</a>
			</div>
		</div>
	</div>
</div>
<div class="reveal tiny" id="modal_submit" data-reveal>
	<div class="row">
		<div class="columns small-12 text-center">
			<h4 id="submit-info-title"></h4>
			<hr>
			<p id="submit-info-text"></p>
			<div class="button-group">
				<a class="button green" rel="button-submit-info" data-value="close">Close</a>
			</div>
		</div>
	</div>
</div>
<div class="reveal tiny" id="modal_active_auction" data-reveal></div>
<link   rel="stylesheet" href="<?php echo site_url() ?>assets/css/auto-complete.css">
<script type="text/javascript" src="<?php echo site_url() ?>assets/js/auto-complete.min.js"></script>
<script type="text/javascript">
	new autoComplete({
	    selector: 'input[name="add_single_brand"]',
	    minChars: 2,
	    source: function(term, suggest){
	        term = term.toLowerCase();
	        var choices = [<?php echo $brands_collection; ?>];
	        var matches = [];
	        for (i=0; i<choices.length; i++)
	            if (~choices[i].toLowerCase().indexOf(term)) matches.push(choices[i]);
	        suggest(matches);
	    }
	});
</script>
<script type="text/javascript">
	var styles  = [<?php echo $styles_preference; ?>];
	var brands  = [<?php echo $brands_preference; ?>];
	var br_ref  = [<?php echo $brands_collection; ?>];
	var updated = false;
	console.log("styles: " + styles); 
	console.log("brands: " + brands);
	console.log("ref. brands: " + br_ref);

	// Add Seller Preferences from New Auction
	$('.set-preference').on("click", function(e){
		if(styles.length > 3){
			$('#edit-info-title').html("Purchase Preferences");
			$('#edit-info-text').html("You can choose only up to 3 different styles.");
		    $('#modal_edit_info').foundation('open');
		}
		else if(brands.length > 5){
			$('#edit-info-title').html("Purchase Preferences");
			$('#edit-info-text').html("You can choose only up to 5 different brands.");
		    $('#modal_edit_info').foundation('open');
		}
		else{
			var next       = $(this).data('next');
			<?php if($auction_id){ ?>
				var auction_id = <?= $auction_id ?>;
			<?php } ?>
			
			var preferenceData = {
		        'seller_id'       : <?= $seller_id ?>,
		        'body_styles'     : styles,
		        'brands'          : brands
		    };

		    $.ajax({
		        type        : "POST", 
		        url         : "<?= $post_seller_preference ?>", 
		        data        : preferenceData,
		        dataType    : 'json',
		        encode      : true
		    }).done(function(data) { 
		    	$('#submit-info-title').html("Purchase Preferences");
				$('#submit-info-text').html("Your Car's Preferences have been updated.");
			    $('#modal_submit').foundation('open');
		    }).fail(function(data) {
			    $('#submit-info-title').html("Purchase Preferences");
				$('#submit-info-text').html("Error on updating your car's preferences.");
			    $('#modal_submit').foundation('open');
			}).always(function(data) {
		    	console.log(data); 
		    	if(next=='draft')
		    		window.location = "<?= site_url('seller') ?>";
		    	else if(next=='live'){
		    		var status = set_live_auction(auction_id); console.log(status);
		    		setTimeout(function(){
					    if(status){ window.location = "<?= site_url('seller') ?>"; }
					}, 2000);
		    	}

			});
	 	}
	});

	function set_live_auction(auction_id){
		var auctionData   =  { 'auction_id' : auction_id };
		var auctionURL    =  "<?= site_url('auction/set_auction') ?>/" + auction_id + "/active";
		var auctionResult = true;
		$.ajax({ 
		type : "POST", url : auctionURL, data : auctionData, dataType : 'json', encode : true })
		.done(function(data) { 
			if(data.start_time && data.endtime){
				$('#modal_active_auction').html(
				'<h4>Auction is activated</h4>' + '<p>Auction is active on ' + data.start_time + ' - ' + data.endtime + '</p>' 
				+ '<a class="button green" rel="button-modal-confirm-ok-auction" data-value="ok">OK</a>')
				.foundation('open');
			}
			else{
				$('#modal_active_auction').html(
				'<h4>Active Auction</h4>' + '<p>Auction is already active on upcoming auction. </p>' 
				+ '<a class="button green" rel="button-modal-confirm-ok" data-value="ok">OK</a>')
				.foundation('open');
			}
		})
		.fail(function(data) { auctionResult = true; })
		.always(function(data){ console.log(data); });

		return auctionResult;
	}

	// Add Seller Preferences from Normal Setting
	$('#seller-preference').submit(function(e) {
		if(styles.length > 3){
			$('#edit-info-title').html("Purchase Preferences");
			$('#edit-info-text').html("You can choose only up to 3 different styles.");
		    $('#modal_edit_info').foundation('open');
		}
		else if(brands.length > 5){
			$('#edit-info-title').html("Purchase Preferences");
			$('#edit-info-text').html("You can choose only up to 5 different brands.");
		    $('#modal_edit_info').foundation('open');
		}
		else{
			var preferenceData = {
		        'seller_id'       : <?= $seller_id ?>,
		        'body_styles'     : styles,
		        'brands'          : brands
		    };

		    $.ajax({
		        type        : "POST", 
		        url         : "<?= $post_seller_preference ?>", 
		        data        : preferenceData,
		        dataType    : 'json',
		        encode      : true
		    }).done(function(data) { 
		    	$('#submit-info-title').html("Purchase Preferences");
				$('#submit-info-text').html("Your Car's Preferences have been updated.");
			    $('#modal_submit').foundation('open');
			    updated = true;
		    }).fail(function(data) {
			    $('#submit-info-title').html("Purchase Preferences");
				$('#submit-info-text').html("Error on updating your car's preferences.");
			    $('#modal_submit').foundation('open');
			}).always(function(data) {
		    	console.log(data); 
			});
	 	}

	    e.preventDefault();
	});

	//Disabling Keypress ENTER to submit
	$('#seller-preference').on('keyup keypress', function(e) {
	  var keyCode = e.keyCode || e.which;
	  if (keyCode === 13) { 
	    e.preventDefault();
	    return false;
	  }
	});

	$('.add-single-brand').on("click", function( e ) {
		var a_brand = $('input[name="add_single_brand"]').val();
		if(!a_brand){
			$('#modal_pickone').foundation('open');
			//$('#modal_pickone').html(pick_one).foundation('open');
		}
		else{
			var index = brands.indexOf(a_brand);
			// if (index < 0) {
				// SPECIAL CASE IF USER CAN ADD MORE THAN ONE BRAND USING COMMA
			   	// var array_brand = a_brand.replace("/\ /g","").split(','); 
			   	// if (array_brand.length >= 1) {
			   		// $.each(array_brand, function (index, a_brand) {
							// brands.push(toCamelCase(a_brand));
			 			console.log(brands); 
					   	index = br_ref.indexOf(a_brand);
					   	if (index < 0) {
					   	   a_brand        = a_brand.trim();
					   	   a_brand_class  = a_brand.replace(/\ /g,"-");
						   var html_brand = '<a id="btn-brand-' + a_brand_class.toLowerCase() + '" class="button all-brand" data-brand="' + toCamelCase(a_brand)  +'">' + toCamelCase(a_brand) +'</a>';
						   $(html_brand).insertAfter('#brand-label');
						   var a_brand_id = "#btn-brand-" + a_brand_class.toLowerCase();
					   	   $(a_brand_id).css('margin-right', '3px');
					   	   //POST single brand
					   	   var brand_data = {
						        'user_id'   : <?= $seller_id ?>,
						        'user_role' : 'seller',
						        'brand'     : toCamelCase(a_brand)
						    };
					   	   $.ajax({
						        type        : "POST", 
						        url         : "<?= $post_single_brand ?>", 
						        data        : brand_data,
						        dataType    : 'json',
						        encode      : true
						    }).done(function(data) { 
						    	$('#brand-info-title').html("Purchase Preferences");
								$('#brand-info-text').html("A new brand have been added.");
							    $('#modal_add_brand').foundation('open');
							    updated = true;
						    }).fail(function(data) {
							    $('#brand-info-title').html("Purchase Preferences");
								$('#brand-info-text').html("Error on adding a new brand.");
							    $('#modal_add_brand').foundation('open');
							}).always(function(data) {
						    	console.log(data); 
							});
					   	}else{
					   		a_brand        = a_brand.trim();
					   	   	a_brand_class  = a_brand.replace(/\ /g,"-").toLowerCase();
					   	   	var a_brand_id = $("#btn-brand-" + a_brand_class);
					   	   	// $(a_brand_id).addClass('green');
					   		// brands.push(toCamelCase(a_brand));
					   		$('#brand-info-title').html("Purchase Preferences");
							$('#brand-info-text').html("A brand already added.");
						    $('#modal_add_brand').foundation('open');
					   	}
			   		// });
			   	// }
			// }
			
		}
		$('input[name="add_single_brand"]').val('');
	    e.preventDefault();
	});

	function toCamelCase(str) {
		var camelized = "";
		var splitted  = str.split(" ");
		var splitted_camelized;
		for (i = 0; i < splitted.length; i++) { 
			splitted_camelized = splitted[i].toLowerCase().replace(/(?:(^.)|(\s+.))/g, function(match) {
		        return match.charAt(match.length-1).toUpperCase();
		    });
			
		    if(i == splitted.length - 1)
		    	camelized = camelized + splitted_camelized + " ";
		    else
		    	camelized = camelized + splitted_camelized + " ";
		}

	    return camelized.trim();
	}

	$( document ).on( "click", '.body_style', function( e ) {
	  var style_classes = $(this).attr('class');
	  var style = $(this).data('style');
	  var pattern = /is-active/i;
	  var found = style_classes.match( pattern );
	  if(!found){
	  	if(styles.length >= 3){
			$('#edit-info-title').html("Purchase Preferences");
			$('#edit-info-text').html("You can choose only up to 3 different body styles.");
		    $('#modal_edit_info').foundation('open');
		}else{
	  		$(this).addClass('is-active');
	  		styles.push(style);
	  	}
	  }else{
	  	$(this).removeClass('is-active');
	  	var index = styles.indexOf(style);
		if (index >= 0) {
		   styles.splice( index, 1 );
		}
	  }
	  console.log(styles);
	});

	$( document ).on( "click", '.all-brand', function( e ) {
	  var brand_classes = $(this).attr('class');
	  var brand = $(this).data('brand');
	  var pattern = /green/i;
	  var found = brand_classes.match( pattern );
	  if(!found){
	  	if(brands.length >= 5){
			$('#edit-info-title').html("Purchase Preferences");
			$('#edit-info-text').html("You can choose only up to 5 different brands.");
		    $('#modal_edit_info').foundation('open');
		}else{
	  		$(this).addClass('green');
	  		brands.push(brand);
	  	}
	  }else{
	  	$(this).removeClass('green');
	 	var index = brands.indexOf(brand);
		if (index >= 0) {
		   brands.splice( index, 1 );
		}
	  }
	  console.log(brands);
	});

	$(document).on('click', '[rel="button-modal-info"]', function() {
		$('#modal_pickone').foundation('close');
		$('#modal_edit_info').foundation('close');
	});
	$(document).on('click', '[rel="button-modal-confirm-ok"]', function() {
		$('#modal_active_auction').foundation('close');
	});
	$(document).on('click', '[rel="button-modal-add-brand"]', function() {
		$('#modal_add_brand').foundation('close');
	});
	$(document).on('click', '[rel="button-submit-info"]', function() {
		$('#modal_pickone').foundation('close');
		$('#modal_submit').foundation('close');
		if(updated==true){ window.location = "<?= site_url('seller'); ?>"; }
	});
</script>
<script>
(function(){
  "use strict";

  $('.carousel').slick({
	  arrows: false,
	  dots: true,
	  infinite:false});
})();
</script>