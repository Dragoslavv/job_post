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
            $this->_mysqli = new \mysqli("localhost","admin","admin4321","job_posts");
        } catch (\Exception $e) { // Exception handling
            echo 'ERROR:'.$e->getMessage();
        }
    }

    public function select( string $sql )
    {
        $conn = $this->_mysqli->query( $sql );

        if( $conn->num_rows > 0 ) {
            while ( $row = mysqli_fetch_all( $conn )) {
                return $row;
            }
        }

        return false;

    }

    public function update_users (string $sql, array $request, string $format)
    {
        $conn = $this->_mysqli->prepare($sql);
        $conn->bind_param($format, $request[0],$request[1]);
        $conn->execute();
        if($conn->affected_rows === 1){
            return true;
        }
        return false;
    }

    public function remove (string $sql, array $request, string $format) {
        $conn = $this->_mysqli->prepare($sql);
        $conn->bind_param($format, $request[0]);
        return $conn->execute();
    }

    public function insert_users (string $sql, array $request,string $format)
    {

        $conn = $this->_mysqli->prepare($sql);
        $conn->bind_param($format, $request[0], $request[1], $request[2] , $request[3]);
        return $conn->execute();
    }


    public function escape($esc)
    {
        $conn = $this->_mysqli->real_escape_string($esc);
        return $conn;
    }

}
