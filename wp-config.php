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

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'kalmar_db');

/** MySQL database username */
define('DB_USER', 'kalmarUser');

/** MySQL database password */
define('DB_PASSWORD', 'K&fy~lT*A;iB');

/** MySQL hostname */
define('DB_HOST', 'localhost');

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
define('AUTH_KEY',         'L_!Oo2[&[6I>p@^+Vkc|xZZUM2QM0@LlEuff&rOu239hG)P0NjPgaVfey8xa!V2W');
define('SECURE_AUTH_KEY',  '(;BY{aHZg}S#Ni1WLmaxR&O5/lwkE0x?=v#Y2?q(/eJNV;%Va5{B-2p-[5ZipQ& ');
define('LOGGED_IN_KEY',    'B-18x9vf|0<-C0Yi)rbq^<],FO^x-M>@`i:+)89YYS v|E<-#*YimD.@MD%s 3A.');
define('NONCE_KEY',        '+[V7e{n:qp!g&s0%sSq/rjlh^1<idro@(@_EAt+FF*XDI*TPx1B|>O9pmxE|a*oe');
define('AUTH_SALT',        '! RjDFUnzci$HmyFxT]m(jMrE-/OJOoR/Q8$(ju(5ZhkP2|R|EB6V}2[]wL7g`|y');
define('SECURE_AUTH_SALT', 'M1$|M5-(*oHH+zC.sWqWHz&XU|>X2|}:$A+H,MUz?H8]|ftK _6UJ5iaD8?Ny|+[');
define('LOGGED_IN_SALT',   '64/3sp&L_0Vdi_c?f/)cne,Ou__5|71`e>u*N9X^5=pk{^QZM^&EM_@PZ(>=efVK');
define('NONCE_SALT',       'dY<.sPC;UF}Q]E:zX_#I3k8*Pxp|$B.;gKG;h 6rrWIG$Ht)MOfyy&aba+JzILY+');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_dummy_site';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

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
