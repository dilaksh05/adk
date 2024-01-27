<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["iyatpeyar"];
    $username1 = $_POST["suyapeyar"];
    $job=$_POST["tholil"];
    $job1=$_POST["tholil1"];
    $location=$_POST["iruppidam"];
    $houseno=$_POST["homeno"];
    $road=$_POST["Road"];
    $village=$_POST["village"];
    $district=$_POST["district"];
    $state=$_POST["manilam"];
    $country=$_POST["naadu"];

    $aboutme=$_POST["aboutme"];
    $email = $_POST["minnanchal"];

    $phone = $_POST["tholaipesien"];
    $facebook = $_POST["Facebook"];
    $twitter = $_POST["twitter"];
    $linkedin = $_POST["linkedin"];
    $instagram = $_POST["instagram"];
    $whatsapp = $_POST["whatsapp"];
    $telegram = $_POST["telegram"];

    $password = $_POST["kadavuchchol"];
    $password1 = $_POST["kadavuchchol2"];

    // Read existing user data from the file
    $existingUsers = file_get_contents('users.json');

    if ($existingUsers === false) {
        // Error reading file, handle accordingly
        echo "Error reading file.";
        exit();
    }

    // Decode JSON data
    $existingUsers = json_decode($existingUsers, true);

    if ($existingUsers === null) {
        // Error decoding JSON, print error and handle accordingly
        echo "JSON decoding error: " . json_last_error_msg();
        exit();
    }

    // Check if the email already exists
    foreach ($existingUsers as $user) {
        if ($user['email'] == $email) {
            // Email already exists, redirect with an error parameter
            echo "Email already exists.";
            exit();
        }
    }

    // Create an associative array with user data
    $userData = [
        'Username' => $username,
        'Username1' =>$username1,
        'job'=>  $job,
        'job1'=> $job1,
        ' location'=> $location,
        'houseno'=>$houseno,
        'road'=>$road,
        'village'=>$village,
        'district'=>$district,
        'state'=>$state,
        'country'=> $country,
        'aboutme'=> $aboutme,
        'email'=>$email,
        'phone'=>$phone,
        'fb'=>$facebook,
        'twitter'=>$twitter,
        'linkedin'=>$linkedin,
        'insta'=>$instagram,
        'whatsapp'=>$whatsapp ,
        'telegram'=>$telegram ,

        
        'Password' => password_hash($password, PASSWORD_DEFAULT), // Hash the password
        'password1' => password_hash($password1, PASSWORD_DEFAULT), // Hash the password
    ];

    // Add the new user data to the existing array
    $existingUsers[] = $userData;

    // Convert the array to JSON format
    $jsonData = json_encode($existingUsers, JSON_PRETTY_PRINT);

    if ($jsonData === false) {
        // Error encoding JSON, print error and handle accordingly
        echo "JSON encoding error: " . json_last_error_msg();
        exit();
    }

    // Save the updated JSON data back to the file
    file_put_contents('users.json', $jsonData);

    // Optionally, you can redirect the user to a success page
    echo "<body style='background-color: rgb(255, 239, 207);'>
    <div style='display: flex; justify-content: center; align-items: center; height: 100vh;'>
        <p style='color: green; text-align: center; font-size: 25px;   display: inline-block;'>
            உங்கள் சுயவிபரம் இந்த இணையத்தளத்தில் <br> வெற்றிகரமாக சேர்க்கப்பட்ட்து வாழ்த்துக்கள்!
        </p>
    </div>
    
</body>";
    exit();
}
?>
