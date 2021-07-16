<div class="wrap prsrmngr">
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
                <th><label for="prsrmngr_method"><?php _e( 'Method', 'parser-manager-plugin' ); ?></label></th>
                <td>
                    <select name="prsrmngr_method" id="prsrmngr_method">
                        <option value="xpatch">XPatch</option>
                        <option value="selector">Start/End Selector</option>
                    </select>
                </td>
            </tr>
            <tr class="xpatch-method">
                <th><label for="prsrmngr_xpatch"><?php _e( 'XPatch', 'parser-manager-plugin' ); ?></label></th>
                <td>
                    <input id="prsrmngr_xpatch" name="prsrmngr_xpatch" type="text" />
                </td>
            </tr>
            <tr class="selector-method">
                <th><label for="prsrmngr_start"><?php _e( 'Start Selector', 'parser-manager-plugin' ); ?></label></th>
                <td>
                    <input id="prsrmngr_start" name="prsrmngr_start" type="text" />
                </td>
            </tr>
            <tr class="selector-method">
                <th><label for="prsrmngr_end"><?php _e( 'End Selector', 'parser-manager-plugin' ); ?></label></th>
                <td>
                    <input id="prsrmngr_end" name="prsrmngr_end" type="text" />
                </td>
            </tr>
        </table>
        <p class="submit">
            <button class="button" type="button" name="test" id="prsrmngr_test"><?php _e( 'Test', 'parser-manager-plugin' ); ?></button>
	        <?php submit_button( 'Add Parser', 'primary', 'submit', false ); ?>
        </p>
    </form>
</div>