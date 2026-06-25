<?php
define( 'WP_CACHE', true );





















































































/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'sunrenpj_dbbloggtpt' );

/** Database username */
define( 'DB_USER', 'sunrenpj_adminbloggtpt' );

/** Database password */
define( 'DB_PASSWORD', '-OeOX@TdNiwm' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '7tjAlDTM94BayBFjCv.,yAOxy,-, n4.s[cT5hnB{3|b+h&/ 2zxxd;b/&ukPZF-' );
define( 'SECURE_AUTH_KEY',  'I~p>bF5}Q<pVbSWsw_mJ!94aYpw/q:jrj|5nNl^$hcJ;Am1Nc-E9+]N05CI&w#m]' );
define( 'LOGGED_IN_KEY',    ':tu:1S-9{mo;tK8[T-lw@`-uX!Vu`K{eZzOtQnb*PFI~y9Ewl:sPvbodb4jAOn|p' );
define( 'NONCE_KEY',        'HLayN>;Cc,-,UxO`Hu6Q6:I.l}Zu;Lx#{9dd@w?!5|b}l%U2i/Pon>R 4{y1=m7!' );
define( 'AUTH_SALT',        'd}A5#8ab69CVixUbu*<@|x[r#_v2 (OO;kMK):SI)e`pX}95Gl4)K6 ]tE@GwvmA' );
define( 'SECURE_AUTH_SALT', '(!r<,gG%getV[S8sT:5s83[mjsx9l3M7/{1[YPJa04Cgr7M8:o=$21?+%soeT0Ji' );
define( 'LOGGED_IN_SALT',   'MPC[x35a96u(gogg  I^DOzc)mW7`%cnGrjg71v<qGlZ9NU:G.iU{Im/!9(6,Ls^' );
define( 'NONCE_SALT',       '@[zd1? FMu#2q@c=Opt.mun.X1N@f4,KOw@tD0gW8|3z5.Z?uE0^ZcI%Q+Ls[Adm' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
