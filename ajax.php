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
    //     echo "<pre>";
// print_r($_POST);
// echo "</pre>";

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        echo "<pre>";
        print_r($_POST);
        echo "</pre>";

        for($i = 1; $i <= 10; $i++) {
            if(isset($_POST["title1"])){
                echo "<pre>";
                print_r($_POST);
                echo "</pre>";
            }
        }

        //     $title = $_POST["title"];
        //     $codeBar = $_POST["codeBar"];
        //     $prixAchat = $_POST["prixAchat"];
        //     $prixFinal = $_POST["prixFinal"];
        //     $desc = $_POST["desc"];
        //     $qntMin = $_POST["qntMin"];
        //     $qntStock = $_POST["qntStock"];
        //     $img = "assets/images/" . $_FILES["img"]["name"];
        //     $catg = $_POST["catg"];

        //     $stmt = $conn->prepare("INSERT INTO 
        // products(etiquette, codeBarres, prixAchat, prixFinal, prixOffre, descpt, qntMin, qntStock, img, catg)
        //  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        //     $stmt->execute([$title, $codeBar, $prixAchat, $prixFinal, $prixFinal, $desc, $qntMin, $qntStock, $img, $catg]);

        //     move_uploaded_file($_FILES['img']['tmp_name'], 'C:\xampp\htdocs\brief7\assets\images\\' . $_FILES['img']['name']);

        // header('Location: ajax.php');

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

            <div class="col g-3 container-form">
                <h1>Ajouter un Produit</h1>

                <form class="container"  onsubmit="event.preventDefault();">
                    <div class="mb-3">
                        <label for="title" class="form-label">Entre Le nombre de produit que vous pouvez ajoter</label>
                        <input type="number" class="form-control" id="nbrOfProduct" name="nbrOfProduct" required>
                    </div>
                    <input type="submit" class="btn btn-primary" id="nbrSubmit" value="Entrer">
                </form>



            </div>

        </section>



        <script>
            let nbrOfProduct = document.getElementById('nbrOfProduct');
            let nbrSubmit = document.getElementById('nbrSubmit');
            let addForm = document.querySelector('.container-form');


            function createProductSection(nbr) {
                let productSection = document.createElement('div');
                productSection.className = 'container productInsert';
                productSection.style.background = '#eee';
                productSection.style.width = '75%';
                productSection.style.marginBottom = '20px';
                productSection.style.marginTop = '20px';
                productSection.style.padding = '10px';
                productSection.style.cursor = 'pointer';
                productSection.innerText = 'Product ' + nbr;
                return productSection;
            }

            function createForm(nbr) {
                let formInsert = document.createElement('form');
                formInsert.setAttribute('method', 'Post');
                formInsert.setAttribute('enctype', 'multipart/form-data');
                formInsert.className = 'container';
                formInsert.id = 'formInser-' + nbr;
                formInsert.innerHTML = `
                        <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control" id="title" name="title${nbr}" required>
                            
                            </div>
                            <div class="mb-3">
                                <label for="img" class="form-label">Upload Image</label>
                                <input type="file" class="form-control" id="img" name="img${nbr}" required>
                            </div>
                            <div class="mb-3">
                                <label for="codeBar" class="form-label">Code à Bare</label>
                                <input type="text" class="form-control" id="codeBar" name="codeBar${nbr}" required>
                            </div>
                            <div class="mb-3">
                                <label for="prixAchat" class="form-label">Prix d'achat</label>
                                <input type="text" class="form-control" id="prixAchat" name="prixAchat${nbr}" required>
                            </div>
                            <div class="mb-3">
                                <label for="prixFinal" class="form-label">Prix Final</label>
                                <input type="text" class="form-control" id="prixFinal" name="prixFinal${nbr}" required>
                            </div>
                            <div class="mb-3">
                                <label for="desc" class="form-label">Description</label>
                                <textarea type="text" class="form-control" id="desc" name="desc${nbr}" rows="4" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="qntMin" class="form-label">Quantity Minimale</label>
                                <input type="text" class="form-control" id="qntMin" name="qntMin${nbr}" required>
                            </div>
                            <div class="mb-3">
                                <label for="qntStcok" class="form-label">Quantity Stock</label>
                                <input type="text" class="form-control" id="qntStock" name="qntStock${nbr}" required>
                            </div>

                            <div class="mb-3">
                                <label for="catg" class="form-label">Category</label>
                                <select name="catg${nbr}" id="" class="form-control">
                                    <?php
                                    foreach ($catgs as $item) {
                                        echo "<option>" . $item["name"] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                           
                
                        `;
                return formInsert;
            }

            // console.log(createForm());
            // addForm.appendChild(createForm());

            // console.log(createProductSection(5));

            // addForm.appendChild(productSection);

            nbrSubmit.addEventListener('click', function () {
                if (nbrOfProduct.value != 0) {
                    for (let i = 0; i < nbrOfProduct.value; i++) {
                        addForm.appendChild(createProductSection(i + 1));
                        addForm.appendChild(createForm(i + 1));
                        document.getElementById(`formInser-${i + 1}`).style.display = 'none';
                    }
                    addForm.innerHTML += `
                    <form method="POST" class="container">
                        <input type="submit" class="btn btn-primary my-5 container" name="product" value="Ajouter">
                    </form>
                    `;
                    let productInsert = document.querySelectorAll('.productInsert');
                    productInsert.forEach(function (pro, i) {
                        pro.addEventListener('click', function () {
                            if (document.getElementById(`formInser-${i + 1}`).style.display === 'none') {
                                document.getElementById(`formInser-${i + 1}`).style.display = '';
                            } else {
                                document.getElementById(`formInser-${i + 1}`).style.display = 'none';
                            }

                        });
                    });

                }
            });
        </script>



    </body>

    </html>

<?php } else {
    header('Location: admin.php');
}

?>