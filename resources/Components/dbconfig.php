<?php

//Elected to just use SQL statement directly
// $getCredentials = 'SELECT UUID, Username, Password FROM Users WHERE Username = ?';
// $checkCredentials = '';
// $setCredentials = '';

//Creates db connection if one doesn't already exist and prepares it with the given query (required to prevent repetition)
function prepareQuery($query) {
    $servername = "[INSERT_DATABASE_SERVER_DOMAIN]";
    $username = "[INSERT_DATABASE_USERNAME]";
    $password = "[INSERT_DATABASE_USER_PASSWORD]";
    $dbname = "[INSERT_DATABASE_NAME]";
    if (!isset($conn)) {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    $query = $conn->prepare($query);
    return $query;
}

?>