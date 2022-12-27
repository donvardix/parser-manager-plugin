<?php extract( $data ); ?>
<table class="form-table">
    <tr>
        <th><label for="parser_link"><?php _e( 'Link', 'parser-manager-plugin' ); ?></label></th>
        <td>
            <input id="parser_link" name="parser_link" type="text" value="<?php echo $parser_link; ?>" />
        </td>
    </tr>
    <tr>
        <th><label for="parser_method"><?php _e( 'Method', 'parser-manager-plugin' ); ?></label></th>
        <td>
            <select name="parser_method" id="parser_method">
                <option value="xpatch"<?php selected( 'xpatch', $parser_method ); ?>>XPatch</option>
                <option value="selector"<?php selected( 'selector', $parser_method ); ?>>Start/End Selector</option>
            </select>
        </td>
    </tr>
    <tr class="xpatch_method">
        <th><label for="parser_xpatch"><?php _e( 'XPatch', 'parser-manager-plugin' ); ?></label></th>
        <td>
            <input id="parser_xpatch" name="parser_xpatch" type="text" value="<?php echo $parser_xpatch; ?>" />
        </td>
    </tr>
    <tr class="selector_method">
        <th><label for="parser_start"><?php _e( 'Start Selector', 'parser-manager-plugin' ); ?></label></th>
        <td>
            <input id="parser_start" name="parser_start" type="text" value="<?php echo $parser_start; ?>" />
        </td>
    </tr>
    <tr class="selector_method">
        <th><label for="parser_end"><?php _e( 'End Selector', 'parser-manager-plugin' ); ?></label></th>
        <td>
            <input id="parser_end" name="parser_end" type="text" value="<?php echo $parser_end; ?>" />
        </td>
    </tr>
</table>