<?php
require 'config.php';
require 'models/Auth.php';

$name = filter_input(INPUT_POST, 'name');
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$password = filter_input(INPUT_POST, 'password');
$birthdate = filter_input(INPUT_POST, 'birthdate'); // 00/00/0000

if ($email && $password && $name && $birthdate) {
  $auth = new Auth($pdo, $base);
  $birthdate = explode('/', $birthdate);
  if (count($birthdate) != 3) {
    $_SESSION['flash'] = 'Email e/ou  Senha ou data nascimento errado ! 2 ';
    header('Location:' . $base . '/signup.php');
    exit;
  }
  /*$birthdate = $birthdate[2] . '-' . $birthdate[1] . '-' . $birtdate[0];
  if (strtotime($birtdate) === false) {
    $_SESSION['flash'] = 'Email e/ou  Senha ou data nascimento errado ! ';
    header('Location:' . $base . '/signup.php');
    exit;
  }*/
  if ($auth->emailsExists($email) == false) {
    $auth->registerUser($name, $email, $password, $birthdate);
    header('Location:' . $base);

    exit;
  } else {
    $_SESSION['flash'] = 'Email ja Cadastrado! ';
    header('Location:' . $base . '/signup.php');
    exit;
  }
}
$_SESSION['flash'] = 'Email e/ou  Senha estão errado! ';
header('Location:' . $base . '/signup.php');
exit;
