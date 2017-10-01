<?php
/**
 * Header Alert Message.
 *
 * @package vslmd
 */

$options = get_option('vslmd_options');

$alert_message_text = $options['alert_message_text'];

?>

<!-- ******************* Structure ******************* -->

<div class="alert-message alert alert-dismissible">
	<div class="alert-message-content">
		<div class="container">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<?php if(!empty($alert_message_text)){ echo $alert_message_text; } ?>
		</div>
	</div>
</div>
