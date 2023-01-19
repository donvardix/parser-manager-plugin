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
                data: <?= $data['highcharts_data'] ?>,
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