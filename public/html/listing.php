<?php
require_once '../../src/db_modules/database.php';
require_once '../../src/db_modules/autoload_classes.php';
require_once '../../src/utils/functions.php';
$antiqueObj = new Antique();

$name = $description = $category = $year = $price = $imageName = '';
$street = $barangay = $city = $code = '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $filename = str_replace(' ', '_', $_POST['filename']);
    $uploadDir = 'antiques/'. $filename . "/";
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
    $maxFileSize = 5 * 1024 * 1024; // 5MB
    $fileCount = count($_FILES['images']['name']);

    // validatation and sanitization
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

    //image validation
    if($fileCount > 5) {
        $error['image'] = "Error: Maximum of 5 pictures only";
    } else {
        // Ensure the upload directory exists
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        foreach ($_FILES['images']['tmp_name'] as $key => $tmpName) {
            $fileName = basename($_FILES['images']['name'][$key]);
            $fileSize = $_FILES['images']['size'][$key];
            $fileType = $_FILES['images']['type'][$key];
            $fileError = $_FILES['images']['error'][$key];

            //validation
            switch (true) {
                case !in_array($fileType, $allowedTypes):
                    $error['image'] = "Error: Only JPG, PNG, and GIF files are allowed for $fileName.<br>";
                    continue 2; // Skip to the next iteration of the foreach loop
        
                case $fileSize > $maxFileSize:
                    $error['image'] = "Error: File size for $fileName exceeds the 2MB limit.<br>";
                    continue 2; // Skip to the next iteration of the foreach loop
        
                case $fileError !== UPLOAD_ERR_OK:
                    $error['image'] = "Error: There was an error uploading $fileName.<br>";
                    continue 2; // Skip to the next iteration of the foreach loop
                }
            
            $targetFilePath = targetFilePath($fileName, $fileName, $uploadDir);

            // Move the file to the target directory
            if (move_uploaded_file($tmpName, $targetFilePath)) {
                
            } else {
                $error['image'] = "Error: There was an error moving $fileName to the upload directory.";
            }
        }
    }

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
            header('Location: browse.php');
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
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../css/root.css">
    <link rel="stylesheet" href="../css/listing.css">
</head>
<body>
    <div class="container">

        <form action="" method="post" enctype="multipart/form-data" autocomplete="off">
            <button onclick="window.location.href='user-landing.php';"><i class='bx bx-arrow-back'></i></button>
            <br> <br>
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
            <br><br>
                    
            <label for="price">Price:</label>
            <input type="number" id="price" name="price" value="<?= htmlspecialchars($price) ?>" required>
            <span><?= $errors['price'] ?? '' ?></span>
            <br><br>

            <label for="location">Antique Location:
                <div class="location-fields">
                    <input type="text" name="street" placeholder="Street" value="<?= htmlspecialchars($street) ?>" required>
                    <span><?= $errors['street'] ?? '' ?></span>
                    <input type="text" name="barangay" placeholder="Barangay" value="<?= htmlspecialchars($barangay) ?>" required>
                    <span><?= $errors['barangay'] ?? '' ?></span>
                    <input type="text" name="city" placeholder="City" value="<?= htmlspecialchars($city) ?>" required>
                    <span><?= $errors['city'] ?? '' ?></span>
                    <input type="text" name="code" placeholder="Postal Code" value="<?= htmlspecialchars($code) ?>" required>
                    <span><?= $errors['code'] ?? '' ?></span>
                </div>
            </label>

            <div img-upload>
                <h2>Upload image</h2>
                <span><?= $errors['image'] ?? '' ?></span>
                

                <input type="file" name="images[]" id="imageInput" accept="image/*" max="5" multiple oninput="previewImages()">
                <br><br>
                <!-- Container to hold the image previews -->
                <div class="preview-container" id="previewContainer"></div>
                <br>
            </div>
            <div class="submit-container">
                <input type="submit" name="submit" value="Submit Listing">
            </div>
        </form>
    </div>
    <script>
        let selectedFiles = [];

        // This function handles the file input change event
        function handleFileSelection(event) {
            const newFiles = Array.from(event.target.files); // Get the newly selected files
            const maxFiles = 5; // Maximum number of files allowed

            // Add new files to selectedFiles, avoiding duplicates
            newFiles.forEach(file => {
                if (!selectedFiles.some(existingFile => existingFile.name === file.name && existingFile.size === file.size)) {
                    selectedFiles.push(file);
                }
            });

            // Limit the number of selected files
            if (selectedFiles.length > maxFiles) {
                alert(`You can only upload a maximum of ${maxFiles} files.`);
                selectedFiles = selectedFiles.slice(0, maxFiles); // Keep only up to maxFiles
            }

            // Update the file input element with the current selected files
            updateFileInput();
            previewImages();
        }

        // This function updates the file input's file list
        function updateFileInput() {
            const dataTransfer = new DataTransfer();
            selectedFiles.forEach(file => {
                dataTransfer.items.add(file);
            });
            document.getElementById('imageInput').files = dataTransfer.files;
        }

        // Function to preview selected images
        function previewImages() {
            const previewContainer = document.getElementById('previewContainer');
            previewContainer.innerHTML = ""; //clear preview container

            // Loop through the selected files and create a preview for each
            selectedFiles.forEach((file, index) => {
                if (file.type.startsWith("image/")) {
                    const reader = new FileReader();
                    
                    // When the file is loaded, create an image preview
                    reader.onload = function(e) {
                        const previewBox = document.createElement("div");
                        previewBox.classList.add("preview-box");

                        const img = document.createElement("img");
                        img.src = e.target.result;

                        // Create the remove button ("X")
                        const removeBtn = document.createElement("button");
                        removeBtn.innerHTML = "<i class='bx bx-x'></i>";
                        removeBtn.classList.add("remove-btn");
                        removeBtn.onclick = () => removeImage(index);

                        // Append the image and the remove button to the preview box
                        previewBox.appendChild(img);
                        previewBox.appendChild(removeBtn);
                        previewContainer.appendChild(previewBox);
                    };

                    reader.readAsDataURL(file);
                }
            });
        }

        // Function to remove an image from the selected files and update the preview
        function removeImage(index) {
            selectedFiles.splice(index, 1); // Remove the file from the array
            updateFileInput(); // Update the input field
            previewImages(); // Refresh the image previews
        }

        // Attach the event listener to the file input
        document.getElementById('imageInput').addEventListener('change', handleFileSelection);
    </script>
</body>
</html>
