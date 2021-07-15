<?php


class Parser_Manager_Settings {

    public function parser_output() {
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

	public function parsers_page() { ?>
        <div class="wrap">
            <form action="" method="post">
                <input type="submit" name="parser_start" value="Start">
            </form>
            <?php $this->parser_output(); ?>
        </div>
    <?php }

	public function add_new_parser() {
        if ( isset( $_POST['submit'] ) ) {
            $fields = array(
                'name'  => sanitize_text_field( $_POST['prsrmngr_name'] ),
                'url'   => esc_url( $_POST['prsrmngr_link'] ),
                'start' => stripcslashes( $_POST['prsrmngr_start'] ),
                'end'   => stripcslashes( $_POST['prsrmngr_end'] )
            );
            $model = new Model();
            $model->set_parser( $fields );
        }

        require_once __DIR__ . '/views/html-add-new-page.php';
    }

	public function settings_page() {
        if ( isset( $_POST['submit'] ) ) {
            echo 'submit';
        }

        require_once __DIR__ . '/views/html-settings-page.php';
    }

	public function parsers_test_page() {
		require_once __DIR__ . '/views/html-parsers-test-page.php';
	}

}