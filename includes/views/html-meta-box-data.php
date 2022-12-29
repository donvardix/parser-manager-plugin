<?php extract( $data ); ?>
<table>
    <tr>
        <th>Data</th>
        <th>Date</th>
    </tr>
    <?php

    $model = new Parser_Model;
    $parser_data = $model->get_parser_by_id( $data['post_id'] );
    foreach ( $parser_data as $datum ) { ?>
        <tr>
            <td><?= $datum->data ?> - </td>
            <td><?= $datum->created ?></td>
        </tr>
    <?php } ?>
</table>
<div class="test_parser">
    <button id="test_request_parser" class="button secondary" type="button">Test Steam Parser</button>
    <div class="result_parser">
        <strong><?php _e( 'Result', 'parser-manager-plugin' ); ?>:</strong> <span id="result_value"></span>
    </div>
</div>