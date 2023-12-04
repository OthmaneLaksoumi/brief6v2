<?php

$conn = new PDO('mysql:host=localhost;dbname=brief7', 'root', '');
$stmt1 = $conn->prepare('SELECT * FROM products');
$stmt1->execute();
$products = $stmt1->fetchAll(PDO::FETCH_ASSOC);
$stmt2 = $conn->prepare('SELECT * FROM categories');
$stmt2->execute();
$catgs = $stmt2->fetchAll(PDO::FETCH_ASSOC);

session_start();
// echo '<pre>';
// print_r($_POST);
// echo '</pre>';


if ($_SERVER["REQUEST_METHOD"] === "POST") {


    if (isset($_POST["hided"])) {
        $hideProduct = $_POST["hided"];
        $stmt3 = $conn->prepare("SELECT * FROM products WHERE etiquette = '$hideProduct'");
        $stmt3->execute();
        $productModifie = $stmt3->fetchAll(PDO::FETCH_ASSOC)[0];
        setcookie("ref", $productModifie["codeBarres"]);
    }

    // echo '<pre>';
    // print_r($_FILES);
    // echo '</pre>';


    if (isset($_POST["modifie"])) {
        $ref = $_COOKIE["ref"];
        $title = $_POST['title'];
        $prixAchat = $_POST['prixAchat'];
        $prixFinal = $_POST['prixFinal'];
        $desc = $_POST['desc'];
        $qnt_min = $_POST['qntMin'];
        $qnt_stock = $_POST['qntStock'];
        $catg = $_POST['catg'];
        $img = "assets/images/" . $_FILES['img']['name'];

        move_uploaded_file($_FILES['img']['tmp_name'], 'C:\xampp\htdocs\brief7\assets\images\\' . $_FILES['img']['name']);

        $sql = "UPDATE `products` 
        SET `etiquette` = '$title', `descpt` = '$desc', `prixAchat` = '$prixAchat', `prixFinal` = '$prixFinal',
        `qntMin` = '$qnt_min', `qntStock` = '$qnt_stock', `catg` = '$catg', `img` = '$img' WHERE `products`.`codeBarres` = '$ref'";

        $stmt4 = $conn->prepare($sql);
        $stmt4->execute();

        setcookie("ref", "", time() - 1);

    }
}




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <style>



    </style>
</head>

<body>
    <?php include("head.php") ?>

    <section class="dashboard">
        <?php
        include("sideBar.html");
        ?>
        <!-- </div> -->
        <!-- </div> -->



        <div class="col-md-10">
            <h1>Modifier une Produit</h1>
            <form action="" method="post" class="container">
                <div class="mb-3">
                    <label for="catg" class="form-label">Choisir une Produit</label>
                    <select name="hided" id="" class="form-control">
                        <?php
                        foreach ($catgs as $catg) {
                            echo "<optgroup label=" . $catg["name"] . ">" . $catg["name"];
                            foreach ($products as $product) {
                                if ($product["catg"] === $catg["name"]) {
                                    if ($productModifie["etiquette"] === $product["etiquette"]) {
                                        echo "<option selected>" . $product["etiquette"] . "</option>";
                                    } else {
                                        echo "<option>" . $product["etiquette"] . "</option>";

                                    }
                                }
                            }
                        }
                        ?>
                    </select>
                </div>



                <input type="submit" class="btn btn-primary my-2" value="Choisir">
            </form>

            <?php
            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                ?>
                <div class="mb-3 d-flex justify-content-center">
                    <img class="my-5" src='<?php echo $productModifie['img'] ?>'>
                </div>
                <form action="" method="post" class="container modifie-pro d-flex align-items-center"
                    enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title"
                            value='<?php echo $productModifie['etiquette'] ?>' required>
                    </div>
                    <div class="mb-3">
                        <label for="img" class="form-label">Upload Image</label>
                        <input type="file" class="form-control" id="img" name="img">
                    </div>
                    <div class="mb-3">
                        <label for="prixAchat" class="form-label">Prix d'achat</label>
                        <input type="text" class="form-control" id="prixAchat" name="prixAchat"
                            value='<?php echo $productModifie['prixAchat'] ?>' required>
                    </div>
                    <div class="mb-3">
                        <label for="prixFinal" class="form-label">Prix Final</label>
                        <input type="text" class="form-control" id="prixFinal" name="prixFinal"
                            value='<?php echo $productModifie['prixFinal'] ?>' required>
                    </div>
                    <div class="mb-3">
                        <label for="desc" class="form-label">Description</label>
                        <textarea type="text" class="form-control" id="desc" name="desc" rows="4"
                            required><?php echo $productModifie['descpt'] ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="qntMin" class="form-label">Quantity Minimale</label>
                        <input type="text" class="form-control" id="qntMin" name="qntMin"
                            value='<?php echo $productModifie['qntMin'] ?>' required>
                    </div>
                    <div class="mb-3">
                        <label for="qntStcok" class="form-label">Quantity Stock</label>
                        <input type="text" class="form-control" id="qntStock" name="qntStock"
                            value='<?php echo $productModifie['qntStock'] ?>' required>
                    </div>

                    <div class="mb-3">
                        <label for="catg" class="form-label">Category</label>
                        <select name="catg" id="" class="form-control">
                            <?php
                            foreach ($catgs as $item) {
                                if ($item["name"] === $productModifie['catg']) {
                                    echo "<option selected>" . $item["name"] . "</option>";
                                } else {
                                    echo "<option>" . $item["name"] . "</option>";

                                }
                            }
                            // ?>
                        </select>
                    </div>

                    <input type="submit" class="btn btn-primary my-2" name="modifie" value="Modifier">



                </form>

            <?php } ?>
        </div>
    </section>

</body>

</html>