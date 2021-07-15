<div class="wrap">
    <h1><?php _e( 'Add New Parser', 'parser-manager-plugin' ); ?></h1>
    <form method="POST" action="">
        <table class="form-table">
            <tr>
                <th><label for="prsrmngr_name"><?php _e( 'Name', 'parser-manager-plugin' ); ?></label></th>
                <td>
                    <input id="prsrmngr_name" name="prsrmngr_name" type="text" />
                </td>
            </tr>
            <tr>
                <th><label for="prsrmngr_link"><?php _e( 'Link', 'parser-manager-plugin' ); ?></label></th>
                <td>
                    <input id="prsrmngr_link" name="prsrmngr_link" type="text" />
                </td>
            </tr>
            <tr>
                <th><label for="prsrmngr_start"><?php _e( 'Start Selector', 'parser-manager-plugin' ); ?></label></th>
                <td>
                    <input id="prsrmngr_start" name="prsrmngr_start" type="text" />
                </td>
            </tr>
            <tr>
                <th><label for="prsrmngr_end"><?php _e( 'End Selector', 'parser-manager-plugin' ); ?></label></th>
                <td>
                    <input id="prsrmngr_end" name="prsrmngr_end" type="text" />
                </td>
            </tr>
        </table>
        <p class="submit">
	        <?php submit_button( 'Test', 'secondary', 'test', false ); ?>
	        <?php submit_button( 'Add Parser', 'primary', 'submit', false ); ?>
        </p>
    </form>
</div>