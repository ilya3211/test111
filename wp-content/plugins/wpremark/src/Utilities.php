<?php

namespace Wpshop\WPRemark;

class Utilities {

    /**
     * Get IP
     *
     * @return mixed
     */
    public static function get_ip() {
        if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        return $ip;
    }

    public static function encodeURIComponent( $str ) {
        $revert = [ '%21' => '!', '%2A' => '*', '%27' => "'", '%28' => '(', '%29' => ')' ];

        return strtr( rawurlencode( $str ), $revert );
//        return strtr( urlencode( $str ), $revert );
    }
}