<?php extract( $values ); ?>
<table class="form-table">
    <tr>
        <th><label for="prsrmngr_link"><?php _e( 'Link', 'parser-manager-plugin' ); ?></label></th>
        <td>
            <input id="prsrmngr_link" name="prsrmngr_link" type="text" value="<?php echo $prsrmngr_link; ?>" />
        </td>
    </tr>
    <tr>
        <th><label for="prsrmngr_method"><?php _e( 'Method', 'parser-manager-plugin' ); ?></label></th>
        <td>
            <select name="prsrmngr_method" id="prsrmngr_method">
                <option value="xpatch"<?php selected( 'xpatch', $prsrmngr_method ); ?>>XPatch</option>
                <option value="selector"<?php selected( 'selector', $prsrmngr_method ); ?>>Start/End Selector</option>
            </select>
        </td>
    </tr>
    <tr class="xpatch_method">
        <th><label for="prsrmngr_xpatch"><?php _e( 'XPatch', 'parser-manager-plugin' ); ?></label></th>
        <td>
            <input id="prsrmngr_xpatch" name="prsrmngr_xpatch" type="text" value="<?php echo $prsrmngr_xpatch; ?>" />
        </td>
    </tr>
    <tr class="selector_method">
        <th><label for="prsrmngr_start"><?php _e( 'Start Selector', 'parser-manager-plugin' ); ?></label></th>
        <td>
            <input id="prsrmngr_start" name="prsrmngr_start" type="text" value="<?php echo $prsrmngr_start; ?>" />
        </td>
    </tr>
    <tr class="selector_method">
        <th><label for="prsrmngr_end"><?php _e( 'End Selector', 'parser-manager-plugin' ); ?></label></th>
        <td>
            <input id="prsrmngr_end" name="prsrmngr_end" type="text" value="<?php echo $prsrmngr_end; ?>" />
        </td>
    </tr>
</table>
<div class="test_parser">
    <button class="button secondary" type="button">Test Parser</button>
    <div class="result_parser"><strong><?php _e( 'Result', 'parser-manager-plugin' ); ?>:</strong> <span id="result_value"></span></div>
</div>