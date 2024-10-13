<?php
require_once '../../src/db_modules/database.php';
require_once '../../src/db_modules/antique.class.php';
require_once '../../src/utils/functions.php';
$antiqueObj = new Antique();

$name = $description = $category = $year = $price = '';
$street = $barangay = $city = $code = '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    // Clean and validate inputs
    $name = clean_input($_POST['name']);
    if (empty($name)) {
        $errors['name'] = "Antique name is required.";
    }

    $description = clean_input($_POST['description']);
    if (empty($description)) {
        $errors['description'] = "Description is required.";
    }

    $category = clean_input($_POST['category']);
    if (empty($category)) {
        $errors['category'] = "Category is required.";
    }

    $year = clean_input($_POST['year']);
    if (empty($year) || !filter_var($year, FILTER_VALIDATE_INT, ["options" => ["min_range" => 1000, "max_range" => 2024]])) {
        $errors['year'] = "Valid year is required.";
    }

    $price = clean_input($_POST['price']);
    if (empty($price) || !filter_var($price, FILTER_VALIDATE_FLOAT)) {
        $errors['price'] = "Valid price is required.";
    }

    $street = clean_input($_POST['street']);
    if (empty($street)) {
        $errors['street'] = "Street is required.";
    }

    $barangay = clean_input($_POST['barangay']);
    if (empty($barangay)) {
        $errors['barangay'] = "Barangay is required.";
    }

    $city = clean_input($_POST['city']);
    if (empty($city)) {
        $errors['city'] = "City is required.";
    }

    $code = clean_input($_POST['code']);
    if (empty($code) || !preg_match("/^\d{4,6}$/", $code)) {
        $errors['code'] = "Valid postal code is required.";
    }

    // Check for file upload
    /* if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png'];
        $fileName = $_FILES['image']['name'];
        $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);

        if (!in_array(strtolower($fileExt), $allowed)) {
            $errors['image'] = "Invalid image format. Allowed formats: jpg, jpeg, png.";
        }
    } else {
        $errors['image'] = "Image upload is required.";
    } */

    // If no errors, process the form
    if (empty($errors)) {
        $antiqueObj->antique_name = $name;
        $antiqueObj->description = $description;
        $antiqueObj->category_id = $category;
        $antiqueObj->year = $year;
        $antiqueObj->value = $price;
        $antiqueObj->street = $street;
        $antiqueObj->barangay = $barangay;
        $antiqueObj->city = $city;
        $antiqueObj->postal_code = $code;


        // Attempt to add the product to the database.
        if($antiqueObj->addAntique()){
            // If successful, redirect to the product listing page.
            /* header('Location: rentals.table.php'); */
        } else {
            // If an error occurs during insertion, display an error message.
            echo 'Something went wrong when adding the new product.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Antique Listing Form</title>
    <link rel="stylesheet" href="https://classless.de/classless.css">
    <link rel="stylesheet" href="../css/root.css">
    <link rel="stylesheet" href="../css/listing.css">
</head>
<body>
    <button onclick="">BACK</button>
    <form action="" method="post" enctype="multipart/form-data" autocomplete="off">
        <h2>Antique Listing Form</h2>
        <p> All fields are required</p>
        <hr><br>

        <label for="name">Antique Name:</label>
        <input type="text" id="name" name="name" value="<?= htmlspecialchars($name) ?>" required>
        <span><?= $errors['name'] ?? '' ?></span>
        <br>

        <label for="description">Description:</label><br>
        <textarea id="description" name="description" rows="4" required><?= htmlspecialchars($description) ?></textarea>
        <span><?= $errors['description'] ?? '' ?></span>
        <br>

        <label for="category">Category:</label>
        <select id="category" name="category" required>
            <option value="">-- Select Category --</option>
            <?php
                $categories = $antiqueObj->fetchCategory();
                foreach ($categories as $cat) {
            ?>
            <option value="<?= $cat['id'] ?>" <?= ($category == $cat['id']) ? 'selected' : '' ?>><?= $cat['name'] ?></option>
            <?php
                }
            ?>
        </select>
        <span><?= $errors['category'] ?? '' ?></span>
        <br>

        <label for="year">Year of Origin:</label>
        <input type="number" id="year" name="year" min="1000" max="2024" value="<?= htmlspecialchars($year) ?>" required>
        <span><?= $errors['year'] ?? '' ?></span>
        <br>
                
        <label for="price">Price:</label>
        <input type="number" id="price" name="price" value="<?= htmlspecialchars($price) ?>" required>
        <span><?= $errors['price'] ?? '' ?></span>
        <br>

        <div class="location">
            <label for="location">Antique Location: </label><br>
            <input type="text" name="street" placeholder="Street" value="<?= htmlspecialchars($street) ?>" required>
            <span><?= $errors['street'] ?? '' ?></span>
            <input type="text" name="barangay" placeholder="Barangay" value="<?= htmlspecialchars($barangay) ?>" required>
            <span><?= $errors['barangay'] ?? '' ?></span>
            <input type="text" name="city" placeholder="City" value="<?= htmlspecialchars($city) ?>" required>
            <span><?= $errors['city'] ?? '' ?></span>
            <input type="text" name="code" placeholder="Postal Code" value="<?= htmlspecialchars($code) ?>" required>
            <span><?= $errors['code'] ?? '' ?></span>
        </div>
        
        <!-- <label for="image">Antique Image: </label>
        <input type="file" name="image" id="image" required>
        <span><?= $errors['image'] ?? '' ?></span>
        <br> -->

        <button type="submit" name="submit">Submit Listing</button>
    </form>
</body>
</html>
