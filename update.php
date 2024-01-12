<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mainCategory = $_POST['mainCategory'] ?? '';
    $subCategory = $_POST['subCategory'] ?? '';
    $subSubCategory = $_POST['subSubCategory'] ?? '';

    // Read existing data from file
    $dataFile = 'categories.txt';
    $existingData = file_get_contents($dataFile);
    $existingArray = json_decode($existingData, true);

    // If the existing array is empty, initialize it as an empty array
    if (empty($existingArray)) {
        $existingArray = array();
    }

    // If the main category is not empty, proceed to process subcategories
    if (!empty($mainCategory)) {
        // If the main category doesn't exist, create it as an empty array
        if (!isset($existingArray[$mainCategory])) {
            $existingArray[$mainCategory] = array();
        }

        // If the sub category is not empty, proceed to process sub-subcategories
        if (!empty($subCategory)) {
            // If the sub category doesn't exist, create it as an empty array
            if (!isset($existingArray[$mainCategory][$subCategory])) {
                $existingArray[$mainCategory][$subCategory] = array();
            }

            // Add the sub-sub category under the main and sub categories if it doesn't already exist
            if (!empty($subSubCategory) && !in_array($subSubCategory, $existingArray[$mainCategory][$subCategory])) {
                $existingArray[$mainCategory][$subCategory][] = $subSubCategory;
            }
        }
    }

    // Write updated data back to the file
    $jsonData = json_encode($existingArray);
    file_put_contents($dataFile, $jsonData);

    // Generate HTML file to display the content of categories.txt
    $htmlContent = '<!DOCTYPE html>
    <html lang="en">    <head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>palnt category </title><link rel="stylesheet" href="style.css">
    </head><body>  <div class="side_bar"><ul id="mainList">';

    foreach ($existingArray as $mainCat => $subCats) {
        $htmlContent .= "<li class=\"dropdown\">  <a href=\"updateform.html\"> $mainCat </a> <ul>";
        foreach ($subCats as $subCat => $subSubCats) {
            $htmlContent .= "<li class=\"dropdown_two\"> <a href=\"updateform.html\"> $subCat </a> <ul>";
            foreach ($subSubCats as $subSubCat) {
                $htmlContent .= "<li> <a href=\"$subSubCat.html\"> $subSubCat  </a>  </li>";
            }
            $htmlContent .= "</ul></li>";
        }
        $htmlContent .= "</ul></li>";
    }

    $htmlContent .= '</ul></div></body></html>';

    // Write HTML content to a file
    $htmlFile = 'categories.html';
    file_put_contents($htmlFile, $htmlContent);

    // Redirect to the generated HTML file
    header("Location: index.html");
    exit();
}
?>
