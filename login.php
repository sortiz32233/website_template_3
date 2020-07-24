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
    ######## Getting data from input fields and the database
      # Getting username
    $uname = e($_POST["uname"]);
      # Getting salt
    $salt_query =  "SELECT `salt` FROM `Users` WHERE `uname` = '$uname'";
      # Fetching data
    $salt = mysqli_query($connection,$salt_query);
    $salt = mysqli_fetch_row($salt);
    $salt = $salt[0];
      # Password + salting
    $pass = e($_POST["password"].$salt);
      # Hashing the password
    $hashed_password = hash("sha512",$pass);
      # Get pass from DB
    $password_query = "SELECT `pass` FROM `Users` WHERE `uname` = '$uname'";
    $password = mysqli_query($connection, $password_query);
    $password = mysqli_fetch_row($password);
    $password = $password[0];
    # Login Detection and output
    if($password == $hashed_password){
      echo "<div id='overlay'></div>
            <div class='cont'>
            <div id='wavy'> 
              <div class='settings'>
                <i class='fas fa-user-cog' id='settings' style='font-size:30px;color:black;'></i>
              </div>
              <h1>Logo</h1>
              <h1>Welcome $uname</h1>
            </div>
          </div>";
    }else{
      echo "<div class='cont'>
            <div id='wavy'> 
              <h1>Logo</h1>
              <h1>Wrong password or username</h1><br>
              <h2>Go back and try again</h2>
              <a href='index.html'><button type='button'>Home</button></a>
            </div>
          </div>";
    }
    #closing the connection
    mysqli_close($connection);
  ?>
  <?php
    if($password == $hashed_password){
      echo "<div class='sec-container'>
              <h1>Choose your template.</h1>
              <div class='cards' style='margin-top:30px;'>
               <h2>Template #1</h2>
               <img src='images/design_1.png'>
               <h3>£30</h3>
              </div>
              <div class='cards' style='margin-top:30px;'>
               <h2>Template #2</h2>
               <img src='images/design_2.png'>
               <h3>£50</h3>
              </div>
              <div class='cards'>
               <h2>Template #3</h2>
               <img src='images/prev.png'>
               <h3>£100</h3>
              </div>
              <div class='cards'>
               <h2>Template #4</h2>
               <img src='images/old_website.png'>
               <h3>£40</h3>
              </div>
              <div class='cards'>
               <h2>Template #5</h2>
               <img src='images/template_restaurant.png'>
               <h3>£60</h3>
              </div>
              <div class='cards'>
               <h2>Template #6</h2>
               <img src='images/php_form.png'>
               <h3>£25</h3>
              </div>
            </div>";
    }
  ?>
  <!-- Footer -->
  <div id="footer"></div>
</body>
</html>