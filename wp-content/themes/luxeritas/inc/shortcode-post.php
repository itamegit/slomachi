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
if( isset( $luxe['add_post_shortcode_button_1'] ) ) {
	add_action( 'media_buttons', function() {
		$label = __( 'Shortcode', 'luxeritas' );
?>
<a href="#" id="thk-shortcode-action" class="button" title="<?php echo $label; ?>"><span class="thk-shortcode-icon"></span><?php echo $label; ?></a>
<?php
	}, 20 );
}

/*---------------------------------------------------------------------------
 * TinyMCE ボタン
 *---------------------------------------------------------------------------*/
if( isset( $luxe['add_post_shortcode_button_2'] ) ) {
	if( get_user_option( 'rich_editing' ) === 'true' ) {
		add_filter( 'mce_external_plugins', function( $plugin_array ) {
			$plugin_array[ 'thk-shortcode-button' ] = TDEL . '/js/' . 'thk-dummy.js';
			return $plugin_array;
		});
		add_filter( 'mce_buttons', function( $buttons ) {
			array_push( $buttons, 'thk-shortcode-button' );
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
<div id="thk-shortcode-form" title="<?php echo __( 'Insert Shortcode', 'luxeritas' ); ?>">
	<form>
	<div class="radio-group">
<?php
$values = array( 'label' => '', 'close' => '', 'hide' => '', 'active' => '' );
$admin_mods = get_theme_phrase_mods();
$sc_mods = array();
$active_flag = false;

foreach( (array)$admin_mods as $key => $val ) {
	if( strpos( $key, 'sc-' ) === 0 ) {
		$sc_mods[substr( $key, 3, strlen( $key ) )] = wp_parse_args( @json_decode( $val ), $values );
	}
}
unset( $admin_mods );

foreach( (array)$sc_mods as $key => $val ) {
	if( $active_flag === false ) {
		if( !empty( $sc_mods[$key]['active'] ) ) $active_flag = true;
	}
}

if( $active_flag === false ) {
?>
<p style="color:red"><?php echo __( 'There is no active shortcode.', 'luxeritas' ); ?></p>
<?php
}
else {
	asort( $sc_mods );
	foreach( (array)$sc_mods as $key => $val ) {
		$values = $val;
		if( isset( $values['active'] ) ) {
	?>
<input type="radio" id="<?php echo $key; ?>" name="sc_selector" value="<?php echo $key; ?>" data-shortcode-closing="<?php echo $values['close']; ?>" /><label for="<?php echo $key; ?>"><?php echo $values['label']; ?></label>
	<?php
		}
	}
}
?>
	</div>
	</form>
<script>
jQuery(function($) {
	$('input[name=sc_selector]').change(function(){
	　　　　$('input[name=sc_selector][value='+$(this).val()+']').prop('checked', true);
	});
});
</script>
</div>

<script>
jQuery(function($) {
	var bc    = '#option-'
	,   scfm  = $('#thk-shortcode-form');

	scfm.dialog({
		autoOpen: false,
		height: 'auto',
		width: 'auto',
		maxWidth: 640,
		minWidth: 300,
		modal: true,
		buttons: {  // ダイアログに表示するボタンと処理
			"<?php echo __( 'Insert', 'luxeritas' ); ?>": function() {
				var mce = null
				,   select  = $("input[name='sc_selector']:checked")
				,   code    = select.val()
				,   has_space = code
				,   insert  = '[' + code + ']'
				,   closing = select.attr( 'data-shortcode-closing' );

				if( code == '' || code == null ) return false;

				if( closing == 1 ) {
					$(this).dialog('close');

					if( code.indexOf(' ') != -1 ) {
						has_space = code.substring( 0, code.indexOf(' ') );
					}
					insert = '[' + code + ']' + THK_SELECTED_RANGE + '[/' + has_space + ']';
				}

				if( window.tinyMCE ) mce = tinyMCE;

				if( mce !== null && mce.activeEditor && !( mce.activeEditor.isHidden() ) ) {
					// TinyMCE がオープンならそれを使う
					tinyMCE.activeEditor.execCommand( 'mceInsertContent', false, insert )
				} else if(window.parent.QTags) {
					// なければ QTag で挿入
					QTags.insertContent( insert );
				}
				$(this).dialog('close');
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
if( isset( $luxe['add_post_shortcode_button_2'] ) ) {
?>
	if( typeof QTags !== 'undefined' ) {
		var thk_shortcode_dialog_open = function() {
			THK_GET_SELECTED_RANGE();
			scfm.dialog('open').dialog("open");
			scfm.find('input').prop('checked', false);
		}
		QTags.addButton( 'thk-shortcode', '<?php echo __( "Shortcode", "luxeritas" ); ?>', thk_shortcode_dialog_open );
	}

	(function($) {
		if( typeof tinymce !== 'undefined' ) {
			tinymce.PluginManager.add( 'thk-shortcode-button', function( editor ) {
				editor.addButton( "thk-shortcode-button", {
					tooltip: "<?php echo __( 'Shortcode', 'luxeritas' ); ?>",
					onclick: function() {
						THK_GET_SELECTED_RANGE();
						scfm.dialog('open').dialog("open");
						scfm.find('input').prop('checked', false);
					}
				});
			});
		}
	})(jQuery);
<?php
}
?>
	// ショートコードボタンがクリックされたらダイアログを表示
	$('#thk-shortcode-action').click( function() {
		THK_GET_SELECTED_RANGE();
		scfm.dialog('open');
		scfm.find('input').prop('checked', false);

		// ボタンの色を WordPress の管理画面の配色に合わせた色に変更する
		if( typeof $('.button-primary')[0] !== 'undefined' ) {
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
		scfm.dialog('close');
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
