jQuery( document ).ready( function( $ ) {

    // Parser Settings
    let method = $( '#parser_method' )

    initParserMethod()
    method.change( initParserMethod )

    function initParserMethod() {
        $( '.methods' ).hide();

        switch ( method.val() ) {
            case 'xpatch':
                $( '.xpatch' ).show()
                break;
            case 'selector':
                $( '.selector' ).show()
        }
    }



    // Steam Parser
    $( '#test_request_parser' ).on('click', function() {
        $.post( ajaxurl,
            {
                action: 'test_request_parser',
                post_id: $( '#post_ID' ).val(),
                parser_link: $( '#parser_link' ).val()
            },
            response => {
                $( '.result_parser' ).show()
                if ( true === response.success ) {
                    $( '#result_value' ).text( response.data.result )
                } else {
                    $( '#result_value' ).text( 'Error: ' + response.data )
                }
            }
        )
    })
} );