<?php
/**
 * Orfeo functions and definitions.
 *
 * @package orfeo
 * @since 1.0.0
 */

define( 'ORFEO_VERSION', '1.0.0' );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'orfeo_parent_css' ) ):
	function orfeo_parent_css() {
		wp_enqueue_style( 'orfeo_parent', trailingslashit( get_template_directory_uri() ) . 'style.css', array( 'bootstrap' ) );
		if ( is_rtl() ) {
			wp_enqueue_style( 'orfeo_parent_rtl', trailingslashit( get_template_directory_uri() ) . 'style-rtl.css', array( 'bootstrap' ) );
		}

	}
endif;
add_action( 'wp_enqueue_scripts', 'orfeo_parent_css', 10 );

/**
 * Change default fonts.
 *
 * @since 1.0.0
 */
function orfeo_change_defaults( $wp_customize ) {

	/* Change default fonts */
	$orfeo_headings_font = $wp_customize->get_setting( 'hestia_headings_font' );
	if ( ! empty( $orfeo_headings_font ) ) {
		$orfeo_headings_font->default = 'Montserrat';
	}
	$orfeo_body_font = $wp_customize->get_setting( 'hestia_body_font' );
	if ( ! empty( $orfeo_body_font ) ) {
		$orfeo_body_font->default = 'Montserrat';
	}
}
add_action( 'customize_register', 'orfeo_change_defaults', 0 );


/**
 * Change default font family for front end display.
 *
 * @return string
 *
 * @since 1.0.0
 */
function orfeo_font_default_frontend() {
	return 'Montserrat';
}

add_filter( 'hestia_headings_default', 'orfeo_font_default_frontend' );
add_filter( 'hestia_body_font_default', 'orfeo_font_default_frontend' );

/**
 * Change default value of accent color
 *
 * @since
 */
function orfeo_accent_color() {
	return '#f5593d';
}
add_filter( 'hestia_accent_color_default', 'orfeo_accent_color' );

function orfeo_inline_style() {

	$color_accent = get_theme_mod( 'accent_color', apply_filters( 'hestia_accent_color_default', '#f5593d' ) );

	$custom_css = '';

	if ( ! empty( $color_accent ) ) {

		/* Pagination on Blog */
		$custom_css .= '.pagination .nav-links .page-numbers { color: ' . $color_accent . '; border-color: ' . $color_accent . '; }';
		$custom_css .= '.pagination .nav-links .page-numbers.current { border-color: ' . $color_accent . '; }';
		$custom_css .= '.pagination .nav-links .page-numbers:hover { background-color: ' . $color_accent . '; }';
		$custom_css .= '.pagination .nav-links .page-numbers:hover { border-color: ' . $color_accent . '; }';

		/* Pagination ons Shop */
		$custom_css .= '.woocommerce-pagination ul.page-numbers .page-numbers { color: ' . $color_accent . '; border-color: ' . $color_accent . '; } ';
		$custom_css .= '.woocommerce-pagination ul.page-numbers li > span.current { border-color: ' . $color_accent . ' !important; }';
		$custom_css .= '.woocommerce-pagination ul.page-numbers .page-numbers:hover { background-color: ' . $color_accent . '; }';
		$custom_css .= '.woocommerce-pagination ul.page-numbers .page-numbers:hover { border-color: ' . $color_accent . '; }';

		/* Categories */
		$custom_css .= '.entry-categories .label { background-color: ' . $color_accent . ';}';

		/* Shop Sidebar Rating*/
		$custom_css .= '.woocommerce .star-rating { color: ' . $color_accent . '; }';

		/* Single Product Page Rating */
		$custom_css .= '.woocommerce div.product p.stars span a:before { color: ' . $color_accent . '; }';

		/* Cart action buttons */
		$custom_css .= '.woocommerce-cart table.shop_table tr td.actions input[type=submit] { background-color: ' . $color_accent . '; }';
		$custom_css .= '.woocommerce-cart table.shop_table tr td.actions input[type=submit]:hover { background-color: ' . $color_accent . '; }';

		/* WooCommerce message */
		$custom_css .= '.woocommerce-page .woocommerce-message { background-color: ' . $color_accent . '; }';

		/* WooCommerce My Order Tracking Page */
		$custom_css .= '.track_order input[type=submit] { background-color: ' . $color_accent . '; }';
		$custom_css .= '.track_order input[type=submit]:hover { background-color: ' . $color_accent . '; }';
	}

	wp_add_inline_style( 'orfeo_parent', $custom_css );
}
add_action( 'wp_enqueue_scripts', 'orfeo_inline_style', 10 );

/**
 * Change features defaults.
 *
 * @since 1.0.0
 */
function orfeo_features_defaults() {
	return json_encode(
		array(
			array(
				'icon_value' => 'fa-star-o',
				'title'      => esc_html__( 'Feature 1', 'orfeo' ),
				'text'       => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque rutrum molestie sagittis.', 'orfeo' ),
				'link'       => '',
				'color'      => '#e91e63',
			),
			array(
				'icon_value' => 'fa-diamond',
				'title'      => esc_html__( 'Feature 2', 'orfeo' ),
				'text'       => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque rutrum molestie sagittis.', 'orfeo' ),
				'link'       => '',
				'color'      => '#00bcd4',
			),
			array(
				'icon_value' => 'fa-envelope-o',
				'title'      => esc_html__( 'Feature 3', 'orfeo' ),
				'text'       => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque rutrum molestie sagittis.', 'orfeo' ),
				'link'       => '',
				'color'      => '#4caf50',
			),
		)
	);
}
add_filter( 'hestia_features_default_content', 'orfeo_features_defaults' );

/**
 * Remove parent theme actions
 *
 * @since 1.0.0
 */
function orfeo_remove_hestia_actions() {

	/* Remove three points from blog read more button */
	remove_filter( 'excerpt_more', 'hestia_excerpt_more', 10 );

}
add_action( 'after_setup_theme', 'orfeo_remove_hestia_actions' );

/**
 * Remove product description except from Single Product Page
 *
 * @since 1.0.0
 */
function orfeo_remove_product_description() {

	if ( class_exists( 'WooCommerce' ) ) {
		if ( ! is_product() ) {
			add_filter( 'woocommerce_short_description', '__return_empty_string' );
		}
	}
}
add_action( 'template_redirect', 'orfeo_remove_product_description' );

/**
 * Replace excerpt "Read More" text with a link.
 *
 * @since 1.0.0
 */
function orfeo_excerpt_more( $more ) {
	global $post;
	if ( ( ( 'page' === get_option( 'show_on_front' ) ) ) || is_single() || is_archive() || is_home() ) {
		return '<a class="moretag" href="' . esc_url( get_permalink( $post->ID ) ) . '"> ' . esc_html__( 'Read more', 'orfeo' ) . '</a>';
	}

	return $more;
}
add_filter( 'excerpt_more', 'orfeo_excerpt_more' );

/**
 * Remove boxed layout control
 *
 * @since 1.0.0
 */
function orfeo_remove_boxed_layout( $wp_customize ) {

	$wp_customize->remove_control( 'hestia_general_layout' );
}
add_action( 'customize_register', 'orfeo_remove_boxed_layout', 100 );

/**
 * Import options from Hestia
 *
 * @since 1.0.0
 */
function orfeo_get_lite_options() {
	$hestia_mods = get_option( 'theme_mods_hestia' );
	if ( ! empty( $hestia_mods ) ) {
		foreach ( $hestia_mods as $hestia_mod_k => $hestia_mod_v ) {
			set_theme_mod( $hestia_mod_k, $hestia_mod_v );
		}
	}
}
add_action( 'after_switch_theme', 'orfeo_get_lite_options' );

