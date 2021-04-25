<?php
/**
 * Luna Core
 *
 * @package Luna_core
 */
?>
<div class="wrap">
	<?php settings_errors(); ?>

	<ul class="nav nav-tabs">
		<li class="active">
			<a href="#tab-1">Custom Posts</a>
		</li>
		<li>
			<a href="#tab-2">Add Custom Post Type</a>
		</li>
		<li>
			<a href="#tab-3">Export</a>
		</li>
	</ul>

	<div class="tab-content">
		<div id="tab-1" class="tab-pane active">
			<h3>Manage your Custom Post Types.</h3>
			<?php
			$post_types = get_option( 'luna_settings_cpt', array() );

			echo '<table class="cpt-table"><tr><th>ID</th><th>Singular Name</th><th>Plural Name</th><th class="text-center">Public</th><th class="text-center">Archive</th><th class="text-center">Actions</th></tr>';

			foreach ( $post_types as $post_type ) {
				$public  = isset( $post_type['public'] ) ? 'TRUE' : 'FALSE';
				$archive = isset( $post_type['has_archive'] ) ? 'TRUE' : 'FALSE';

				echo "<tr><td>{$post_type['post_type']}</td><td>{$post_type['singular_name']}</td><td>{$post_type['plural_name']}</td><td class=\"text-center\">{$public}</td><td class=\"text-center\">{$archive}</td><td class=\"text-center\">";

				echo '<form method="post" action="" class="inline-block">';
				echo '<input type="hidden" name="edit_post" value="' . $post_type['post_type'] . '">';
				submit_button( 'Edit', 'primary small', 'submit', false );
				echo '</form> ';

				echo '<form method="post" action="options.php" class="inline-block">';
				settings_fields( 'alecaddd_plugin_cpt_settings' );
				echo '<input type="hidden" name="remove" value="' . $post_type['post_type'] . '">';
				submit_button(
					'Delete',
					'delete small',
					'submit',
					false,
					array(
						'onclick' => 'return confirm("Are you sure you want to delete this Custom Post Type? The data associated with it will not be deleted.");',
					)
				);
				echo '</form></td></tr>';
			}

			echo '</table>';
			?>
		</div>
		<div id="tab-2" class="tab-pane">
			<form method="POST" action="options.php">
				<?php
				settings_fields( 'core_settings_cpt' );
				do_settings_sections( 'luna_cpt' );
				submit_button();
				?>
			</form>
		</div>
		<div id="tab-3" class="tab-pane">
			<h3>Export your Custom Post Type.</h3>
		</div>

	</div>
</div>

