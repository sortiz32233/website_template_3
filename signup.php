<?php
# Escaping strings xss
function e($string){
  return(htmlspecialchars($string, ENT_QUOTES, "UTF-8"));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <!--  Metadata-->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!--  Browser Icon  -->
  <link rel="icon" href="favicon.ico">
  <!--  Bootstrap(s)  -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
    integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
  <!--  Jquery link(s)  -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <!--  React.js libraries  -->
  <script src="https://unpkg.com/react@16/umd/react.development.js" crossorigin></script>
  <script src="https://unpkg.com/react-dom@16/umd/react-dom.development.js" crossorigin></script>
  <script src="https://unpkg.com/babel-standalone@6/babel.min.js"></script>
  <!-- Font awesome kit  -->
  <script src="https://kit.fontawesome.com/b82b391bad.js" crossorigin="anonymous"></script>
  <!-- Font links -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href='https://fonts.googleapis.com/css?family=Bebas Neue' rel='stylesheet'>
  <link href='https://fonts.googleapis.com/css?family=Play' rel='stylesheet'>
  <link href='https://fonts.googleapis.com/css?family=Patua One' rel='stylesheet'>
  <!--  My CSS and JS  -->
  <script type="text/jsx" src="index.js"></script>
  <link rel="stylesheet" href="style.css">
  <title>Design 3</title>
</head>
<body>
  <?php
  session_start();
   ## Turn off all notices
  error_reporting(E_ALL & ~E_NOTICE);
  ######## Define database vars
  define("DB_SERVER","localhost:3307");
  define("DB_USERNAME","root");
  define("DB_PASSWORD","");
  define("DB_NAME","test");
  ###### Connecting to the database
  $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
  #### Mark error in connection
  if ($connection == false) {
    echo "<div class='cont'>
            <div id='wavy'> 
              <h1>Logo</h1>
              <h1>Something went wrong, try again later</h1>
            </div>
          </div>";  
    }
    ######## Getting data from input fields
      # Making salt
    $salt = rand();
      # Username
    $uname = mysqli_real_escape_string($connection, $_POST["uname"]);
      # Password + adding salt
    $pass = mysqli_real_escape_string($connection, $_POST["password"].$salt);
      # Hashing the password (WITH SALT)
    $hashed_password = hash("sha512", $pass);
      # Email
    $email = mysqli_real_escape_string($connection, $_POST["email"]);
    #### Appending data to the database
    $append_query = "INSERT INTO `Users` (uname, pass, email, salt) VALUES ('$uname', '$hashed_password', '$email', '$salt')";
    #### Checking for existing username
    $query = "SELECT `uname` FROM `Users` WHERE `uname` = '$uname'";
      ## Getting uname
    $logged_uname = mysqli_query($connection,$query);
    $logged_uname = mysqli_fetch_row($logged_uname);
    $logged_uname = $logged_uname[0];
      #### Checking for existing email
    $email_query = "SELECT `email` FROM `Users` WHERE `email` = '$email'";
    ##### Output(s)
    ## Check for successful appending
    if ($connection->query($append_query) === TRUE) {
      echo "<div class='cont'>
            <div id='wavy'> 
              <h1>Logo</h1>
              <h1>Congratulations!<br>You are now signed up.</h1><br>
              <h2>Go back and log in</h2>
              <a href='index.html'><button type='button'>Home</button></a>
            </div>
          </div>";
    }
    ## If the username is the same
    else if($logged_uname == $uname){
      echo "<div class='cont'>
            <div id='wavy'> 
              <h1>Logo</h1>
               <h1>This username is taken, try another one.</h1>
              <h2>Go to the main page an try again</h2>
              <a href='index.html'><button type='button'>Home</button></a>
            </div>
          </div>";
    }
    ## If any error occurs
    else{
      echo "<div class='cont'>
            <div id='wavy'> 
              <h1>Logo</h1>
               <h1>Please Try again later...  :( </h1>
            </div>
          </div>";
    }
    #closing the connection
    mysqli_close($connection);
  ?>
  <!-- Footer -->
  <div id="footer"></div>
</body>
</html>