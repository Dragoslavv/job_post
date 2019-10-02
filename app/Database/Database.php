<?php
namespace App\Database;
use App\Database\Singleton as Singleton;

class Database extends Singleton{

    protected $_mysqli;

    /**
     * Database constructor.
     */
    function __construct()
    {
        $this->open_connection();
    }

    private function open_connection()
    {
        try {
            $this->_mysqli = new \mysqli("localhost","admin","Admin_4321","unique_api");
        } catch (\Exception $e) { // Exception handling
            echo 'ERROR:'.$e->getMessage();
        }
    }

    public function select( $sql )
    {
        $conn = $this->_mysqli->query( $sql );

        if( $conn->num_rows > 0 ) {
            while ( $row = mysqli_fetch_all( $conn )) {
                return $row;
            }
        }

        return false;

    }

    public function insert_users (string $sql, array $request,string $format)
    {

        $conn = $this->_mysqli->prepare($sql);
        $conn->bind_param($format, $request[0], $request[1], $request[2], $request[3], $request[4], $request[5], $request[6], $request[7]);
        return $conn->execute();
    }

    public function update_users (string $sql, array $request, string $format){
        $conn = $this->_mysqli->prepare($sql);
        $conn->bind_param($format, $request[0], $request[1]);
        $conn->execute();
        if($conn->affected_rows === 1){
            return true;
        }
    }

    public function escape($esc)
    {
        $conn = $this->_mysqli->real_escape_string($esc);
        return $conn;
    }

}
