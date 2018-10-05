<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

$_SERVER['HTTPS'] = 'on';

// ** Heroku Postgres settings - from Heroku Environment ** //
$db = parse_url($_ENV["DATABASE_URL"]);

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', trim($db["path"],"/"));

/** MySQL database username */
define('DB_USER', $db["user"]);

/** MySQL database password */
define('DB_PASSWORD', $db["pass"]);

/** MySQL hostname */
define('DB_HOST', $db["host"] . ':' . $db["port"]);

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */

define('AUTH_KEY',         'wZ@09pqM<z!0|2:5h5IR|t|@-`DyC;^B%RK9:-)|, 9!:+eX491QmzQXH#BV|=9{');
define('SECURE_AUTH_KEY',  '<r^W_D(4Z|`8o2[0m_*}=OoL^1jzC8*cyj xm>H^~)o*,9AfqDjpNSogH9?4}yPJ');
define('LOGGED_IN_KEY',    '.] J@;-Q~Ia96I^B=F-TE!XZOthqbKN,% )b@[>xekQ+<,8Zv8J+t&[l!Y~6KM@w');
define('NONCE_KEY',        'UtdAn8k+YZ,W_lN1VCL_%D2+mw g[os~xei@jLQgNTH^{wZwTV41qPo4m9:O,0$C');
define('AUTH_SALT',        '|UY_my`W%|f>kXF&J@[U/QPGF]D>$ei2IaiRacRU(X&K=[:Z#uv<u|U=+t;bn<XG');
define('SECURE_AUTH_SALT', '1r#j<:-/>YvH!3A}.}:Gq0vJ 5]&0t8[=J4)FonblT8X~VC!hq%5{(Aw6mJ{+5Rj');
define('LOGGED_IN_SALT',   '_Tn%-$f~{#%f&FUlpa^_iS!KXfz;#{RQ$e(97F19w+s}9WjPSJ5Ym|OunEnjiYzP');
define('NONCE_SALT',       'T&[=kd7e),}EX|GE5F,^fG<R=9JJ?-A+vz[>A/78;0$l4]s(#,=)qF{}.<#0VZ=]');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
