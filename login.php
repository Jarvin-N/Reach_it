<?php
session_start();
include 'php/db.php';

$conn = db();

if(isset($_SESSION["logged"])){
    header("Location: account.php");
}

// Getting all users
$sql = "SELECT * FROM users";
$result = $conn->query($sql) or die($conn->error);

$users = array();
while ($selection = $result->fetch_assoc()) {
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

if (isset($_POST["iUser"]) && isset($_POST["iPass"])) {
    $username = $_POST["iUser"];
    $pass = $_POST["iPass"];
}

else {
    $username = null;
    $pass = null;
}

//Check if the form is empty
if(empty($username) || empty($pass)) {

}

else {
    for ($i = 0; $i < count($users); $i++) {
        $check_user = $users[$i];
        if ($username == $check_user["username"] && $pass == $check_user["password"]) {
            $_SESSION["logged"] = true;
            $_SESSION["user"] = $check_user["id"];
            header("Location: account.php");
        }
    }
    echo "<script>\n";
    echo "alert('Incorrect login details.');";
    echo "\n</script>";
}



?>

<!-- HTML template -->
<!DOCTYPE html>
<html lang="en">

<head>

    <!-- SEO and Metadata-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login - ReachIt</title>

    <!-- Core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
    <link rel="stylesheet" href="css/core.css">

    <!-- Core JS -->
    <script src="js/core.js"></script>

    <!-- Individual CSS and JS -->
    <link rel="stylesheet" href="css/login.css">

</head>

<!-- Start of BODY -->
<body>

<script src="js/login.js"></script>

<?php
readfile("nav.html");
?>

<form class="form-signin" action="" method="post">
    <div class="text-center mb-4">
        <h1 class="h3 mb-3 font-weight-bold">Get back to shopping!</h1>
    </div>

    <div class="form-label-group">
        <input name="iUser" type="text" id="iUser" class="form-control" placeholder="Username" required autofocus>
        <label for="iUser"><i style="font-size: 14px;" class="fas fa-user"></i> Username</label>
    </div>

    <div class="form-label-group">
        <input name="iPass" type="password" id="iPass" class="form-control" placeholder="Password" required>
        <label for="iPass"><i style="font-size: 14px;" class="fas fa-lock"></i>  Password</label>
    </div>

    <button id="logbtn" class="btn btn-lg btn-primary btn-block" type="submit">LOGIN</button>
    <p class="mt-3 mb-3 text-center">Don't have an account? <a href="register.php">Register</a></p>
</form>

<!-- Framework JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

</body>

</html>