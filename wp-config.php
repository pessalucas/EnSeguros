<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'enseguros' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'i{Ev6tZ26s[_.oK$pL]oF)=3vSB?Pp0kqz8e91g8R7%hDQ,+Td(l!iy/fp{rwU/)' );
define( 'SECURE_AUTH_KEY',  'f/UA>5~#=;kIt7O5|6<NG[1qki?hQD0CqO{-yA&nc}r0t&X]m..zt6@60&KId0!4' );
define( 'LOGGED_IN_KEY',    '=!Y}:e/($ e$_:jk+G8G&E]~jnDi`*.8KH5OLBL(%+H#7jZo@9Gof(Y%fba#_mH@' );
define( 'NONCE_KEY',        'k8RJYzTa`tM,s|w%[;+44|<A~ 3uaX<AyY+$X5t5X44vhJBoqsnBqJ.K7C)Ra :&' );
define( 'AUTH_SALT',        ';x9.]|0YUzg-L)| d<_1f>3(O=<X2s9i# x!tYN8X=~SYHb0OV`yr/a4`9R+Lf7Q' );
define( 'SECURE_AUTH_SALT', 'NOc:j^^2S-(sT{`[Xdx2]9bfnW$b/bc[4n+V(sJ(R0?j6Oki#eBce76899k-O0s0' );
define( 'LOGGED_IN_SALT',   '}Gi+Xo,Ri1OEti.=myh Z-/L_tzMp&Tq>~B>tniAYj8gv?<T~^S[%VpibIy00b9K' );
define( 'NONCE_SALT',       'YKESFCvTpegk1|Dh`~P/|n9FIo+C//O62$|_Z. ,q/ n$a=Hn<Hvj_<F_(>h{ihH' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
