<!-- Icon Bar (Sidebar - hidden on small screens) -->
<nav id="sidebar" class="w3-sidebar w3-bar-block w3-small w3-center hideable">
    <img src="/resources/images/AU.jpg" style="width:100%">

    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
        <input type="submit" name="submitTheme" class="w3-bar-item w3-button w3-padding-large w3-border-bottom w3-hover-<?php echo ($theme); echo (" w3-border-$theme"); ?>" value="CHANGE THEME" />
    </form>

    <a href="/" class="w3-bar-item w3-button w3-padding-large w3-hover-<?php echo ($theme); if ($_SERVER['PHP_SELF'] == '/index.php') {echo (" w3-$theme");} ?>">
        <i class="fa fa-home w3-xxlarge"></i>
        <p>HOME</p>
    </a>

    <button onclick="toggleDropdown()" class="w3-bar-item w3-button w3-padding-large w3-hover-<?php echo ($theme); if ($_SERVER['PHP_SELF'] == '/events.php') {echo (" w3-$theme");} ?>">
        <i class="fa fa-calendar w3-xxlarge"></i>
        <p>EVENTS</p>
        <i class="fa fa-caret-down"></i>
    </button>
    <div id="dropdown-menu" class="w3-hide w3-card w3-animate-opacity w3-border">
        <form method="GET" action="events.php">
            <button type="submit" name="category" class="w3-bar-item w3-button" value="sport">Sports</button>
            <button type="submit" name="category" class="w3-bar-item w3-button w3-border-top" value="culture">Cultural</button>
            <button type="submit" name="category" class="w3-bar-item w3-button w3-border-top" value="other">Others</button>
        </form>
    </div>

    <a id="account" href="/account.php" class="w3-bar-item w3-button w3-padding-large w3-hover-<?php echo ($theme); if ($_SERVER['PHP_SELF'] == '/account.php') {echo (" w3-$theme");} ?>">
        <i class="fa fa-user w3-xxlarge"></i>
        <p>ACCOUNT</p>
    </a>
    <a href="/faq.php" class="w3-bar-item w3-button w3-padding-large w3-hover-<?php echo ($theme); if ($_SERVER['PHP_SELF'] == '/faq.php') {echo (" w3-$theme");} ?>">
        <i class="fa fa-question w3-xxlarge"></i>
        <p>FAQ</p>
    </a>

    <!-- Using GET method to submit logout -->
    <form method="GET" action="index.php">
    <button name="logout" type="submit" class="w3-bar-item w3-button w3-padding-large w3-display-bottomleft w3-leftbar w3-hover-<?php echo ($theme); echo (" w3-border-$theme"); ?>">
        <i class="fa fa-sign-out w3-xxlarge"></i>
        <p>Logout</p>
    </button>
    </form>
</nav>

<!-- Navbar on small screens (Hidden on medium and large screens) -->
<div id="myNavbar" class="w3-top hide" >
    <div class="w3-bar w3-black w3-opacity w3-hover-opacity-off w3-center w3-small">
        <a href="/" class="w3-bar-item w3-button" style="width:25% !important">HOME</a>
        <a href="/" class="w3-bar-item w3-button" style="width:25% !important">EVENTS</a>
        <a href="/" class="w3-bar-item w3-button" style="width:25% !important">ACCOUNT</a>
        <a href="/" class="w3-bar-item w3-button" style="width:25% !important">HELP</a>
    </div>
</div>