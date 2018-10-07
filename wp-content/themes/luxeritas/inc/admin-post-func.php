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

require( INC . 'og-img-admin.php' );
require( INC . 'post-update-level.php');
require( INC . 'post-amp.php' );
require_once( INC . 'thumbnail-images.php' );
thk_custom_image_sizes::custom_image_sizes();

add_filter( 'jpeg_quality', function( $arg ) { return 100; } );

/*---------------------------------------------------------------------------
 * after_setup_theme
 *---------------------------------------------------------------------------*/
// 定型文登録時と挿入時のポップアップ
if( isset( $_POST['fp_popup_nonce'] ) ) {
	add_action( 'after_setup_theme', function() {
		// nonce チェック
		if( wp_verify_nonce( $_POST['fp_popup_nonce'], 'phrase_popup' ) ) {
			add_action( 'wp_ajax_thk_phrase_regist', function() {
				$name = trim( esc_attr( stripslashes( $_POST['name'] ) ) );
				$file_name = substr( $name, strpos( $name, '-' ), strlen( $name ) );
				$file_name = strlen( $file_name ) . '-' . md5( $file_name );
				$code_file = SPATH . DSEP . 'phrases' . DSEP . $file_name . '.txt';
				require_once( INC . 'optimize.php' );
				global $wp_filesystem;
				$filesystem = new thk_filesystem();
				if( $filesystem->init_filesystem( site_url() ) === false ) return false;
				echo $wp_filesystem->get_contents( $code_file );
				exit;
			});
		}
	});
}

/*---------------------------------------------------------------------------
 * admin init
 *---------------------------------------------------------------------------*/
add_action( 'admin_init', function() {
	require_once( INC . 'const.php' );
}, 9 );

/*---------------------------------------------------------------------------
 * admin head
 *---------------------------------------------------------------------------*/
add_action( 'admin_head', function() {
	global $luxe;

	// 投稿画面のボタン挿入
	if( stripos( $_SERVER['REQUEST_URI'], 'wp-admin/post' ) !== false ) {
		require_once( INC . 'thk-post-style.php' );

		// ブログカードの挿入ボタン
		if( isset( $luxe['blogcard_enable'] ) ) {
			require( INC . 'blogcard-post-func.php' );
		}

		// 定型文の挿入ボタン
		require( INC . 'phrase-post.php' );

		// ショートコードの挿入ボタン
		require( INC . 'shortcode-post.php' );

		// TinyMCE init
		if( current_user_can( 'edit_posts' ) === true && get_user_option( 'rich_editing' ) === 'true' ) {
			require( INC . 'tinymce-before-init.php' );
		}
	}

	if( current_user_can( 'edit_theme_options' ) === false ) {
		$admin_inline_styles = '';
		$admin_inline_styles .= thk_add_admin_inline_css( TPATH . '/css/admin-menu.css' );
		$admin_inline_styles .= thk_add_admin_inline_css( TPATH . '/css/jquery-ui.min.css' );
		echo '<style>', thk_simple_css_minify( $admin_inline_styles ), '</style>';
	}
}, 100 );

/*---------------------------------------------------------------------------
 * print scripts
 *---------------------------------------------------------------------------*/
/* jquery-ui script */
add_action( 'admin_print_scripts', function() {
	wp_enqueue_script( 'thk-jquery-ui-script', TURI . '/js/jquery-ui.min.js', array( 'jquery' ), false, false );
}, 99 );

/*---------------------------------------------------------------------------
 * 管理画面で使う CSS の読み込み
 *---------------------------------------------------------------------------*/
if( function_exists( 'thk_add_admin_inline_css' ) === false ):
function thk_add_admin_inline_css( $css_path ) {
	if( file_exists( $css_path ) === true ) {
		ob_start();
		require( $css_path );
		$css = ob_get_clean();
		return $css;
	}
	return '';
}
endif;
