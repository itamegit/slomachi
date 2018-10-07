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

/*---------------------------------------------------------------------------
 * wp_head に追加するヘッダー (CSS や Javascrpt の追加など)
 *---------------------------------------------------------------------------*/
add_action( 'wp_head', function() use( $luxe ) {
	global $luxe, $awesome;
	require_once( INC . 'web-font.php' );
	require_once( INC . 'analytics.php' );

	if( isset( $luxe['amp'] ) ) {
		$id = get_queried_object_id();
		define( 'THK_AMP_ORG_ID', $id );
		define( 'THK_AMP_ORG_URL', wp_get_canonical_url( $id ) );
	}
	$_is_singular = is_singular();
	$_is_customize_preview = is_customize_preview();

	echo apply_filters( 'thk_prefetch', '' );

	if( $_is_singular === true && isset( $luxe['amp_enable'] ) && !isset( $luxe['amp'] ) ) {
		$amplink = thk_get_amp_permalink( get_queried_object_id() );
?>
<link rel="amphtml" href="<?php echo esc_url( $amplink ); ?>">
<?php
	}

	if( isset( $luxe['canonical_enable'] ) ) {
		if( $_is_singular === true ) {
			rel_canonical();
		}
		else {
			thk_rel_canonical();
		}
	}

	wp_shortlink_wp_head();

	if( isset( $luxe['next_prev_enable'] ) ) {
		thk_rel_next_prev();
	}
?>
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php
	if( isset( $luxe['author_visible'] ) && $_is_singular === true ) {
		if( $luxe['author_page_type'] === 'auth' ) {
			$auth = get_users();
?>
<link rel="author" href="<?php echo get_author_posts_url( $auth[0]->ID ); ?>" />
<?php
		}
		else {
?>
<link rel="author" href="<?php echo isset( $luxe['thk_author_url'] ) ? $luxe['thk_author_url'] : THK_HOME_URL; ?>" />
<?php
		}
	}
	// Manifest
	if( isset( $luxe['amp'] ) && is_ssl() === false ) {
	}
	else {
		if( isset( $luxe['pwa_manifest'] ) && file_exists( THK_HOME_PATH . 'luxe-manifest.json' ) === true ) {
?>
<link rel="manifest" href="<?php echo THK_HOME_URL; ?>luxe-manifest.json" />
<?php
		}
	}
	// RSS Feed
	if( isset( $luxe['rss_feed_enable'] ) ) {
?>
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<?php
	}
	// Atom Feed
	if( isset( $luxe['atom_feed_enable'] ) ) {
?>
<link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name'); ?> Atom Feed" href="<?php bloginfo('atom_url'); ?>" />
<?php
	}

	if( !isset( $luxe['amp'] ) ) {
		// アクセス解析追加用( Headタグに設定されてる場合 )
		// ※ AMP の時はヘッダー内に置けないので body 直下配置
		$analytics = new thk_analytics();
		echo $analytics->analytics( 'add-analytics-head.php' );

		// Preload Font files
		thk_preload_web_font( $luxe['font_alphabet'] );
		thk_preload_web_font( $luxe['font_japanese'] );

		if( $luxe['awesome_load_css'] === 'sync' && $luxe['awesome_load_file'] !== 'cdn' && $_is_customize_preview === false ) {
			$fonts_path = ( TDEL !== SDEL && $luxe['child_css_compress'] === 'bind' ) ? SDEL : TDEL;
			if( $awesome === 4 ) {
?>
<link rel="preload" as="font" type="font/woff2" href="<?php echo $fonts_path; ?>/fonts/fontawesome-webfont.woff2" crossorigin />
<?php
			}
			else {
?>
<link rel="preload" as="font" type="font/woff2" href="<?php echo $fonts_path; ?>/webfonts/fa-brands-400.woff2" crossorigin />
<link rel="preload" as="font" type="font/woff2" href="<?php echo $fonts_path; ?>/webfonts/fa-regular-400.woff2" crossorigin />
<link rel="preload" as="font" type="font/woff2" href="<?php echo $fonts_path; ?>/webfonts/fa-solid-900.woff2" crossorigin />
<?php
			}
?>
<link rel="preload" as="font" type="font/woff" href="<?php echo $fonts_path; ?>/fonts/icomoon/fonts/icomoon.woff" crossorigin />
<?php
		}
	}

	// カルーセルスライダーが使われてたらスライダー用の css を preload
	/*
	if( is_active_widget( false, false, 'thk_swiper_widget', true ) !== false ) {
		$swiper_css_file = $awesome === 4 ? 'thk-swiper.min.css' : 'thk-swiper-5.min.css';
		$swiper_css = array( TPATH . DSEP . 'styles' . DSEP . $swiper_css_file, TDEL . '/styles/' . $swiper_css_file );
		$swiper_css[1] .= file_exists( $swiper_css[0] ) === true ? '?v=' . filemtime( $swiper_css[0] ) : '?v=' . $_SERVER['REQUEST_TIME'];
?>
<link rel="preload" as="style" href="<?php echo $swiper_css[1]; ?>" />
<?php
	}
	*/

	// Site Icon
	if( has_site_icon() === false ) {
		// favicon.ico
		if( file_exists( SPATH . DSEP . 'images' . DSEP . 'favicon.ico' ) ) {
?>
<link rel="icon" href="<?php echo SURI; ?>/images/favicon.ico" />
<?php
		}
		else {
?>
<link rel="icon" href="<?php echo TURI; ?>/images/favicon.ico" />
<?php
		}

		// Apple Touch icon
		if( file_exists( SPATH . DSEP . 'images' . DSEP . 'apple-touch-icon-precomposed.png' ) ) {
?>
<link rel="apple-touch-icon-precomposed" href="<?php echo SURI; ?>/images/apple-touch-icon-precomposed.png" />
<?php
		}
		else {
?>
<link rel="apple-touch-icon-precomposed" href="<?php echo TURI; ?>/images/apple-touch-icon-precomposed.png" />
<?php
		}
	}

	// Amp 用 ＆ カスタマイズプレビュー用の Web font
	if( isset( $luxe['amp'] ) || $_is_customize_preview === true ) {
		if( file_exists( TPATH . DSEP . 'webfonts' . DSEP . 'd' . DSEP . $luxe['font_alphabet'] ) ) {
?>
<link rel="stylesheet" href="<?php echo Web_Font::$alphabet[$luxe['font_alphabet']][1]; ?>" />
<?php
		}
		if( file_exists( TPATH . DSEP . 'webfonts' . DSEP . 'd' . DSEP . $luxe['font_japanese'] ) ) {
?>
<link rel="stylesheet" href="<?php echo Web_Font::$japanese[$luxe['font_japanese']][1]; ?>" />
<?php
		}
	}
}, 4 );

add_action( 'wp_head', function() use( $load_files ) {
	global $luxe, $awesome;
	require_once( INC . 'web-font.php' );

	$_is_singular = is_singular();
	$_is_customize_preview = is_customize_preview();

	if( $_is_customize_preview === true ) {
		/* 子テーマの CSS (プレビュー) */
		if( isset( $luxe['child_css'] ) && TDEL !== SDEL ) {
			wp_enqueue_style( 'luxech', $load_files['c-style'][1], false, array(), 'all' );
		}
	}
	else {
		/* 子テーマの CSS (実体) */
		if( isset( $luxe['child_css'] ) && TDEL !== SDEL && !isset( $luxe['amp'] ) ) {
			// 依存関係
			$deps = false;
			if( isset( $luxe['plugin_css_compress'] ) && $luxe['plugin_css_compress'] !== 'none' ) {
				$deps = array( 'plugin-styles' );
			}

			// 子テーマ圧縮してる場合
			if( $luxe['child_css_compress'] !== 'none' ) {
				if(
					file_exists( SPATH . DSEP . 'style.min.css' ) === true && filesize( SPATH . DSEP . 'style.min.css' ) !== 0 &&
					file_exists( TPATH . DSEP . 'style.min.css' ) === true && filesize( TPATH . DSEP . 'style.min.css' ) !== 0
				) {
					wp_enqueue_style( 'luxech', $load_files['c-style-min'][1], $deps, array(), 'all' );
					if( isset( $luxe['css_to_style'] ) ) {
						wp_add_inline_style( 'luxech', thk_direct_style( SPATH . DSEP . 'style.replace.min.css' ) );
					}
				}
				else {
					if( $luxe['child_css_compress'] === 'bind' ) {
						thk_load_customize_preview();
					}
					wp_enqueue_style( 'luxech', $load_files['c-style'][1], $deps, array(), 'all' );
				}
			}
			// 子テーマ圧縮してない
			else {
				if( file_exists( SPATH . DSEP . 'style.css' ) === true ) {
					wp_enqueue_style( 'luxech', $load_files['c-style'][1], $deps, array(), 'all' );
					if( isset( $luxe['css_to_style'] ) ) {
						wp_add_inline_style( 'luxech', thk_direct_style( SPATH . DSEP . 'style.replace.min.css' ) );
					}
				}
			}
		}
		if( !isset( $luxe['amp'] ) ) {
			if( $luxe['jquery_load'] !== 'none' ) {
				if( $luxe['jquery_load'] !== 'luxeritas' ) {
					if( wp_script_is( 'luxe', 'enqueued' ) === false ){
						global $wpdb; $wpdb = false;
					}
				}
			}
			else {
				get_template_part( 'inc/cinline' );
				$cinline = new cinline();
				$cinline->add_inline();
			}
		}
	}

	/* テンプレートごとに違うカラム数にしてる場合の 3カラム CSS
	 * (親子 CSS 非結合時は子テーマより先に読み込ませる -> load_styles.php で処理 )
	 */
	if( $luxe['child_css_compress'] === 'bind' && !isset( $luxe['amp'] ) ) {
		if( $luxe['column_default'] === false ) {
			if( $luxe['column_style'] === '1column' ) {
				wp_enqueue_style( 'luxe1', $load_files['p-1col'][1], false, array(), 'all' );
				wp_add_inline_style( 'luxe1', thk_direct_style( $load_files['p-1col'][0] ) );
			}
			if( $luxe['column_style'] === '2column' ) {
				wp_enqueue_style( 'luxe2', $load_files['p-2col'][1], false, array(), 'all' );
				wp_add_inline_style( 'luxe2', thk_direct_style( $load_files['p-2col'][0] ) );
			}
			if( $luxe['column_style'] === '3column' ) {
				wp_enqueue_style( 'luxe3', $load_files['p-3col'][1], false, array(), 'all' );
				wp_add_inline_style( 'luxe3', thk_direct_style( $load_files['p-3col'][0] ) );
			}
		}
	}

	// その他のインラインスクリプトとインラインスタイル
	require( INC . 'load-inline.php' );

	// 条件によっては、hentry を削除
	if( $_is_singular === true ) {
		/* 以下の条件の時に hentry を削除する
		   ・ カスタマイズで hentry 削除にチェックがついてる
		   ・ 投稿日時・更新日時の両方が非表示
		   ・ 投稿者名が非表示
		   ・ $post->post_author が空っぽ ( 通常はありえないけどプラグインではあり得る )
		   ・ get_the_modified_date が空っぽ ( 通常はありえないけどプラグインではあり得る )
		 */
		global $post;
		$pdat = get_the_date();
		$mdat = get_the_modified_date();
		$auth = get_userdata( $post->post_author );

		if(
			isset( $luxe['remove_hentry_class'] ) || !isset( $luxe['author_visible'] ) || empty( $mdat ) || empty( $auth ) ||
			(	!isset( $luxe['post_date_visible'] ) && !isset( $luxe['mod_date_visible'] ) &&
				!isset( $luxe['post_date_u_visible'] ) && !isset( $luxe['mod_date_u_visible'] )
			)

		) {
			add_filter( 'post_class', 'thk_remove_hentry' );
		}
	}

	// Amp 用のスクリプトとスタイルを挿入
	if( isset( $luxe['amp'] ) ) {
		//global $wp_scripts, $wp_styles;
		//foreach( $wp_scripts->registered as $val ) wp_dequeue_script( $val->handle );
		//foreach( $wp_styles->registered as $val ) wp_dequeue_style( $val->handle );

		// Amp 用のスタイルとスクリプト挿入
		$bootstrap   = 'maxcdn' . '.bootstrapcdn' . '.com';
		$fontawesome = 'use' . '.fontawesome' . '.com';
		$ampproject  = 'cdn' . '.ampproject' . '.org';

		if( $awesome === 4 ) {
?>
<link rel="stylesheet" href="https://<?php echo $bootstrap; ?>/font-awesome/4.7.0/css/font-awesome.min.css" />
<?php
		}
		else {
?>
<link rel="stylesheet" href="https://<?php echo $fontawesome; ?>/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous" />
<?php
		}
?>
<script async src="https://<?php echo $ampproject; ?>/v0.js"></script>
<?php
$amp_extensions = thk_amp_extensions();

foreach( $amp_extensions as $key => $val ) {
	if( isset( $luxe[$key] ) ) {
?>
<script async custom-element="<?php echo $key; ?>" src="https://<?php echo $ampproject, $val; ?>"></script>
<?php
	}
}
unset( $amp_extensions );
?>
<style amp-boilerplate>body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}</style>
<noscript><style amp-boilerplate>body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}</style></noscript>
<script type="application/ld+json">
<?php
$logo = '';
if( isset( $luxe['amp_logo'] ) ) {
	$logo = $luxe['amp_logo'];
}
else {
	$logo = TURI !== SURI ? SURI : TURI;
	$logo .= '/images/amp-site-logo.png';
}
$logo_info = thk_get_image_size( $logo );
$logo_w = 600;
$logo_h = 60;

if( is_array( $logo_info ) === true ) {
	$logo_w = $logo_info[0];
	$logo_h = $logo_info[1];

	if( $logo_info[0] >= 600 ) {
		$logo_w = 600;
		$logo_h = round( $logo_w * $logo_info[1] / $logo_info[0] );
	}
	if( $logo_h >= 60 ) {
		$logo_h = 60;
		$logo_w = round( $logo_h * $logo_info[0] / $logo_info[1] );
	}
}

$thumb = '';
$thumb_info = false;
$thumb_w = 696;
$thumb_h = 696;

if( isset( $luxe['thumbnail_visible'] ) ) {
	$thumb_id  = get_post_thumbnail_id( THK_AMP_ORG_ID );
	$thumb_url = wp_get_attachment_image_src( $thumb_id, true );
	$thumb = $thumb_url[0];
}
if( empty( $thumb ) ) {
	$no_img_png = 'no-img.png';
	$thumb = TURI . '/images/no-img.png';
}
else {
	$thumb_info = thk_get_image_size( $thumb );
}

if( is_array( $thumb_info ) === true ) {
	$thumb_w = $thumb_info[0];
	$thumb_h = $thumb_info[1];

	if( $thumb_info[0] < 696 ) {
		$thumb_w = 696;
		$thumb_h = round( $thumb_w * $thumb_info[1] / $thumb_info[0] );
	}
}

$publisher = 'Organization';
if( isset( $luxe['site_name_type'] ) ) {
	if( $luxe['site_name_type'] === 'Organization' && isset( $luxe['organization_type'] ) ) {
		$publisher = $luxe['organization_type'];
	}
}
?>
{
	"@context": "http://schema.org",
	"@type": "Article",
	"mainEntityOfPage":{
		"@type":"WebPage",
		"@id":"<?php echo THK_AMP_ORG_URL; ?>"
	},
	"headline": "<?php echo get_the_title( THK_AMP_ORG_ID );?>",
	"image": {
		"@type": "ImageObject",
		"url": "<?php echo $thumb; ?>",
		"width": <?php echo $thumb_w; ?>,
		"height": <?php echo $thumb_h, "\n"; ?>
	},
	"datePublished": "<?php echo get_the_time('Y/m/d', THK_AMP_ORG_ID) ?>",
	"dateModified": "<?php echo get_the_modified_time('Y/m/d', THK_AMP_ORG_ID) ?>",
	"author": {
		"@type": "Person",
		"name": "<?php $auth = get_users(); the_author_meta( 'display_name', $auth[0]->ID ); ?>"
	},
	"publisher": {
		"@type": "<?php echo $publisher; ?>",
		"name": "<?php echo THK_SITENAME; ?>",
		"description": "<?php echo isset( $luxe['header_catchphrase_change'] ) ? $luxe['header_catchphrase_change'] : THK_DESCRIPTION; ?>",
		"logo": {
			"@type": "ImageObject",
			"url": "<?php echo $logo; ?>",
			"width": <?php echo $logo_w; ?>,
			"height": <?php echo $logo_h, "\n"; ?>
		}
	},
	"description": "<?php echo apply_filters( 'thk_create_description', '' ); ?>"
}
</script>
<?php
		wp_enqueue_style( 'luxe-amp', TDEL . '/style-amp.css', false, array(), 'screen' );
		wp_add_inline_style( 'luxe-amp', thk_direct_style( TPATH . DSEP . 'style-amp.min.css' ) );

		if( isset( $luxe['child_css'] ) && TDEL !== SDEL ) {
			wp_enqueue_style( 'luxech-amp', SDEL . '/style-amp.css', false, array(), 'screen' );
			wp_add_inline_style( 'luxech-amp', thk_direct_style( SPATH . DSEP . 'style-amp.min.css' ) );
		}

		// amp-custom 用カスタムヘッダー
		$ampcustom = get_post_meta( $post->ID, 'amp-custom', true );
		if( !empty( $ampcustom ) ) {
			if( TDEL === SDEL ) {
				wp_add_inline_style( 'luxe-amp', $ampcustom );
			}
			else {
				wp_add_inline_style( 'luxech-amp', $ampcustom );
			}
		}
	}
}, 7 );