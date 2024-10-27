<?php
// sanitize input
function clean_input($input) {
    $input = htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8'); 
    //Purpose of this is nested functions to sanitize user input

    return $input; //return the now sanitize input
}

// process targetfilepath
function targetFilePath($fileName, $antiqueName, $uploadDir) {
    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));
    $newFileName = $antiqueName . "_" . uniqid() . '.' . $fileActualExt;
    return $targetFilePath = $uploadDir . $newFileName;
}