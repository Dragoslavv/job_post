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

    public function insert (string $sql, $params,string $argument)
    {
        $conn = $this->_mysqli->prepare($sql);
        $conn->bind_param($argument, $params);
        $conn->execute();
    }

}
