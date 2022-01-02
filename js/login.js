
var usernameL;
var passwordL;
var attempt = 5;
//Variable to count the number of attempts

function validate() {
    //storing input from id to variable
    usernameL = document.getElementById("iUser").value;
    passwordL = document.getElementById("iPass").value;
    for(var i in users){
        var user=users[i];
        if (usernameL == user["username"] && passwordL == user["password"]) { //matching input to the correct input
            window.location = "account.php";//redirect to the account screen
        }
    }
    attempt--; // Decrementing by one.
    alert("Error: Login unsuccessful. You have " + attempt + " attempts left.");
    // Disabling fields after 5 attempts.
    if (attempt == 0) {
        document.getElementById("logbtn").disabled = true;
    }

}