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
 * メディアボタン横
 *---------------------------------------------------------------------------*/
if( isset( $luxe['add_phrase_button_1'] ) ) {
	add_action( 'media_buttons', function() {
		$label = __( 'Fixed phrases', 'luxeritas' );
?>
<a href="#" id="thk-phrase-action" class="button" title="<?php echo $label; ?>"><span class="thk-phrase-icon"></span><?php echo $label; ?></a>
<?php
	}, 20 );
}

/*---------------------------------------------------------------------------
 * TinyMCE ボタン
 *---------------------------------------------------------------------------*/
if( isset( $luxe['add_phrase_button_2'] ) ) {
	if( get_user_option( 'rich_editing' ) === 'true' ) {
		add_filter( 'mce_external_plugins', function( $plugin_array ) {
			$plugin_array[ 'thk-phrase-button' ] = TDEL . '/js/' . 'thk-dummy.js';
			return $plugin_array;
		});
		add_filter( 'mce_buttons', function( $buttons ) {
			array_push( $buttons, 'thk-phrase-button' );
			return $buttons;
		});
	}
}

/*---------------------------------------------------------------------------
 * フッター（メイン処理）
 *---------------------------------------------------------------------------*/
add_action( 'admin_footer', function() {
	global $luxe;
?>
<!-- #dialog-form  -->
<div id="thk-phrase-form" title="<?php echo __( 'Insert fixed phrase', 'luxeritas' ); ?>">
	<form>
	<div class="radio-group">
<?php
$fp_mods = array();
$values  = array( 'close' => '' );
$admin_mods  = get_theme_phrase_mods();
$popup_nonce = wp_create_nonce( 'phrase_popup' );

foreach( (array)$admin_mods as $key => $val ) {
	if( strpos( $key, 'fp-' ) === 0 ) {
		$fp_mods[substr( $key, 3, strlen( $key ) )] = wp_parse_args( @json_decode( $val ), $values );
	}
}
unset( $admin_mods );

if( empty( $fp_mods ) ) {
?>
<p style="color:red"><?php echo __( 'There is no fixed phrases registered.', 'luxeritas' ); ?></p>
<?php
}
else {
	asort( $fp_mods );
	foreach( (array)$fp_mods as $key => $val ) {
		$fpid = strlen( $key ) . '-' . md5( $key );
?>
<input type="radio" id="<?php echo $fpid; ?>" name="fp_selector" value="<?php echo $key; ?>" data-phrase-sep="<?php echo $fpid; ?>" data-phrase-closing="<?php echo $val['close']; ?>" /><label for="<?php echo $fpid; ?>"><?php echo $key; ?></label>
<?php
	}
}
?>
	</div>
	</form>
<script>
jQuery(function($) {
	$('input[name=fp_selector]').change(function(){
	　　　　$('input[name=fp_selector][value='+$(this).val()+']').prop('checked', true);
	});
});
</script>
</div>

<script>
jQuery(function($) {
	var bc    = '#option-'
	,   fpfm  = $('#thk-phrase-form');

	var thk_mce_insert = function( code, insert ) {
		var mce = null;

		if( code == '' || code == null ) return false;

		if( window.tinyMCE ) mce = tinyMCE;

		if( mce !== null && mce.activeEditor && !( mce.activeEditor.isHidden() ) ) {
			// TinyMCE がオープンならそれを使う
			tinyMCE.activeEditor.execCommand( 'mceInsertContent', false, insert )
		} else if(window.parent.QTags) {
			// なければ QTag で挿入
			QTags.insertContent( insert );
		}
	}

	fpfm.dialog({
		autoOpen: false,
		height: 'auto',
		width: 'auto',
		maxWidth: 640,
		minWidth: 300,
		modal: true,
		buttons: {  // ダイアログに表示するボタンと処理
			"<?php echo __( 'Insert', 'luxeritas' ); ?>": function() {
				var insert  = null
				,   rep     = ''
				,   select  = $("input[name='fp_selector']:checked")
				,   code    = select.val()
				,   sep     = select.attr( 'data-phrase-sep' )
				,   closing = select.attr( 'data-phrase-closing' )

				$(this).dialog('close');

				jQuery.ajax({
					type: 'POST',
					url: '<?php echo admin_url( "admin-ajax.php" ); ?>',
					data: {action:'thk_phrase_regist', name:code, fp_popup_nonce:'<?php echo $popup_nonce; ?>'},
					dataType: 'text',
					async: true,
					cache: false,
					timeout: 10000,
					success: function( response ) {
						if( closing == 1 ) {
							thk_mce_insert( code, response.replace( "\n<!--" + sep + "-->\n", THK_SELECTED_RANGE) );
						} else {
							thk_mce_insert( code, response );
						}
					},
					error: function() {
						thk_mce_insert( code, '<?php echo __( "Failed to read.", "luxeritas" ); ?>' );
					}
				});

				// ダイアログを閉じたらフォーカスを移す
				setTimeout( function(){ $('iframe').eq(0).focus(); }, 0 );
				setTimeout( function(){ $('textarea').eq(0).focus(); }, 0 );
			},
			"<?php echo __( 'Cancel', 'luxeritas' ); ?>": function() {
				$(this).dialog('close');
				// ダイアログを閉じたらフォーカスを移す
				setTimeout( function(){ $('iframe').eq(0).focus(); }, 0 );
				setTimeout( function(){ $('textarea').eq(0).focus(); }, 0 );
			}
		},
	});

<?php
if( isset( $luxe['add_phrase_button_2'] ) ) {
?>
	if( typeof QTags !== 'undefined' ) {
		var thk_phrase_dialog_open = function() {
			THK_GET_SELECTED_RANGE();
			fpfm.dialog('open').dialog("open");
			fpfm.find('input').prop('checked', false);
		}
		QTags.addButton( 'thk-phrase', '<?php echo __( "Fixed phrases", "luxeritas" ); ?>', thk_phrase_dialog_open );
	}

	(function($) {
		if( typeof tinymce !== 'undefined' ) {
			tinymce.PluginManager.add( 'thk-phrase-button', function( editor, url ) {
				editor.addButton( "thk-phrase-button", {
					tooltip: "<?php echo __( 'Fixed phrases', 'luxeritas' ); ?>",
					onclick: function() {
						THK_GET_SELECTED_RANGE();
						fpfm.dialog('open').dialog("open");
						fpfm.find('input').prop('checked', false);
					}
				});
			});
		}
	})(jQuery);
<?php
}
?>
	// 定型文ボタンがクリックされたらダイアログを表示
	$('#thk-phrase-action').click( function() {
		THK_GET_SELECTED_RANGE();
		fpfm.dialog('open');
		fpfm.find('input').prop('checked', false);

		// ボタンの色を WordPress の管理画面の配色に合わせた色に変更する
		if( typeof $('body .button-primary')[0] !== 'undefined' ) {
	        	var bp = $('body .button-primary, body .ui-button-icon')
			,   ub = $('body .ui-button')
	        	,   csspa = {
				'background': bp.css('background'),
				'box-shadow': bp.css('box-shadow'),
				'border-color': bp.css('border-color')
			};
			$.each( csspa, function( i, elm ) {
				ub.css( i, elm );
			});
			ub.hover(
				function() {
					$(this).css('opacity', '.85');
				},
				function() {
					$(this).css('opacity', '');
				}
			);
		}
		return false;
	});

	// オーバーレイがクリックされたらダイアログを閉じる
	$(document).on( 'click', '.ui-widget-overlay', function() {
		fpfm.dialog('close');
		setTimeout( function(){ $('iframe').eq(0).focus(); }, 0 );
		setTimeout( function(){ $('textarea').eq(0).focus(); }, 0 );
	}); 
});

// タブの入力ができるようにする
var textareas = document.getElementsByTagName('textarea');
var count = textareas.length;
for( var i = 0; i < count; i++ ) {
	textareas[i].onkeydown = function(e){
		if( e.keyCode === 9 || e.which === 9 ) {
			e.preventDefault();
			var s = this.selectionStart;
			this.value = this.value.substring( 0, this.selectionStart ) + "\t" + this.value.substring( this.selectionEnd );
			this.selectionEnd = s + 1;
		}
	}
}
</script>
<?php
});
