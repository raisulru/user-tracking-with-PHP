<?php
/**
 * Created by PhpStorm.
 * User: Dragan
 * Date: 5.11.14
 * Time: 21:59
 */




class DBConnect {
    private $host;
    private $database;
    private $username;
    private $password;
    private $port;
    private $connection=NULL;

    

    public function connectDatabase()
    {
         $connection = mysqli_connect("localhost" , "raisul" , "redhat" , "useronline");
         if (mysqli_connect_errno()) {
            die("Database connection failed: ".
                mysqli_connect_error().
                " (" . mysqli_connect_errno(). ")"
                );
         }
         
        return $connection;
    }


    public function CloseDataBaseConncection()
    {
        if (isset($connection)) {
            mysqli_close($connection);
        }
    }



    /**
     * @param string $database
     */
    public function setDatabase($database)
    {
        $this->database = $database;
    }

    /**
     * @return string
     */
    public function getDatabase()
    {
        return $this->database;
    }

    /**
     * @param string $host
     */
    public function setHost($host)
    {
        $this->host = $host;
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    // /**
    //  * @param string $port
    //  */
    // public function setPort($port)
    // {
    //     $this->port = $port;
    // }

    // /**
    //  * @return string
    //  */
    // public function getPort()
    // {
    //     return $this->port;
    // }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $connection
     */
    public function setConnection($connection)
    {
        $this->connection = $connection;
    }

    /**
     * @return mixed
     */
    public function getConnection()
    {
        return $this->connection;
    }
} 