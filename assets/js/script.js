( function( $ ) {
    $( document ).ready( function() {

        let method = $( '#prsrmngr_method' )

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

        $( '#test_request_parser' ).on('click', function() {
            $.post( ajaxurl,
                {
                    action: 'test_request_parser',
                    post_id: $( '#post_ID' ).val()
                },
                response => {
                    console.log(response)
                }
            )
        })

    } );
} )( jQuery );