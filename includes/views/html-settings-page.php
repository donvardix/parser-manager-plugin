<div class="wrap">
    <h1><?php _e( 'Title Name Page', 'plugin-name' ); ?></h1>
    <form method="POST" action="">
        <table class="form-table">
            <tr>
                <th scope="row"><?php _e( 'Options1', 'plugin-name' ); ?></th>
                <td>
                    <input name='plgnnm_options1' type='text' value='<?php echo 'options1'; ?>' />
                </td>
            </tr>
            <tr>
                <th scope="row"><?php _e( 'Options2', 'plugin-name' ); ?></th>
                <td>
                    <input name='plgnnm_options2' type='text' value='<?php echo 'options2'; ?>' />
                </td>
            </tr>
        </table>
        <?php submit_button(); ?>
    </form>
</div>