<?php
class User
{
  public $id;
  public $email;
  public $password;
  public $name;
  public $birthdate;
  public $city;
  public $work;
  public $avatar;
  public $cover;
  public $token;
}
interface UserDAO
{
  // login.php
  public function findByToken($token);
  public function findByemail($email);
  public function update(User $u);


  //signup.php
  //public function insert(User $u);
}
