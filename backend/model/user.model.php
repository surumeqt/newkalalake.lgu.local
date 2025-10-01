<?php
require_once '../config/database.config.php';

class user{
  
  private $conn;

  public function __construct(){
    $db = new Connection();
    $this->conn = $db->connect();
  }
  public function login($username, $password){

    $sql = $this->conn->prepare("SELECT * FROM users WHERE username =?");
    $sql->execute([$username]);
    $user = $sql->fetch();
     if($user && password_verify($password, $user['password'])){
      return  $user;
     }
     return false;


  }

}
