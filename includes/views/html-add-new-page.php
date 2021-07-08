<div class="wrap">
    <h1><?php _e( 'Add New Parser', 'plugin-name' ); ?></h1>
    <form method="POST" action="">
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
        <?php submit_button(); ?>
    </form>
</div>