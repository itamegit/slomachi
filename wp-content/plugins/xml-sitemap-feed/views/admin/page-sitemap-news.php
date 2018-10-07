<style type="text/css">
<?php include XMLSF_DIR . '/views/styles/admin.css'; ?>
</style>
<div class="wrap">

	<h1><?php _e('Google News Sitemap','xml-sitemap-feed'); ?></h1>

	<p>
	    <a target="_blank" href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=ravanhagen%40gmail%2ecom&item_name=XML%20Sitemap%20Feeds&item_number=version%20<?php echo XMLSF_VERSION; ?>&no_shipping=0&tax=0&charset=UTF%2d8"
	        title="<?php printf(__('Donate to keep the free %s plugin development & support going!','xml-sitemap-feed'),__('XML Sitemap & Google News','xml-sitemap-feed')); ?>">
	        <img src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif" style="border:none;float:right;margin:4px 0 0 10px" width="92" height="26" />
	    </a>
	    <?php printf( __( 'These settings control the Google News Sitemap generated by the %s plugin.', 'xml-sitemap-feed' ), __( 'XML Sitemap & Google News', 'xml-sitemap-feed' ) ); ?>
		<?php printf( /* translators: Writing Settings URL */ __( 'For ping options, go to %s.', 'xml-sitemap-feed' ), '<a href="options-writing.php">'.translate('Writing Settings').'</a>' ); ?>
	</p>

	<?php do_action('xmlsf_news_settings_before'); ?>

	<div class="main">
		<form method="post" action="options.php">

			<?php settings_fields( 'xmlsf-news' ); ?>

			<?php do_settings_sections( 'xmlsf-news' ); ?>

			<?php do_action('xmlsf_news_settings_after'); ?>

			<?php submit_button(); ?>

		</form>
	</div>

	<div class="sidebar">
		<h3><?php echo translate('View'); ?></h3>
		<p>
			<a href="<?php echo trailingslashit(get_bloginfo('url')) . ( xmlsf()->plain_permalinks() ? '?feed=sitemap-news' : $options['sitemap-news'] ); ?>" target="_blank" class="button button-large"><?php _e('Google News Sitemap','xml-sitemap-feed'); ?></a>
		</p>

		<h3><?php echo translate('Tools'); ?></h3>
		<form action="" method="post">
			<?php wp_nonce_field( XMLSF_BASENAME.'-help', '_xmlsf_help_nonce' ); ?>
			<input type="submit" name="xmlsf-check-conflicts" class="button button-small" value="<?php _e( 'Check for conflicts', 'xml-sitemap-feed' ); ?>" />
		</form>

		<h3><?php echo translate('Help'); ?></h3>
		<p>
			<?php printf (
			/* translators: Plugin name, Support forum URL on WordPress.org */
			__( 'These options are provided by %1$s. For help, please go to <a href="%2$s" target="_blank">Support</a>.', 'xml-sitemap-feed' ),
			'<strong>'.__('XML Sitemap & Google News','xml-sitemap-feed') . '</strong>', 'https://wordpress.org/support/plugin/xml-sitemap-feed'
			); ?>
		</p>

		<?php include XMLSF_DIR . '/views/admin/help-tab-news-sidebar.php'; ?>

		<h3><?php _e('Contribute','xml-sitemap-feed'); ?></h3>
		<p>
			<?php printf (
			/* translators: Review page URL and Translation page URL on WordPress.org */
			__( 'If you would like to contribute and share with the rest of the WordPress community, please consider writing a quick <a href="%1$s" target="_blank">Review</a> or help out with <a href="%2$s" target="_blank">Translating</a>!', 'xml-sitemap-feed' ),
			'https://wordpress.org/support/plugin/xml-sitemap-feed/reviews/', 'https://translate.wordpress.org/projects/wp-plugins/xml-sitemap-feed'
			); ?>
		</p>
		<p>
			<?php printf (
			/* translators: Github project URL */
			__( 'For feature requests, reporting issues or contributing code, you can find and fork this plugin on <a href="%s" target="_blank">Github</a>.', 'xml-sitemap-feed' ),
			'https://github.com/RavanH/xml-sitemap-feed'
			); ?>
		</p>
	</div>

</div>
