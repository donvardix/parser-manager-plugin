<?php

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( ! class_exists('Frontend_Settings') ) {


class Frontend_Settings {

	function __construct() {
	}

	function parser_output() {
		$model = new Model();

		if ( isset( $_POST['parser_start'] ) ) {
			$model->parser_init();
		}

		$parser_names = $model->get_parser_names();
		foreach ( $parser_names as $parser ) {
			echo '<a href="?page=parser-manager-plugin.php&id=' . $parser->id . '">' . $parser->name . '</a><br />';
		}

		if ( isset( $_GET['id'] ) ) {
			echo '<hr />';

			echo '<table>';
			$parser_data = $model->get_parser_by_id( $_GET['id'] );
			foreach ( $parser_data as $data ) {
				echo "<tr><td>{$data->updated}</td><td>{$data->value}</td></tr>";
			}
			echo '</table>';
		}
	}

	function parsers_page() { ?>
		<div class="wrap">
			<form action="" method="post">
				<input type="submit" name="parser_start" value="Start">
			</form>
			<?php $this->parser_output(); ?>
		</div>
	<?php }

	function add_new_parser() {
		if ( isset( $_POST['prsrmngr_add_parser'] ) ) {
		    $fields = array(
			    'name'  => sanitize_text_field( $_POST['prsrmngr_name'] ),
			    'url'   => esc_url( $_POST['prsrmngr_link'] ),
			    'start' => stripcslashes( $_POST['prsrmngr_start'] ),
			    'end'   => stripcslashes( $_POST['prsrmngr_end'] )
		    );
			$model = new Model();
			$model->set_parser( $fields );
		} ?>
        <div class="wrap">
            <form action="" method="post">
                <table class="form-table">
                    <tr>
                        <th><?php _e( 'Name', 'plugin-name' ); ?></th>
                        <td>
                            <input name="prsrmngr_name" type="text" />
                        </td>
                    </tr>
                    <tr>
                        <th><?php _e( 'Link', 'plugin-name' ); ?></th>
                        <td>
                            <input name="prsrmngr_link" type="text" />
                        </td>
                    </tr>
                    <tr>
                        <th><?php _e( 'Start Selector', 'plugin-name' ); ?></th>
                        <td>
                            <input name="prsrmngr_start" type="text" />
                        </td>
                    </tr>
                    <tr>
                        <th><?php _e( 'End Selector', 'plugin-name' ); ?></th>
                        <td>
                            <input name="prsrmngr_end" type="text" />
                        </td>
                    </tr>
                </table>
                <input type="submit" name="prsrmngr_add_parser" class="button button-primary" value="Add Parser">
            </form>
        </div>
	<?php }

	function settings_page() {
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

}

new Frontend_Settings();

} // class_exists check