<?php 
$conn = new PDO('mysql:host=localhost;dbname=brief7', 'root', '');
$stmt = $conn->prepare('SELECT * FROM categories WHERE isHide = 0');
$stmt->execute();
$catgs = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt1 = $conn->prepare('SELECT * FROM products WHERE isHide = 0');
$stmt1->execute();
$product = $stmt1->fetchAll(PDO::FETCH_ASSOC);

$categories = json_encode($catgs);
$products = json_encode($product);


if(isset($_GET['table'])) {
    $str = $_GET['table'];
    echo $$str;
}





// echo '<pre>';
// print_r($result);
// echo '</pre>';
?>
