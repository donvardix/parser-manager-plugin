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
        <form action="" method="post">
            <input type="submit" name="parser_start" value="Start">
        </form>
        <?php prsrmngr_parser_output(); ?>
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

function prsrmngr_parser_output() {
    global $wpdb;

//	$result = $wpdb->get_results( $wpdb->prepare(
//		"SELECT `name`, `value` FROM `{$wpdb->prefix}prsrmngr_parser_data`
//        LEFT JOIN `{$wpdb->prefix}prsrmngr_parser` ON `{$wpdb->prefix}prsrmngr_parser_data`.`parser_id` = `{$wpdb->prefix}prsrmngr_parser`.`id`"
//	) );

	if ( isset( $_POST['parser_start'] ) ) {
		$result = $wpdb->get_results(
			"SELECT `id`, `url`, `start`, `end` FROM `{$wpdb->prefix}prsrmngr_parser`", ARRAY_A
		);

		require_once( 'includes/Parser.php' );
		$parser = new Parser( $result );

//	$parser->test();

		$elements = $parser->start();

		foreach ( $elements as $parser_id => $value ) {
			$wpdb->insert( $wpdb->prefix . 'prsrmngr_parser_data',
				array( 'value' => $value, 'parser_id' => $parser_id ),
				array( '%s', '%s' )
			);
		}
    }
}

function prsrmngr_settings() {

}

function prsrmngr_db_create() {
	global $wpdb;

	$sql = "CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "prsrmngr_parser` (
			id bigint NOT NULL AUTO_INCREMENT,
			name varchar(55) NOT NULL,
            url text NOT NULL,
            start text NOT NULL,
            end text NOT NULL,
            updated datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
			UNIQUE KEY id (id)
		);";
	$wpdb->query( $sql );

	$sql = "CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "prsrmngr_parser_data` (
			id bigint NOT NULL AUTO_INCREMENT,
			value text NOT NULL,
            parser_id bigint NOT NULL,
            updated datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
			UNIQUE KEY id (id)
		);";
	$wpdb->query( $sql );
}

function prsrmngr_delete_options() {
	global $wpdb;

//	delete_option( 'wp_simyz_chat_username' );
//	$wpdb->query( "DROP TABLE IF EXISTS `" . $wpdb->prefix . "simyzchat_questions`;" );
}

function prsrmngr_activation() {
	prsrmngr_settings();
	prsrmngr_db_create();
	register_uninstall_hook( __FILE__, 'prsrmngr_delete_options' );
}

register_activation_hook( __FILE__, 'prsrmngr_activation' );

add_action( 'admin_menu', 'prsrmngr_admin_menu' );