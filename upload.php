<?php


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $herb_name = $_POST['exampleFormControlInput1'] ?? '';
    $notes = $_POST['exampleFormControlTextarea1'] ?? '';
    $kyc = $_POST['exampleFormControlTextarea2'] ?? '';

    // Define the folder path
    $folder_path = 'collcdata/';

    // Create folder name using the current date and herb name
    $folder_name = $folder_path . date('Y-m-d') . '-' . date('H-i-s') . '-' . $herb_name;

    // Create folder if it doesn't exist
    if (!file_exists($folder_name)) {
        mkdir($folder_name, 0777, true); // Set permissions as needed (0777 for example)
    }

    // Handle file uploads
    if (!empty($_FILES['formFile'])) {
        $file_count = count($_FILES['formFile']['name']);

        for ($i = 0; $i < $file_count; $i++) {
            $temp_file = $_FILES['formFile']['tmp_name'][$i];
            $file_name = $_FILES['formFile']['name'][$i];
            move_uploaded_file($temp_file, $folder_name . '/' . $file_name);
        }

        // Create and write content to the text file
        $text_file_content = "Herb Name: " . $herb_name . "\r\n\r\nNotes: " . $notes . "\r\n\r\nDetail shared by: " . $kyc;
        file_put_contents($folder_name . '/herb_info.txt', $text_file_content);

        // Set success message
        $message = "Images successfully uploaded!";
    }

    // Construct the HTML file name
    $html_file_name = $herb_name . '.html';

    // Begin HTML content with Bootstrap classes for responsiveness
    $html_content = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>' . $herb_name . '</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Add custom styles here */
        .img-spacing img {
            margin-bottom: 15px; /* Adjust the spacing between images as needed */
        }
    </style>
</head>
<body class="container mt-5">'; // Add Bootstrap container class for responsiveness

    // Include herb name, notes, and user details in the HTML content
    $html_content .= '<h1 class="text-center">' . $herb_name . '</h1>';
    $html_content .= '<p>' . $notes . '</p>';
    $html_content .= '<p>User details: ' . $kyc . '</p>';

    // Append user-uploaded images to the HTML content using Bootstrap's img-fluid class for responsive images
    $html_content .= '<div class="img-spacing">';
    for ($i = 0; $i < $file_count; $i++) {
        $html_content .= '<img src="' . $_FILES['formFile']['name'][$i] . '" alt="' . $_FILES['formFile']['name'][$i] . '" class="img-fluid">';
    }
    $html_content .= '</div>';

    $html_content .= '</body>
</html>';

    // Write the HTML content to a file
    file_put_contents($folder_name . '/' . $html_file_name, $html_content);




    // Construct the new card HTML content based on user input
    $new_card = '<div class="col-lg-3 col-md-6 col-sm-6 mb-4">
<div class="card" data-title="' . $herb_name . '">
    <img src="herbcollection/' . $folder_name . '/' . $_FILES['formFile']['name'][0] . '" class="card-img-top" alt="' . $herb_name . '">
    <div class="card-body">
        <h5 class="card-title">' . $herb_name . '</h5>
        <p class="card-text">தகவல் படங்களுடன் இணைக்கப்பட்டுள்ளது</p>
        <a href="herbcollection/' . $folder_name . '/' . $herb_name . '.html" class="btn btn-primary">மேலும் படங்களுக்கு</a>
    </div>
</div>
</div>';

    // Read the current content of gallery.html
    $gallery_file = '../gallery.html';
    $gallery_content = file_get_contents($gallery_file);

    // Identify the position to insert new content before the last two </div> in the section
    $last_div_position = strrpos($gallery_content, '</div>', -1); // Get the position of the last </div>
    if ($last_div_position !== false) {
        // Search for the second last </div> before the last </div>
        $second_last_div_position = strrpos($gallery_content, '</div>', $last_div_position - strlen($gallery_content) - 1);
        if ($second_last_div_position !== false) {
            // Insert the new card HTML content before the identified position
            $updated_gallery_content = substr_replace($gallery_content, $new_card, $second_last_div_position, 0);

            // Write the updated content back to gallery.html
            file_put_contents($gallery_file, $updated_gallery_content);
        }
    }



    // Redirect back to index.html
    header("Location: index.html");
    exit();
}
