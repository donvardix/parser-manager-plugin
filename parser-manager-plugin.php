<?php
/*
Plugin Name: Parser Manager
Description: Parser Manager
Author: donvardix
Text Domain: parser-manager-plugin
Domain Path: /languages
Version: 1.0.0
Author URI: https://github.com/donvardix
License: GPLv2 or later
*/

/*  © Copyright 2021

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

function prsrmngr_admin_menu() {
    add_menu_page(
        __( 'Title Name', 'plugin-name' ),
        __( 'Plugin Name', 'plugin-name' ),
        'manage_options',
        'parser-manager-plugin.php',
        'prsrmngr_page',
        'dashicons-shortcode'
    );
    add_submenu_page(
        'parser-manager-plugin.php',
        __( 'Title Name Page', 'plugin-name' ),
        __( 'Plugin Page', 'plugin-name' ),
        'manage_options',
        'parser-manager-plugin.php',
        'prsrmngr_page'
    );
    add_submenu_page(
        'parser-manager-plugin.php',
        __( 'Title Name Settings', 'plugin-name' ),
        __( 'Settings', 'plugin-name' ),
        'manage_options',
        'parser-manager-plugin-settings.php',
        'prsrmngr_settings_page'
    );
}

function prsrmngr_page() { ?>
    <div class="wrap">
        <?php parser_output(); ?>
    </div>
<?php }

function prsrmngr_settings_page() {
    global $plgnnm_options; ?>
    <div class="wrap">
        <h1><?php _e( 'Title Name Page', 'plugin-name' ); ?></h1>
        <table class="form-table">
            <tr>
                <th scope="row"><?php _e( 'Options1', 'plugin-name' ); ?></th>
                <td>
                    <input name='plgnnm_options1' type='text' value='<?php echo $plgnnm_options['options1']; ?>' />
                </td>
            </tr>
            <tr>
                <th scope="row"><?php _e( 'Options2', 'plugin-name' ); ?></th>
                <td>
                    <input name='plgnnm_options2' type='text' value='<?php echo $plgnnm_options['options2']; ?>' />
                </td>
            </tr>
        </table>
    </div>
<?php }

function parser_output() {
	$args = array(
		array(
			'url'               => 'https://neon.ua/product/_AMD_AM4_Ryzen_5_5600X_Tray_6x3_7_GHz_Turbo_Boost_4_6_GHz_L3_32Mb_Zen_3_7_nm_TDP_65W_100100000065__924998/',
			'parser_method'     => 'strpos_parser',
			'get_html_method'   => 'wp_method',
			'start'             => '<span itemprop="price">',
			'end'               => '</span>'
		),
		array(
			'url'               => 'https://neon.ua/product/USB_Flash_Drive_32Gb_Goodram_Twister_Black_Silver_17_9Mbps_UTS20320K0R11_856626/',
			'parser_method'     => 'strpos_parser',
			'get_html_method'   => 'wp_method',
			'start'             => '<span itemprop="price">',
			'end'               => '</span>'
		)
	);

	require_once( 'includes/Parser.php' );
	$parser = new Parser( $args );

//	$parser->test();

	$elements = $parser->start();

	foreach ( $elements as $el ) {
		echo $el . '<br />';
	}
}

add_action( 'admin_menu', 'prsrmngr_admin_menu' );