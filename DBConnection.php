<?php

class DBsettion {
    private $dsn='mysql:dbname=attendance;host=localhost;charset=utf8';
    private $dbh;
    private $stmt;
    public $sql;

    public function __construct () {
        $this->dbh = new PDO($this->dsn, "root", "");
        $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    public function setSql($sql,$array){
        $this->sql=$sql;
        $stmt=$this->dbh->prepare($this->sql);
        $stmt->execute($array);
        return $stmt;
    }
    public function getNullStmt(){
        return $this->stmt;
    }
}