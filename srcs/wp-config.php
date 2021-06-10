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
define( 'DB_NAME', 'wordpress' );

/** MySQL database username */
define( 'DB_USER', 'juchoi' );

/** MySQL database password */
define( 'DB_PASSWORD', 'juchoi' );

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
define( 'AUTH_KEY',         'm&C g}mK,Y_hzPsu,gY2<|%gLX6 :Mm|A9#D+Q /XqTvl=z,x[-wh.Y`n=KAgxr?' );
define( 'SECURE_AUTH_KEY',  'RuAGB/r<cy8 ?#|?jqjUDF`KS.v)k`8dxT)#*8UF)}j0/yTsQ2%TK@dkvc1[0*>]' );
define( 'LOGGED_IN_KEY',    '%*LG#JE}#Fz:!2Shy[RgYhRRpwvLDMV#>/u^(O2>LOvYUk/I$L7,cj17z)EQXl~Q' );
define( 'NONCE_KEY',        'y$9q?@D/py@M3Z1R9qwu*p)(=0VlL0LsZxq~$5$p~^@}:Q1Y- @#v^L?leYKDNo,' );
define( 'AUTH_SALT',        '5+Bf[<t8#s:Ta=|l1s?3uSwk:clUz|RnAIIAf?+rD,hgq4_KJs~pA=XYIUBIcY88' );
define( 'SECURE_AUTH_SALT', '4aAw[$K&oc^=+Kvi@7Svr6t{{+_ez4m>{P-aUt3Q%BGc_O]x`a0p,F>W)T@_}b*s' );
define( 'LOGGED_IN_SALT',   '@^eI4<S_gXCG>,Js#{Yv mn76AG03~#9;kXv7M*OcyYd7v_hD@uxI^DN8IBAv1K3' );
define( 'NONCE_SALT',       'GIEP)R~b:w8.F+&YGZ&e7.l4U,Ky37G|_Eb%%V@4=KJt!HmA&qAHnIOS5,(Vjx<G' );

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
