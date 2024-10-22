<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rental Sheet</title>
    <link rel="stylesheet" href="https://classless.de/classless.css">
    <style>
        th, td {
            text-align: left; /* Aligns the text horizontally to the center */
            vertical-align: middle; /* Aligns the text vertically to the middle */
        }
    </style>
</head>
<body>
    <button onclick="window.location.href='user-landing.php';">BACK</button>

    <?php
        require_once '../../src/db_modules/autoload_classes.php';
        require_once '../../src/utils/functions.php';

        //Create an instance where to put the properties and method of Books class from books.class.php
        $antiqueObj = new Antique(); 
        //Call the fetchRecord() method to retrieve all database and populate into an array
        $array = $antiqueObj->fetchAllRecord();

        $keyword = '';
        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search'])){
            $keyword = clean_input($_POST['keyword']);
            $array = $antiqueObj->fetchAllRecord($keyword);
        }
    ?>
    <form action="" method="post">
        <label for="keyword">Search Client</label>
        <input type="text" name="keyword" placeholder="Enter keyword to search" value="<?= $keyword ?>">
        <input type="submit" value="Search" name="search">
    </form>
    <h3>ANTIQUE SHEET</h3>
    <hr>
    <table class="responsive-table">
        <thead>
            <tr>
                <th>Antique Name</th>
                <th>Desciption</th>
                <th>Category</th>
                <th>Year</th>
                <th>Value</th>
                <th>Location</th>
            </tr>
        </thead>
        <?php
            
            foreach ($array as $arr) { //for loop for the array data
            $cat = $antiqueObj->getAntiqueCategorybyID($arr['category_id']);
        ?>
        <tbody>
            <tr>
                <!--HINT: The variable inside the $arr[''] must be the column name from the database -->
                <td><?= $arr['antique_name'] ?></td>
                <td><?= $arr['description'] ?></td>
                <td><?= $cat['name'] ?></td>
                <td><?= $arr['year'] ?></td>
                <td><?= $arr['value'] ?></td>
                <td><?= $arr['street'] . ", " . $arr['barangay'] . ", " . $arr['city'] . ", " . $arr['postal_code'] ?></td>
            </tr>
        </tbody>
        <?php
            }
        ?>
    </table>

</body>
</html> 