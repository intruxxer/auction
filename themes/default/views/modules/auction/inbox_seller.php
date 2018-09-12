<div class="columns small-12">
	<div class="row">
		<div class="columns small-12">
			<div class="messages">
				<p class="notification">You have <?= $unread ?> unread message(s).</p>
				<?php foreach ($conversations as $idx => $conv) { ?>
				<div class="item" data-message="<?= $conv->message_id ?>" data-auction="<?= $conv->auction_id ?>">
					<div class="profile-picture">
						<img src="<?= $conv->dealer_avatar ?>">
					</div>
					<div class="text">
						<a href="<?= site_url('auction/'.$conv->auction_id.'/notification/seller/'.$conv->message_id) ?>">
						<p class="date">
							<?php if($conv->unread_messages > 0) { ?>
							<span class="badge"><?= $conv->unread_messages ?></span> message(s) on
							<?php } ?>
							<?= date('g:i a,  j F Y', strtotime($conv->datetime)) ?>
						</p>
						<p>
							<?= $conv->dealer_name ?><br>
							<small><?= $conv->content ?></small>
						</p>
						</a>
					</div>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>