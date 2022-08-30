<?php
require_once 'dao/UserDaomysql.php';
class Auth
{
  public function __construct(PDO $pdo, $base)
  {
    $this->pdo = $pdo;
    $this->base = $base;
  }
  public function checkToken()
  {
    if (!empty($_SESSION['token'])) {
      $token = $_SESSION['token'];
      $userDAO = new UserDaoMysql($this->pdo);
      // usa function of UserDaoMysql 
      $user = $userDAO->findByToken($token);
      if ($user) {
        return $user;
      }
    }
    header('Location:' . $this->base . 'login.php');
    exit;
  }
  public function validateLogin($email, $password)
  {
    $userDAO = new UserDaoMysql($this->pdo);
    $user = $userDAO->findByemail($email);
    if ($user) {
      if (password_verify($password, $user->password)) {
        $token = md5(time() . rand(0, 9999));
        $_SESSION['token'] = $token;
        $user->token = $token;
        $userDAO->update($user);
        return true;
      }
    }
  }
  public function emailsExists($email)
  {
    $userDAO = new UserDaoMysql($this->pdo);
    return $userDAO->findByemail($email) ? true : false;
  }
  public function registerUser($name, $email, $password, $birthdate)
  {
    $userDAO = new UserDaoMysql($this->pdo);
    $newUser = new User();
    $token = md5(time() . rand(0, 9999));
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $newUser->name = $name;
    $newUser->email = $email;
    $newUser->password = $hash;
    $newUser->birthdate = $birthdate;
    $newUser->token = $token;
    $userDAO->insert($newUser);
    $_SESSION['token'] = $token;
  }
}
