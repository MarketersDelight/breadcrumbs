<?php
/**
 * Use the theme's isolated WordPress stubs and load this Drop-in's code.
 *
 * The theme checkout must be installed beside md-dropins in wp-content.
 */

$theme = dirname( __DIR__, 3 ) . '/themes/marketers-delight';

if ( ! file_exists( $theme . '/tests/inheritance/bootstrap.php' ) )
	throw new RuntimeException( 'Breadcrumbs tests require a sibling Marketers Delight theme checkout.' );

require_once $theme . '/tests/inheritance/bootstrap.php';
require_once dirname( __DIR__ ) . '/breadcrumbs.php';
