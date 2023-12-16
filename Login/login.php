<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Login</title>
    <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f1f1f1;
      margin: 0;
      padding: 0;
    }

    .login-container {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background-color:  rgb(150,150,150);
    }

    .login-form {
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      padding: 90px;
      max-width: 350px;
      height: 500px;
      width: 100%;
    }

    .login-title {
      font-size: 30px;
      font-weight: bold;
      margin-bottom: 100px;
      text-align: center;
      margin-top: 40px;

    }

    .login-input {
      width: 100%;
      padding: 10px;
      margin-bottom: 40px; /*username ile password arasındaki mesafe*/
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    .login-button {
      background-color: #1bb9e1;
      color: #fff;
      cursor: pointer;
      width: 100%;
      padding: 10px;
      border: none;
      border-radius: 5px;
      font-size: 16px;
      box-shadow:10px 10px 10px rgba(0,0,0,0.6);

    }

    .login-button:hover {
      background-color: #1792aa;
    }

    /* Logo Styles */
    .company-logo {
      width: 150px;
      margin-bottom: -40px;
      margin-left: 100px;

    }
    </style>
  </head>
  <body>
    <div class="login-container">
      <form class="login-form" method="POST" action="login.php">
      <img class="company-logo" src="companyLogo.jpeg" alt="Company Logo">

        <div class="login-title">Login</div>
        <div>
          <label for="username">Username:</label>
          <input class="login-input" type="text" name="username" id="username" required>
        </div>
        <div>
          <label for="password">Password:</label>
          <input class="login-input" type="password" name="password" id="password" required>
        </div>
        <button class="login-button" type="submit">Login</button>
      </form>
    </div>

    <?php

    include "/var/www/html/GateBackend/dbconfig.php" ;

    $username = $_POST["username"] ;
    $password = $_POST["password"] ;

    if (!empty($username) && !empty($password)) {

        $check = $connection->prepare("SELECT id FROM users WHERE username = ? AND password = ?");
        $check->bind_param("ss", $username, $password);
        $check->execute();
        $result = $check->get_result();


        if ($result->num_rows === 1) {

            session_start();
            $_SESSION["username"] = $username;
            $_SESSION["loggedin"] = true;

            $check->close();
            $connection->close();

            header("Location: /GateBackend/MainPage/main_page.php");

            exit;

        }else{
          $response = array("success" => false, "error" => "Invalid username or password");
          echo json_encode($response);
        }

    }

    $connection->close();
    
     ?>

  </body>
</html>

