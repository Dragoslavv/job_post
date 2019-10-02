<?php
class Session{
    /** Session start */
    public static function start()
    {
        if( !headers_sent() && !session_id() ){
            if( session_start() ){
                session_regenerate_id();
                return true;
            }
        }
        return false;
    }
    /** Set time for cookie */
    public static function cookie( $lifetime )
    {
        session_set_cookie_params ( $lifetime );
        setcookie( session_name(),session_id(),time() + $lifetime );
    }
    /** Started Get key,val */
    public static function setOneParam( $key,$default )
    {
        return $_SESSION[ $key ] = $default;
    }

    public static function setTwoParam( $key, $key2 , $default )
    {
        return $_SESSION[ $key ][ $key2 ] = $default;
    }

    public static function getSession( $params )
    {
        return $_SESSION[ $params ];
    }

    public static function getSessionTwoParams( $params1, $params2 )
    {
        return $_SESSION[ $params1 ][ $params2 ];
    }

    /** Chacking if you session delete that logout*/
    public static function delete( $Key )
    {
        unset( $_SESSION[ $Key ] );
        session_destroy();
        //         return false;
    }

    public static function name ($session_name) {
        session_name($session_name);
    }

    /** Redirect on customer page */
    public static function redirectAdmin( $Key,$redirectAdmin )
    {
        if ( !isset( $_SESSION[ $Key ] ) ){
            header('location: ' . $redirectAdmin);
            die();
        }
    }
    /** Redirect on admin page */
    public static function redirect( $Key,$redirect )
    {
        if( isset( $_SESSION[ $Key ] ) ){
            header('Location: ' . $redirect );
            die();
        }
    }
}