<?php
/**
 * Luxeritas WordPress Theme - free/libre wordpress platform
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * @copyright Copyright (C) 2015 Thought is free.
 * @license http://www.gnu.org/licenses/gpl-2.0.html GPL v2 or later
 * @author LunaNuko
 * @link https://thk.kanzae.net/
 * @translators rakeem( http://rakeem.jp/ )
 */

?>
<form id="luxe-customize" method="post" action="">
<?php
settings_fields( 'shortcode_options' );
?>
<ul>
<li>
<p class="control-title"><?php echo __( 'Add button to the Post Editing Screen', 'luxeritas' ); ?></p>
<p class="checkbox">
<input type="checkbox" value="" name="add_post_shortcode_button_1"<?php thk_value_check( 'add_post_shortcode_button_1', 'checkbox' ); ?> />
<?php echo __( 'Add a button next to the Add Media button', 'luxeritas' ); ?>
</p>
<p class="checkbox">
<input type="checkbox" value="" name="add_post_shortcode_button_2"<?php thk_value_check( 'add_post_shortcode_button_2', 'checkbox' ); ?> />
<?php echo __( 'Add a button to the Post Editor Toolbar', 'luxeritas' ); ?>
</p>
</li>
</li>
</ul>
<?php
submit_button( __( 'Save Changes', 'luxeritas' ), 'primary', 'shortcode_options', true, array() );
?>
</form>
