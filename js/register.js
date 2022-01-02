// Meraaj Habib
// Register Page for ReachIt.Online
// Javascript

// On register button click
function register(){
    // Get values from HTML
    let un = document.getElementById("username").value;
    let em = document.getElementById("email").value;
    let pw = document.getElementById("password").value;
    let cpw = document.getElementById("password_confirm").value;
    let id = users.length;
    // Check if username or email exists
    if (existsUsername(un) == true){
        error("That username is already in use.");
        return;
    }
    if (existsEmail(em) == true){
        error("That email is already in use.");
        return;
    }
    else{
        // Check if the passwords match
        if(pw == cpw){
            // Add temp user to local storage
            var user = new User(id, un, em, pw);
            localStorage.setItem("tempU", JSON.stringify(user));
            window.location = "account.php";
        }
        else {
            error("The passwords do not match.");
            return;
        }
    }
}



// Loop through database to see if the user exists
function existsUsername(user_input){
    for(let i in users){
        let user = users[i];
        if(user_input === user.username){
            return true;
        }
    }
    return false;
}

// Loop through database to see if the user exists
function existsEmail(user_input){
    for(let i in users){
        let user = users[i];
        if(user_input === user.email){
            return true;
        }
    }
    return false;
}

// Error message in HTML
function error(text){
    alert("Error: " + text);
}