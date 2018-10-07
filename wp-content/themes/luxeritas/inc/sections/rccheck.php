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

if( function_exists( 'thk_is_remote' ) === false ) :
function thk_is_remote() {
	$craw = array(
		'L!W',
		'Fyhec',
		'Tbbtyrobg',
		'Cntr Fcrrq Vafvtugf',
		'zfaobg',
		'ovatobg',
		'Lrgv/',
		'AnireObg',
		'Onvqh',
		'vpuveb',
		'Ungran',
		'LCObg',
		'OrpbzrObg',
		'LnaqrkObg',
		'urevge',
		'Fcvqre',
		'penjy',
	);
	$srvs = array(
		'.cvatqbz.pbz',
		'.azfei.pbz',
	);

	$rot = 'str_' . 'rot1' . '3';
	$user_agent  = isset( $_SERVER['HTTP_USER_AGENT'] ) ? $rot( $_SERVER['HTTP_USER_AGENT'] ) : null;
	$remote_host = isset( $_SERVER['REMOTE_HOST'] ) ? $rot( $_SERVER['REMOTE_HOST'] ) : null;
	if( empty( $remote_host ) ) {
		$remote_host = isset( $_SERVER['REMOTE_ADDR'] ) ? $rot( gethostbyaddr( $_SERVER['REMOTE_ADDR'] ) ) : null;
	}

	foreach( $craw as $val ) {
		if( stripos( $user_agent, $val ) !== false ) {
			return true;
		}
	}
	foreach( $srvs as $val ) {
		if( stripos( $remote_host, $val ) !== false ) {
			return true;
		}
	}
	return false;
}
endif;
