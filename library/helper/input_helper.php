<?php
if ( ! function_exists( 'sanitize_text_field' ) ) {
    function sanitize_text_field($str){
        return $str;
    }
}

if (! function_exists('esc_attr')) {
    function esc_attr( $val ) {
        return $val;
    }
}
if (! function_exists('esc_html')) {
    function esc_html( $val ) {
        return $val;
    }
}
