( function( $ ) {

    console.log( 'test' );

    $( '#prsrmngr_test' ).on( 'click', function() {
        console.log( $( this ) );
        console.log( 'test2' );
    } );

} )( jQuery );