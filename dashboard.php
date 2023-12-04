<?php 
session_start();
if (isset($_SESSION['state'])) { ?>
    <?php
    $conn = new PDO('mysql:host=localhost;dbname=brief7', 'root', '');
    $stmt1 = $conn->prepare("SELECT * FROM categories");
    $stmt1->execute();
    $catgs = $stmt1->fetchAll(PDO::FETCH_ASSOC);
    $stmt2 = $conn->prepare("SELECT * FROM products");
    $stmt2->execute();
    $prod = $stmt2->fetchAll(PDO::FETCH_ASSOC);
    // echo "<pre>";
// print_r($catg);
// echo "</pre>";
    
    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $title = $_POST["title"];
        $codeBar = $_POST["codeBar"];
        $prixAchat = $_POST["prixAchat"];
        $prixFinal = $_POST["prixFinal"];
        $desc = $_POST["desc"];
        $qntMin = $_POST["qntMin"];
        $qntStock = $_POST["qntStock"];
        $img = "assets/images/" . $_FILES["img"]["name"];
        $catg = $_POST["catg"];

        $stmt = $conn->prepare("INSERT INTO 
    products(etiquette, codeBarres, prixAchat, prixFinal, prixOffre, descpt, qntMin, qntStock, img, catg)
     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->execute([$title, $codeBar, $prixAchat, $prixFinal, $prixFinal, $desc, $qntMin, $qntStock, $img, $catg]);

        move_uploaded_file($_FILES['img']['tmp_name'], 'C:\xampp\htdocs\brief7\assets\images\\' . $_FILES['img']['name']);



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

            <div class="col-md-10">
                <h1>Ajouter un Produit</h1>
                <form action="" method="post" class="container" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="img" class="form-label">Upload Image</label>
                        <input type="file" class="form-control" id="img" name="img" required>
                    </div>
                    <div class="mb-3">
                        <label for="codeBar" class="form-label">Code à Bare</label>
                        <input type="text" class="form-control" id="codeBar" name="codeBar" required>
                    </div>
                    <div class="mb-3">
                        <label for="prixAchat" class="form-label">Prix d'achat</label>
                        <input type="text" class="form-control" id="prixAchat" name="prixAchat" required>
                    </div>
                    <div class="mb-3">
                        <label for="prixFinal" class="form-label">Prix Final</label>
                        <input type="text" class="form-control" id="prixFinal" name="prixFinal" required>
                    </div>
                    <div class="mb-3">
                        <label for="desc" class="form-label">Description</label>
                        <textarea type="text" class="form-control" id="desc" name="desc" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="qntMin" class="form-label">Quantity Minimale</label>
                        <input type="text" class="form-control" id="qntMin" name="qntMin" required>
                    </div>
                    <div class="mb-3">
                        <label for="qntStcok" class="form-label">Quantity Stock</label>
                        <input type="text" class="form-control" id="qntStock" name="qntStock" required>
                    </div>

                    <div class="mb-3">
                        <label for="catg" class="form-label">Category</label>
                        <select name="catg" id="" class="form-control">
                            <?php
                            foreach ($catgs as $item) {
                                echo "<option>" . $item["name"] . "</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <input type="submit" class="btn btn-primary my-5" value="Ajouter">
                </form>
            </div>
        </section>

    </body>

    </html>

<?php }  else  {
    header('Location: admin.php');
}

?>