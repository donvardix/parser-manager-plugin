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
                name: 'Amount',
                data: <?= $data['highcharts_data'] ?>,
                step: true,
                tooltip: {
                    valueDecimals: 2,
                    pointFormatter: function() {
                        let text = this.series.name + ': ' + this.y;

                        if ( this.a1 ) {
                            text += '<br />Price: ' + this.a1
                        }

                        if ( this.a2 ) {
                            text += '<br />Price: ' + this.a2
                        }

                        return text;
                    }
                }
            }
        ]
    });
</script>