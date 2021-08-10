<?php
session_start();

$conn = new SQLite3("Darkpatrol") or die ("unable to open database");

function createTable($sqlStmt, $tableName)
{
    global $conn;
    $stmt = $conn->prepare($sqlStmt);
    if ($stmt->execute()) {
        echo "<p style='color: green'>".$tableName. ": Table Created Successfully</p>";
    } else {
        echo "<p style='color: red'>".$tableName. ": Table Created Failure</p>";
    }
}
function addUser($username, $unhashedPassword, $name, $profilePic, $accessLevel) {
    global $conn;
    $hashedPassword = password_hash($unhashedPassword, PASSWORD_DEFAULT);
    $sqlstmt = $conn->prepare("INSERT INTO user (username, password, name, profilePic, accessLevel) VALUES (:userName, :hashedPassword, :name, :profilePic, :accessLevel)");
    $sqlstmt->bindValue(':userName', $username);
    $sqlstmt->bindValue(':hashedPassword', $hashedPassword);
    $sqlstmt->bindValue(':name', $name);
    $sqlstmt->bindValue(':profilePic', $profilePic);
    $sqlstmt->bindValue(':accessLevel', $accessLevel);
    if ($sqlstmt->execute()) {
        echo "<p style='color: green'>User: ".$username. ": Created Successfully</p>";
    } else {
        echo "<p style='color: red'>User: ".$username. ": Created Failure</p>";
    }
}
function addProducts($productName, $productQuantity, $productPrice, $productImage, $productCategory)
{
    global $conn;
    $sqlstmt = $conn->prepare("INSERT INTO products (productname, quantity, price, image, category) VALUES (:productName, :productQuantity, :productPrice, :productImage, :productCategory)");
    $sqlstmt->bindValue(':productName', $productName);
    $sqlstmt->bindValue(':productQuantity', $productQuantity);
    $sqlstmt->bindValue(':productPrice', $productPrice);
    $sqlstmt->bindValue(':productImage', $productImage);
    $sqlstmt->bindValue(':productCategory', $productCategory);
    if ($sqlstmt->execute()) {
        echo "<p style='color: green'>Product: ".$productName. ": Created Successfully</p>";
    } else {
        echo "<p style='color: red'>Product: ".$productName. ": Created Failure</p>";
    }
}
$query = file_get_contents("sql/create-user.sql");
createTable($query, "User");
$query = file_get_contents("sql/create-products.sql");
createTable($query, "Products");
$query= $conn->query("SELECT COUNT(*) as count FROM user");
$rowCount = $query->fetchArray();
$userCount = $rowCount["count"];


if ($userCount == 0) {
    addUser("admin", "admin", "Administrator", "admin.jpg", "Administrator");
    addUser("user", "user", "User", "user.jpg", "User");
    addUser("ryan", "ryan", "Ryan", "ryan.jpg", "User");
}
$query= $conn->query("SELECT COUNT(*) as count FROM products");
$rowCount = $query->fetchArray();
$productCount = $rowCount["count"];

if ($productCount == 0) {
    addProducts("Game", 5, 20, "game.png", "RPG");
}
?>
