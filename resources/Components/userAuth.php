<!-- Checking for POST content  -->
<?php
#region LOGIN HANDLER activates upon successful POST from login form
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submitLogin'])) {
    $name = cleanInput($_POST["username"]);
    $password = cleanInput($_POST["password"]);

    // SYNTACTICAL (serverside) FORM VALIDATION
    if ($name == "" || $password == "") {
        $loginFailReason = "Both fields must be filled out";
    } else if (str_contains($name, " ") || str_contains($password, " ")) {
        $loginFailReason = "Neither field should have any whitespace";
    } else if (strlen($name) > 10) {
        $loginFailReason = "Username should be 10 characters or less";
    } else if (strlen($password) < 3 && strlen($password) >= 16) {
        $loginFailReason = "Password should be between 3 and 16 characters long";
    }

    // Attempts sql query given form passed validation (note: Only taking first row since Username field has UNIQUE constraint)
    if (!isset($loginFailReason)) {
        try {
            $query = prepareQuery('SELECT UUID, Username, Password FROM Users WHERE Username = ?');
            $query->execute(array($name));

            if ($query->rowCount() > 0) {
                $userAccount = $query->fetch();
                if (password_verify($password, $userAccount['Password'])) {
                    $_SESSION["UID"] = $userAccount["UUID"];
                    $_SESSION["username"] = $userAccount["Username"];
                    $_SESSION["authenticated"] = true;
                    header("Location: ".$_SERVER["PHP_SELF"]."?success=login");
                } else {
                    $loginFailReason = "Incorrect username/password";
                }
            } else {
                $loginFailReason = "Incorrect username/password";
            }
            
        } catch (PDOException $e) {
            $loginFailReason = "Database query failed, try again later";
        }
    }
} 
#endregion

#region REGISTRATION HANDLER activates upon successful POST from registration form
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submitRegister'])) {
    $name = cleanInput($_POST["username"]);
    $email = cleanInput($_POST["email"]);
    $password = cleanInput($_POST["password"]);
    $number = cleanInput($_POST["number"]);

    // SYNTACTICAL (serverside) FORM VALIDATION
    if ($name == "" || $password == "" || $email == "" || $number == "") {
        $registerFailReason = "All fields must be filled out";
    } else if (str_contains($name, " ") || str_contains($password, " ") || str_contains($email, " ") ) {
        $registerFailReason = "None of the fields should have any whitespace";
    } else if (strlen($name) > 10) {
        $registerFailReason = "Username should be 10 characters or less";
    } else if (strlen($password) < 3 && strlen($password) >= 16) {
        $registerFailReason = "Password should be between 3 and 16 characters long";
    } else if (!str_contains($email, "@aston.ac.uk")) {
        $registerFailReason = "Email must be an aston email";
    }

    // UNIQUE FORM INPUT VALIDATION
    // I could be more specific and run two queries to find out which field is a duplicate, but the spec didn't specify a need for that and I need to save time
    if (!isset($registerFailReason)) {
        try {
            $query = prepareQuery('SELECT Username FROM Users WHERE Username = ? OR Email = ?');
            $query->execute(array($name, $email));
            if ($query->rowCount() > 0) {
                $registerFailReason = "Username/Email already exists";
            }
        } catch (PDOException $e) {
            $registerFailReason = "Database duplicate validation failed:".$e->getMessage();
        }
    }

    // Commits record to database 
    if (!isset($registerFailReason)) {
        $hashedPass = password_hash($password, PASSWORD_DEFAULT);
        try {
            $query = prepareQuery('INSERT INTO Users (Username, Email, Password, PNumber) VALUES (?, ?, ?, ?)');
            $query->execute(array($name, $email, $hashedPass, $number));

            // Gets UID if registration was successful - 
            $query = prepareQuery('SELECT UUID FROM Users WHERE Username = ?');
            $query->execute(array($name));
            $userAccount = $query->fetch();
            $_SESSION["UID"] = $userAccount["UUID"];
            $_SESSION["username"] = $name;
            $_SESSION["authenticated"] = true;
            header("Location: ".$_SERVER["PHP_SELF"]."?success=registration");

        } catch (PDOException $e) {
            $registerFailReason = "Database query failed, please contact admin";
        }
    }
}
#endregion

#region SUCCESS HANDLER activates if user registered/authenticated properly and displays appropriate message
if (isset($_GET['success']) && $_SESSION['authenticated'] = true) {
    if ($_GET['success'] == "login") { ?>
        <div id="loginNotice" style="display:block" class="w3-modal">
            <div class="w3-modal-content w3-card-4">
                <header class="w3-container modalFormsRGB w3-center w3-padding-16">
                    <span onclick="document.getElementById('loginNotice').style.display = 'none'" class="w3-button w3-xlarge w3-display-topright w3-round-large marginalise">&times</span>
                    <h2 class="w3-wide">Login Successful!</h2>
                </header>
            </div>
        </div>
    <?php } else if ($_GET['success'] == "registration") { ?>
        <div id="registrationNotice" style="display:block" class="w3-modal">
            <div class="w3-modal-content w3-card-4">
                <header class="w3-container modalFormsRGB w3-center w3-padding-16">
                    <span onclick="document.getElementById('registrationNotice').style.display = 'none'" class="w3-button w3-xlarge w3-display-topright w3-round-large marginalise">&times</span>
                    <h2 class="w3-wide">Registration Successful!</h2>
                    <p> Thank you for creating and account with us! </p>
                </header>
            </div>
        </div>
    <?php }
}
#endregion

#region AUTH REQ HANDLER catches any redirects made when a user tries to access a page without permission
if (isset($_GET['required']) && $_GET['required'] == "account") {
    $loginFailReason = "You must be logged in to view that page!";
}
#endregion


// Cleans up user input before server-side form validation
function cleanInput($input)
{
    $output = trim($input);
    $output = stripslashes($input);
    $output = htmlspecialchars($input);
    return $output;
}
?>

<!-- LOGIN MODAL form (activated using js DOM) -->
<div id="loginForm" style="display:<?php if (isset($loginFailReason)) {echo "block";} else {echo "none";} ?>" class="w3-modal">
    <div class="w3-modal-content w3-card-4">
        <header class="w3-container modalFormsRGB w3-center w3-padding-16">
            <span onclick="closeLoginAttempt()" class="w3-button w3-xlarge w3-display-topright w3-round-large marginalise">&times</span>
            <h2 class="w3-wide">Login to Your Account</h2>
            <p>New? Register <a href="javascript:undefined" onclick="switchModal()">here</a></p>
        </header>

        <div class="w3-container modalFormsBody">
            <div id="loginFailMessage" style="display:<?php if(isset($loginFailReason)) {echo 'block';} else {echo 'none';} ?>" class="w3-panel w3-red">
            <h3>Login Failed!</h3>
            <p>Reason: <?php if (isset($loginFailReason)) {echo "$loginFailReason";} else {echo 'null';} ?></p>
        </div> 

            <form method="POST" action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>>
                <p><label><i class="fa fa-user"></i> Username:</label></p>
                <input id="Lusername" name="username" class="w3-input w3-border w3-round" type="text" placeholder="Username" maxlength="10" required>
                <p><label><i class="fa fa-key"></i> Password:</label></p>
                <input id="Lpassword" name="password" class="w3-input w3-border w3-round" type="password" placeholder="Password" maxlength="16" required>
                <div class="centerButton">
                    <button name="submitLogin" type="submit" onclick="return clientLoginValidation()" class="w3-button w3-teal w3-padding-16 w3-section w3-large w3-round-large">
                        Login <i class="fa fa-check"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- REGISTRATION MODAL form (also activated using js DOM, but from the login modal) -->
<div id="registerForm" style="display:<?php if (isset($registerFailReason)) {echo "block";} else {echo "none";} ?>" class="w3-modal">
    <div class="w3-modal-content w3-card-4">
        <header class="w3-container modalFormsRGB w3-center w3-padding-32">
            <span onclick="closeRegisterAttempt()" class="w3-button w3-xlarge w3-display-topright w3-round-large marginalise">&times</span>
            <h2 class="w3-wide">Create an account</h2>
            <p>Already have an account? Login <a href="javascript:undefined" onclick="switchModal()">here</a></p>
        </header>

        <div class="w3-container w3-display-container modalFormsBody">
            <div id="registerFailMessage" style="display:<?php if(isset($registerFailReason)) {echo 'block';} else {echo 'none';} ?>" class="w3-panel w3-red">
            <h3>Registration Failed!</h3>
            <p>Reason: <?php if (isset($registerFailReason)) {echo "$registerFailReason";} else {echo 'null';} ?></p>
        </div> 

            <form method="post" action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>>
                <p><label><i class="fa fa-user"></i> Username:</label></p>
                <input id="Rusername" name="username" class="w3-input w3-border w3-round" type="text" placeholder="JDoe2000" maxlength="10" required>
                <p><label><i class="fa fa-envelope-o"></i> Email:</label></p>
                <input id="email" name="email" class="w3-input w3-border w3-round" type="email" placeholder="xxxxxxxxx@aston.ac.uk" required>
                <p><label><i class="fa fa-key"></i> Password:</label></p>
                <input id="Rpassword" name="password" class="w3-input w3-border w3-round" type="password" placeholder="Password" maxlength="16" required>
                <p><label><i class="fa fa-phone"></i> Mobile Number:</label></p>
                <input id="number" name="number" class="w3-input w3-border w3-round" type="number" placeholder="07138572595" max="99999999999" required>
                <div class="centerButton">
                    <button name="submitRegister" type="submit" onclick="return clientRegisterValidation()" class="w3-button w3-teal w3-padding-16 w3-section w3-large w3-round-large">
                        Create Account <i class="fa fa-plus"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    // Resets login form if closed 
    function closeLoginAttempt() {
        document.getElementById('loginForm').style.display = "none";
        document.getElementById('loginFailMessage').style.display = "none";
        document.getElementById('Lusername').value = "";
        document.getElementById('Lpassword').value = "";
    }

    // Resets register form if closed 
    function closeRegisterAttempt() {
        document.getElementById('registerForm').style.display = "none";
        document.getElementById('registerFailMessage').style.display = "none";
        document.getElementById('Rusername').value = "";
        document.getElementById('email').value = "";
        document.getElementById('Rpassword').value = "";
        document.getElementById('number').value = "";
    }

    // Clientside login form validation
    function clientLoginValidation() {
        var username = document.getElementById("Lusername").value;
        var password = document.getElementById("Lpassword").value;

        // checking for no input/whitespace (using regex)
        if (username == "" || password == "") {
            alert('Username AND Password required!');
            return false;
        } else if (/\s/.test(username) || /\s/.test(password)) {
            alert('Username/Password should NOT contain any spaces!');
            return false;
        }
        return true;
    }

    // Clientside register form validation
    function clientRegisterValidation() {
        var username = document.getElementById("Rusername").value;
        var email = document.getElementById("email").value;
        var password = document.getElementById("Rpassword").value;
        var number = document.getElementById("number").value;

        // checking for no input/whitespace (using regex)
        if (username == "" || email == "" || password == "" || number == "") {
            alert('ALL fields must be filled out!');
            return false;
        } else if (/\s/.test(username) || /\s/.test(email) || /\s/.test(password) || /\s/.test(number)) {
            alert('ALL fields prohibit spaces!');
            return false;
        } else if (password.length <= 3) {
            alert('Password must be longer than 3 characters!')
            return false;
        }
        return true;
    }

    // Switches between login and register modal forms
    function switchModal() {
        if (document.getElementById('loginForm').style.display === "block") {
            document.getElementById('loginForm').style.display = "none"
            document.getElementById('registerForm').style.display = "block"

        } else {
            document.getElementById('loginForm').style.display = "block"
            document.getElementById('registerForm').style.display = "none"

        }

    }

    // Javascript equiv. of htmlspecialChars php function (taken from https://stackoverflow.com/questions/1787322/htmlspecialchars-equivalent-in-javascript), not currently in use
    // function escapeHtml(text) {
    //   var map = {
    //     '&': '&amp;',
    //     '<': '&lt;',
    //     '>': '&gt;',
    //     '"': '&quot;',
    //     "'": '&#039;'
    //   };

    //   return text.replace(/[&<>"']/g, function(m) { return map[m]; });
    // }

    // Toggles between login modal and register modal
</script>