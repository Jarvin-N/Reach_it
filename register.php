<?php
// Meraaj Habib
// Register Page for ReachIt.Online
// PHP
session_start();
include "php/db.php";

if(isset($_SESSION["logged"])){
    header("Location: account.php");
}

// THIS CODE RUNS ON PAGE LOAD
$conn = db();

// Get the user table
$sqlU = "SELECT * FROM users";
$resultU = $conn->query($sqlU) or die($conn->error);

// Make array of all users
$users = array();
while ($selection = $resultU->fetch_assoc()) {
    $user = array();
    // For each loop
    foreach ($selection as $property => $value) {
        if($property == "id"){
            $value = (int) $value;
        }
        $user[$property] = $value;
    }
    array_push($users, $user);
}

//Creating variables from the form
if (isset($_POST["username"]) && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["password_confirm"])) {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $password_confirm = $_POST["password_confirm"];
}

else {
    $username = null;
    $email = null;
    $password = null;
    $password_confirm = null;
}

// Loop through database to see if the user exists
function existsUsername($user_input, $users){
    for($i = 0; $i < count($users); $i++){
        $user = $users[$i];
        if($user_input == $user["username"]){
            return true;
        }
    }
    return false;
}

// Loop through database to see if the user exists
function existsEmail($user_input, $users){
    for($i = 0; $i < count($users); $i++){
        $user = $users[$i];
        if($user_input == $user["email"]){
            return true;
        }
    }
    return false;
}

//Check if the form is empty
if(empty($username) || empty($email) || empty($password) || empty($password_confirm)) {

}

//Inserting the user to the database
else {
    $id = count($users);
    $orders = json_encode([], JSON_PRETTY_PRINT);
    if(!(existsUsername($username, $users) || existsEmail($email, $users))) {
        if($password == $password_confirm) {
            $sql = "INSERT INTO users (id, username, password, email, orders) VALUES ('$id', '$username', '$password', '$email', '$orders')";
            if (!mysqli_query($conn, $sql)) {

            } else {
                header("Location: login.php");
            }
        }
        else {
            echo "<script>\n";
            echo "alert('The passwords did not match.');";
            echo "\n</script>";
        }
    }
    else {
        echo "<script>\n";
        echo "alert('That user already exists.');";
        echo "\n</script>";
    }
}



?>

<!DOCTYPE html>
<html lang="en">

<head>

    <!-- SEO and Metadata-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Register - ReachIt</title>

    <!-- Core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
    <link rel="stylesheet" href="css/core.css">

    <!-- Core JS -->
    <script src="js/core.js"></script>

    <!-- Individual CSS and JS -->
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/register.css">

</head>

<body>
<?php
readfile("nav.html");
?>

    <form class="form-signin" action="" method="post">
        <div class="text-center mb-4">
            <h1 class="h3 mb-3 font-weight-bold">Let's get started.</h1>
        </div>

        <div class="form-label-group">
            <input type="text" name="username" id="username" class="form-control" placeholder="Username" required autofocus>
            <label for="username"><i style="font-size: 14px;" class="fas fa-user"></i> Username</label>
        </div>

        <div class="form-label-group">
            <input type="text" name="email" id="email" class="form-control" placeholder="Email" required autofocus>
            <label for="email"><i style="font-size: 14px;" class="fas fa-envelope"></i> Email</label>
        </div>

        <div class="form-label-group">
            <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
            <label for="password"><i style="font-size: 14px;" class="fas fa-lock"></i>  Password</label>
        </div>

        <div class="form-label-group">
            <input type="password" name="password_confirm" id="password_confirm" class="form-control" placeholder="Confirm Password" required>
            <label for="password_confirm"><i style="font-size: 14px;" class="fas fa-unlock"></i>  Confirm Password</label>
        </div>

        <button class="btn btn-lg btn-primary btn-block mb-3" type="submit" name="registerbutton">REGISTER</button>
        <p class="mt-3 mb-3 text-center">Already have an account? <a href="login.php">Login</a></p>
    </form>

    <script src="js/register.js"></script>

</body>

</html>