<?php extract( $data ); ?>
<div id="parser-chart-container"></div>
<script>
    // Highcharts
    Highcharts.stockChart('parser-chart-container', {
        chart: {
            events: {
                load: function() {
                    const chart = this,
                        series = chart.series[0],
                        dataMin = chart.xAxis[0].dataMin,
                        dataMax = chart.xAxis[0].dataMax,
                        offset = (dataMax - dataMin) / 100;

                    series.addPoint([dataMax + 186400000, null]);

                    chart.xAxis[0].setExtremes(dataMin, dataMax + offset)

                    chart.xAxis[1].update({
                        max: dataMax + offset
                    })
                }
            }
        },
        rangeSelector: {
            selected: 0
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
                    xDateFormat: '%d.%m.%Y<br />%H:%M',
                    valueDecimals: 2,
                    pointFormatter: function() {
                        let text = this.series.name + ': ' + this.y;

                        if ( this.a1 ) {
                            text += '<br />Price: ' + this.a1
                        }

                        // if ( this.a2 ) {
                        //     text += '<br />Price: ' + this.a2
                        // }

                        return text;
                    }
                }
            }
        ]
    });
</script>