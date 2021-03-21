<?php
/**
 * Luna Core
 *
 * @package Luna_core
 */

?>
<div class="wrap">
	<?php settings_errors(); ?>
	<form method="POST" action="options.php">
		<?php
		settings_fields( 'luna_options_groups' );
		do_settings_sections( 'luna_settings' );
		submit_button();
		?>
	</form>
</div>

