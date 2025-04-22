<?php

function afs_get_sticky_items() 


add_action( 'wp_footer', 'afs_get_sticky_items' );


/*--Clean Up Shortcode--*/


function afs_clean_shortcodes( $content ) {
    $array   = [
        '<p>['    => '[',
        ']</p>'   => ']',
        ']<br />' => ']',
    ];
    $content = strtr( $content, $array );
    return $content;
}
add_filter( 'the_content', 'afs_clean_shortcodes' );
