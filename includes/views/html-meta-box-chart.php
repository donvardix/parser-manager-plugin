<?php extract( $data ); ?>
<div id="parser-chart-container"></div>
<script>
    // Highcharts
    Highcharts.stockChart('parser-chart-container', {
        rangeSelector: {
            selected: 1
        },
        title: {
            text: '<?= $data['title'] ?>'
        },
        series: [
            {
                name: 'Data',
                data: [
                    {
                        x: 1611066600000,
                        y: 130.89,
                        price: 25,
                        args1: 23
                    },
                    {
                        x: 1660915800000,
                        y: 128.91,
                        price: 26
                    },
                    {
                        x: 1666704600000,
                        y: 129.91,
                        price: 27
                    }
                ],
                step: true,
                tooltip: {
                    valueDecimals: 2,
                    pointFormatter: function() {
                        let text = this.series.name + ': ' + this.y;

                        if ( this.args1 ) {
                            text += '<br />Price: ' + this.args1
                        }

                        if ( this.args2 ) {
                            text += '<br />Price: ' + this.args2
                        }

                        return text;
                    }
                }
            }
        ]
    });
</script>
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