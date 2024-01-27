<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["minnanchal1"];
    $password = $_POST["kadavuchchol1"];

    // Read existing user data from the file
    $existingUsers = file_get_contents('users.json');

    if ($existingUsers === false) {
        // Error reading file, handle accordingly
        echo "Error reading file!";
        exit();
    }

    // Decode JSON data
    $existingUsers = json_decode($existingUsers, true);

    if ($existingUsers === null) {
        // Error decoding JSON, print error and handle accordingly
        echo "Error decoding JSON!";
        exit();
    }

   /* // Check if the email and password match any user in the array
    foreach ($existingUsers as $user) {
        if ($user['email'] == $email && password_verify($password, $user['Password'])) {
            // User found, set session variables and redirect to a success page
            $_SESSION['email'] = $user['email'];
           // header("Location: success.html");
            //exit();
            //echo 'login successful';
        }
    }

    // If no matching user found, redirect to login page with an error parameter
   header("Location: fail.html");
    exit(); */

    // Check if the email and password match any user in the array
$loginSuccessful = false; // Flag to track login success

foreach ($existingUsers as $user) {
    if ($user['email'] == $email && password_verify($password, $user['Password'])) {
        // User found, set session variables and mark login as successful
        $_SESSION['email'] = $user['email'];
        $loginSuccessful = true;
        break; // No need to continue checking if login is successful
    }
}

// Redirect based on login success
if ($loginSuccessful) {
    header("Location: ../index.html");
    exit();
} else {
   // header("Location: fail.html");
    //exit();
    echo 'wrong password';
}

   
}
?>
