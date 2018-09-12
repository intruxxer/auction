<div class="columns small-12">
	<div class="row">
		<div class="columns small-4">
			<aside>
				<div class="profile-picture">
					<img src="<?= $dealer_avatar;?>">
				</div>
				
				<p><?= $dealer_name;;?></p>
				
				<div class="carousel">
					<div class="item">
						<img src="<?= $auction->car_details->multimedia[0] ?>">
					</div>
				</div>
				
				<h4><?= $auction->item_title; ?></h4>
				
				<p><?= $auction->car_details->doors.' Doors '.$auction->car_details->body_style; ?></p>
				
				<ul class="spec">
					<li class="fuel"><?php if($auction->car_details->fuel_type){ echo ucwords($auction->car_details->fuel_type); }
							else{ echo 'N/A'; } ?>
					</li>
					
					<li class="odometer"><?php if($auction->car_details->mileage) { echo number_format($auction->car_details->mileage). ' '
					.ucwords($auction->car_details->mileage_type); } 
							else{ echo '0 Mi'; } ?>
					</li>
					
					<li class="transmission"><?php if($auction->car_details->transmission) { echo ucwords(strtolower($auction->car_details->transmission)); }
						else{ echo 'N/A'; } ?>
					</li>
					
					<li class="capacity"><?php echo '0 Person';  ?></li>
				</ul>
				
				<h4>Description</h4>
			
				<p><small><?php if($auction->description) { echo $auction->description; }
						else{ echo 'N/A'; } ?></small></p>
			</aside>
		</div>
		
		<div class="columns small-8">
		<?php if($any_chat == false) { ?>
			<div class="chat">
				<h2 style="text-align: center;">No message for this auction.</h2>
			</div>
		<?php } else { ?>
			<div class="chat">
				<div class="container">
					<?php for($i=0; $i<count($chat); $i++) { 
					if($chat[$i]->sender_id != $seller_id) { ?>
							<div class="item them">
								<div class="profile-picture">
									<img src="<?= $chat[$i]->sender_avatar;?>">
								</div>
								
								<p><?= $chat[$i]->content; ?></p>

							</div>
							<p class="timestamp" style="text-align: left;"><?= date('H:i:s',strtotime($chat[$i]->datetime)); ?></p>
						<?php } else { ?>
							<div class="item you">
								<p><?= $chat[$i]->content; ?></p>
							</div>
							<p class="timestamp" style="text-align: right;"><?= date('H:i:s',strtotime($chat[$i]->datetime)); ?></p>
						<?php }
						} ?>
				</div>
			</div>
			<form id="chat-form" method="post">
				<div class="row">
					<div class="columns small-12">
						<div class="input-group">
							<textarea name="chat_message" class="input-group-field chat-message" type="text" placeholder="Write new message"></textarea>
							<div class="input-group-button">
								&nbsp;<button id="send-btn" class="button orange">Send</button>
							</div>
						</div>
					</div>
				</div>
			</form>
		<?php } ?>
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
<script type="text/javascript">
	$('#chat-form').on("submit", function(e) {
		e.preventDefault();
		var content = $('[name="chat_message"]').val();

		var formData = {
			"seller_id"     : <?= $seller_id ?>,
			"auction_id"  	: <?= $auction->auction_id; ?>,
			"message_id"  	: <?= $message_id; ?>,
			"content"  		: content
		}; 
		console.log(formData);

		var answer = '<div class="item you"><p>{resp_answer}</p></div><p class="timestamp" style="text-align: right;">{resp_time}</p>'
		$.ajax({
		        type        : 'POST', 
		        url         : '<?= $send_message_url; ?>', 
		        data        : formData,
		        dataType    : 'json',
		        encode      : true
		    }).done(function(resp) { 
		    	answer = answer.replace('{resp_answer}', resp.data.content);
		    	answer = answer.replace('{resp_time}', resp.data.time);
		    	$('.chat').append(answer);
		    	$('#edit-info-title').html("Auction Message");
				$('#edit-info-text').html("Your message has been sent.");
			    $('#modal_edit_info').foundation('open');
			    $('[name="chat_message"]').val("");
		    }).fail(function(resp) {
			    $('#edit-info-title').html("Auction Message");
				$('#edit-info-text').html("Cannot send a message.");
			    $('#modal_edit_info').foundation('open');
			}).always(function(resp) {
		    	console.log(resp); 
		});
	});

	$('#chat-form').on('keyup keypress', function(e) {
	  var keyCode = e.keyCode || e.which;
	  if (keyCode === 13) { 
	    e.preventDefault();
	    return false;
	  }
	});

	$(document).on('click', '[rel="button-modal-info"]', function() {
		$('#modal_edit_info').foundation('close');
	});
</script>