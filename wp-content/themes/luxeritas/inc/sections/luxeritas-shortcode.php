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

settings_fields( 'shortcode_sample' );

wp_enqueue_style( 'wp-color-picker' );
wp_enqueue_script( 'wp-color-picker' );

$sc_mods = get_phrase_list( 'shortcode', false, true );
?>
<script>
jQuery(document).ready(function($) {
	$('.thk-color-picker').wpColorPicker();
	$('.wp-color-result').on('click', function() {
		$("#save").prop("disabled", false);
	});
});
</script>
<ul>
<li>
<p class="control-title"><?php echo __( 'Syntax Highlighter', 'luxeritas' ); ?></p>
<p class="checkbox">
<table class="highlighter-table">
<tbody>
<tr>
<td colspan="2"><input type="checkbox" value="" name="shortcode_highlight_markup_sample"<?php echo isset( $sc_mods['highlight_markup'] ) ? ' checked disabled' : ''; ?> /> Markup ( HTML / XHTML )</td>
</tr>
<tr>
<td><input type="checkbox" value="" name="shortcode_highlight_css_sample"<?php echo isset( $sc_mods['highlight_css'] ) ? ' checked disabled' : ''; ?> /> CSS</td>
<td><input type="checkbox" value="" name="shortcode_highlight_sass_sample"<?php echo isset( $sc_mods['highlight_sass'] ) ? ' checked disabled' : ''; ?> /> Sass</td>
</tr>
<tr>
<td><input type="checkbox" value="" name="shortcode_highlight_clike_sample"<?php echo isset( $sc_mods['highlight_clike'] ) ? ' checked disabled' : ''; ?> /> CLike</td>
<td><input type="checkbox" value="" name="shortcode_highlight_c_sample"<?php echo isset( $sc_mods['highlight_c'] ) ? ' checked disabled' : ''; ?> /> C</td>
</tr>
<tr>
<td><input type="checkbox" value="" name="shortcode_highlight_cpp_sample"<?php echo isset( $sc_mods['highlight_cpp'] ) ? ' checked disabled' : ''; ?> /> C++</td>
<td><input type="checkbox" value="" name="shortcode_highlight_csharp_sample"<?php echo isset( $sc_mods['highlight_csharp'] ) ? ' checked disabled' : ''; ?> /> C#</td>
</tr>
<tr>
<td><input type="checkbox" value="" name="shortcode_highlight_aspnet_sample"<?php echo isset( $sc_mods['highlight_aspnet'] ) ? ' checked disabled' : ''; ?> /> ASP.NET ( C# )</td>
<td style="padding-right:15px"><input type="checkbox" value="" name="shortcode_highlight_autohotkey_sample"<?php echo isset( $sc_mods['highlight_autohotkey'] ) ? ' checked disabled' : ''; ?> /> autoHotkey</td>
</tr>
<tr>
<td><input type="checkbox" value="" name="shortcode_highlight_java_sample"<?php echo isset( $sc_mods['highlight_java'] ) ? ' checked disabled' : ''; ?> /> Java</td>
<td><input type="checkbox" value="" name="shortcode_highlight_javascript_sample"<?php echo isset( $sc_mods['highlight_javascript'] ) ? ' checked disabled' : ''; ?> /> Javascript</td>
</tr>
<tr>
<td><input type="checkbox" value="" name="shortcode_highlight_php_sample"<?php echo isset( $sc_mods['highlight_php'] ) ? ' checked disabled' : ''; ?> /> PHP</td>
<td><input type="checkbox" value="" name="shortcode_highlight_perl_sample"<?php echo isset( $sc_mods['highlight_perl'] ) ? ' checked disabled' : ''; ?> /> Perl</td>
</tr>
<tr>
<td><input type="checkbox" value="" name="shortcode_highlight_python_sample"<?php echo isset( $sc_mods['highlight_python'] ) ? ' checked disabled' : ''; ?> /> Python</td>
<td><input type="checkbox" value="" name="shortcode_highlight_ruby_sample"<?php echo isset( $sc_mods['highlight_ruby'] ) ? ' checked disabled' : ''; ?> /> Ruby</td>
</tr>
<tr>
<td><input type="checkbox" value="" name="shortcode_highlight_basic_sample"<?php echo isset( $sc_mods['highlight_basic'] ) ? ' checked disabled' : ''; ?> /> BASIC</td>
<td><input type="checkbox" value="" name="shortcode_highlight_vbnet_sample"<?php echo isset( $sc_mods['highlight_vbnet'] ) ? ' checked disabled' : ''; ?> /> VB.NET</td>
</tr>
<tr>
<td><input type="checkbox" value="" name="shortcode_highlight_sql_sample"<?php echo isset( $sc_mods['highlight_sql'] ) ? ' checked disabled' : ''; ?> /> SQL</td>
<td><input type="checkbox" value="" name="shortcode_highlight_plsql_sample"<?php echo isset( $sc_mods['highlight_plsql'] ) ? ' checked disabled' : ''; ?> /> PL/SQL</td>
</tr>
<tr>
<td style="padding-right:15px"><input type="checkbox" value="" name="shortcode_highlight_bash_sample"<?php echo isset( $sc_mods['highlight_bash'] ) ? ' checked disabled' : ''; ?> /> Bash</td>
<td style="padding-right:15px"><input type="checkbox" value="" name="shortcode_highlight_vim_sample"<?php echo isset( $sc_mods['highlight_vim'] ) ? ' checked disabled' : ''; ?> /> Vim</td>
</tr>
<tr>
<td style="padding-right:15px"><input type="checkbox" value="" name="shortcode_highlight_apacheconf_sample"<?php echo isset( $sc_mods['highlight_apacheconf'] ) ? ' checked disabled' : ''; ?> /> Apache Config</td>
<td style="padding-right:15px"><input type="checkbox" value="" name="shortcode_highlight_nginx_sample"<?php echo isset( $sc_mods['highlight_nginx'] ) ? ' checked disabled' : ''; ?> /> nginx</td>
</tr>
<tr>
<td style="padding-right:15px"><input type="checkbox" value="" name="shortcode_highlight_diff_sample"<?php echo isset( $sc_mods['highlight_diff'] ) ? ' checked disabled' : ''; ?> /> Diff</td>
<td style="padding-right:15px"><input type="checkbox" value="" name="shortcode_highlight_git_sample"<?php echo isset( $sc_mods['highlight_git'] ) ? ' checked disabled' : ''; ?> /> Git</td>
</tr>
</tbody>
</table>


<p>
CSS Theme:&nbsp;
<select name="highlighter_css">
<option value="none"<?php thk_value_check( 'highlighter_css', 'select', 'solarized_light' ); ?>><?php echo __( 'None', 'luxeritas' ); ?></option>
<option value="default"<?php thk_value_check( 'highlighter_css', 'select', 'default' ); ?>>Default</option>
<option value="dark"<?php thk_value_check( 'highlighter_css', 'select', 'dark' ); ?>>Dark</option>
<option value="okaidia"<?php thk_value_check( 'highlighter_css', 'select', 'okaidia' ); ?>>Okaidia</option>
<option value="twilight"<?php thk_value_check( 'highlighter_css', 'select', 'twilight' ); ?>>Twilight</option>
<option value="coy"<?php thk_value_check( 'highlighter_css', 'select', 'coy' ); ?>>Coy</option>
<option value="solarized-light"<?php thk_value_check( 'highlighter_css', 'select', 'solarized-light' ); ?>>Solarized Light</option>
<option value="tomorrow-night"<?php thk_value_check( 'highlighter_css', 'select', 'tomorrow-night' ); ?>>Tomorrow Night</option>
</select>
</p>

</p>
<p class="control-title"><?php echo __( 'Speech balloon', 'luxeritas' ); ?></p>
<p class="checkbox">
<input type="checkbox" value="" name="shortcode_balloon_left_sample"<?php echo isset( $sc_mods['balloon_left'] ) ? ' checked disabled' : ''; ?> />
<?php echo __( 'Speech balloon', 'luxeritas' ) . ' ( ' . __( 'Left', 'luxeritas' ) . ' ) '; ?>
</p>

<table class="balloon-regist-table">
<colgroup span="1" style="width:120px" />
<tbody>
<tr>
<th>* <?php echo __( 'Image', 'luxeritas' ); ?> URL : </th>
<td>
<?php
if( isset( $sc_mods['balloon_left'] ) ) {
?>
<input type="text" id="sbl_image_url" name="sbl_image_url" value="" placeholder="<?php echo __( 'Registered', 'luxeritas' ); ?>" readonly />
<?php
}
else {
?>
<input type="text" id="sbl_image_url" name="sbl_image_url" value="<?php echo TURI . '/images/white-cat.png'; ?>" />
<?php
}
?>
</td>
</tr>
<tr>
<th>* <?php echo __( 'Caption', 'luxeritas' ); ?> : </th>
<td>
<?php
if( isset( $sc_mods['balloon_left'] ) ) {
?>
<input type="text" id="sbl_caption" name="sbl_caption" value="" placeholder="<?php echo __( 'Registered', 'luxeritas' ); ?>" readonly />
<?php
}
else {
?>
<input type="text" id="sbl_caption" name="sbl_caption" value="<?php echo __( 'Left caption', 'luxeritas' ); ?>" />
<?php
}
?>
</td>
</tr>
<tr>
<th>* <?php echo __( 'Text color', 'luxeritas' ); ?> : </td>
<td><input class="thk-color-picker" type="text" id="balloon_left_color" name="balloon_left_color" value="<?php thk_value_check( 'balloon_left_color', 'text' ); ?>" /></th>
</tr>
<tr>
<th>* <?php echo __( 'Background color', 'luxeritas' ); ?> : </th>
<td><input class="thk-color-picker" type="text" id="balloon_left_bg_color" name="balloon_left_bg_color" value="<?php thk_value_check( 'balloon_left_bg_color', 'text' ); ?>" /></td>
</tr>
</tbody>
</table>

<p>
<input type="checkbox" value="" name="shortcode_balloon_right_sample"<?php echo isset( $sc_mods['balloon_right'] ) ? ' checked disabled' : ''; ?> />
<?php echo __( 'Speech balloon', 'luxeritas' ) . ' ( ' . __( 'Right', 'luxeritas' ) . ' ) '; ?>
</p>

<table class="balloon-regist-table">
<colgroup span="1" style="width:120px" />
<tbody>
<tr>
<th>* <?php echo __( 'Image', 'luxeritas' ); ?> URL : </th>
<td>
<?php
if( isset( $sc_mods['balloon_right'] ) ) {
?>
<input type="text" id="sbr_image_url" name="sbr_image_url" value="" placeholder="<?php echo __( 'Registered', 'luxeritas' ); ?>" readonly />
<?php
}
else {
?>
<input type="text" id="sbr_image_url" name="sbr_image_url" value="<?php echo TURI . '/images/black-cat.png'; ?>" />
<?php
}
?>
</td>
</tr>
<tr>
<th>* <?php echo __( 'Caption', 'luxeritas' ); ?> : </th>
<td>
<?php
if( isset( $sc_mods['balloon_right'] ) ) {
?>
<input type="text" id="sbr_caption" name="sbr_caption" value="" placeholder="<?php echo __( 'Registered', 'luxeritas' ); ?>" readonly />
<?php
}
else {
?>
<input type="text" id="sbr_caption" name="sbr_caption" value="<?php echo __( 'Right caption', 'luxeritas' ); ?>" />
<?php
}
?>
</td>
</tr>
<tr>
<th>* <?php echo __( 'Text color', 'luxeritas' ); ?> : </td>
<td><input class="thk-color-picker" type="text" id="balloon_right_color" name="balloon_right_color" value="<?php thk_value_check( 'balloon_right_color', 'text' ); ?>" /></th>
</tr>
<tr>
<th>* <?php echo __( 'Background color', 'luxeritas' ); ?> : </th>
<td><input class="thk-color-picker" type="text" id="balloon_right_bg_color" name="balloon_right_bg_color" value="<?php thk_value_check( 'balloon_right_bg_color', 'text' ); ?>" /></td>
</tr>
<tr>
<th>* <?php echo __( 'Max width', 'luxeritas' ); ?> : </th>
<td><input type="number" id="balloon_max_width" name="balloon_max_width" value="<?php thk_value_check( 'balloon_max_width', 'number' ); ?>" style="width:100%;max-width:80px" /> px ( <?php echo __( 'When input is 0, 100%', 'luxeritas' ); ?> )</td>
</tr>
</tbody>
</table>

</li>
</ul>
<script>
</script>
