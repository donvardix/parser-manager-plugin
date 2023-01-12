jQuery( document ).ready( function( $ ) {

    // Plugin Settings
    let method = $( '#parser_method' )

    if ( 'selector' === method.val() ) {
        $( '.xpatch_method' ).hide();
        $( '.selector_method' ).show();
    }

    method.change(function() {
        if ( 'xpatch' === $( this ).val() ) {
            $( '.xpatch_method' ).show();
            $( '.selector_method' ).hide();
        } else {
            $( '.xpatch_method' ).hide();
            $( '.selector_method' ).show();
        }
    });



    // Steam Parser
    $( '#test_request_parser' ).on('click', function() {
        $.post( ajaxurl,
            {
                action: 'test_request_parser',
                post_id: $( '#post_ID' ).val(),
                parser_link: $( '#parser_link' ).val()
            },
            response => {
                if ( true === response.success ) {
                    $( '#result_value' ).text( response.data.result )
                } else {
                    $( '#result_value' ).text( 'Error: ' + response.data )
                }
            }
        )
    })

    // Highcharts
    Highcharts.stockChart('container', {
        rangeSelector: {
            selected: 1
        },
        title: {
            text: 'AAPL Stock Price1'
        },
        series: [
            {
                name: 'AAPL Stock Price3',
                data: [
                    {
                        x: 1610548200000,
                        y: 130.89,
                        price: 25
                    },
                    {
                        x: 1610634600000,
                        y: 128.91,
                        price: 26
                    },
                    {
                        x: 1610734600000,
                        y: 129.91,
                        price: 27
                    }
                ],
                step: true,
                tooltip: {
                    valueDecimals: 2,
                    pointFormatter: function() {
                        return 'Count: <b>' + this.y + '</b>, <br> Price '+ this.price;
                    }
                }
            }
        ]
    });

} );