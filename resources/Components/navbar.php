<!-- Change webpage theme and store choice in cookie (while refreshing page) + import the register/login forms -->
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submitTheme'])) {
        themeChange();
}

//
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['logout'])) {
    session_regenerate_id(FALSE);
    session_unset();
}

//Loads in the login & register forms (considering file name change)
//I could make it so this only imports when the user is logged out, but I use a function in here to manage database connections, so for now I'll keep it
include("$components/userAuth.php");


// I can add another theme just by specifying an addional case below
function themeChange(){
    if (!isset($_COOKIE['theme'])) {
        return;
    }

    switch ($_COOKIE['theme']) {
        case "blue-gray":
            setcookie('theme', 'gray');
            break;
        case "gray":
            setcookie('theme', 'white');
            break;
        default:
            setcookie('theme', 'blue-gray');
            break;
    }
    header("Refresh:0");
}

if (isset($_SESSION["authenticated"])) {
    include("$components/navbar-logged-in.php");
} else {
    include("$components/navbar-logged-out.php");
}
?>

<script>
//Nabbed from w3schools.com for the dropdown menu
function toggleDropdown() {
    var x = document.getElementById("dropdown-menu");
    if (x.className.indexOf("w3-show") == -1) {
        x.className += " w3-show";
    } else { 
        x.className = x.className.replace(" w3-show", "");
    }
}
</script>

