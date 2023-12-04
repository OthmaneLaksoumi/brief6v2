<?php
$conn = new PDO('mysql:host=localhost;dbname=brief7', 'root', '');

if (isset($_POST["modifie"])) {
    $oldName = $_POST["oldName"];
    $name = $_POST["name"];
    $desc = $_POST["desc"];
    $img = "assets/catgImages/" . $_FILES['img']['name'];

    if (!empty($_FILES['img']['name'])) {
        $sql = "UPDATE categories
        SET name = '$name', descrt = '$desc', img = '$img' 
        WHERE name = '$oldName'";
    } else {
        $sql = "UPDATE categories
        SET name = '$name', descrt = '$desc'
        WHERE name = '$oldName'";
    }

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    if (!empty($_FILES['img']['name'])) {
        move_uploaded_file($_FILES['img']['tmp_name'], 'C:\xampp\htdocs\brief6Vesrsion2\assets\catgImages\\' . $_FILES['img']['name']);
    }

    // echo '<pre>';
    // print_r($_FILES);
    // echo '</pre>';



    header("Location: ajax.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <style>
        select {
            width: fit-content;
            margin: 50px auto;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg bg-body-tertiary container">
        <div class="collapse navbar-collapse d-flex" id="navbarTogglerDemo01">
            <a class="navbar-brand col-5" href="admin.php">ElectroNacer</a>

            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="admin.php" id="home">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="" id="home">Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="" id="home">Dashboard</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="logout.php">Log Out</a>
                </li>

            </ul>

        </div>
    </nav>


    <section class="dashboard">
        <?php include("sideBar.html") ?>






    </section>

    <script>
        function displayProducts(object) {
            let product_card = document.createElement('div');
            product_card.className = "product-item";
            product_card.innerHTML = `
                <img src="${object['img']}" alt='Product'>
                <h5>${object['etiquette']}</h5>
                <p>${object['prixAchat']}</p>
                <p>${object['prixFinal']}</p>
                <p class='qntMin'>Quantity minimale: ${object['qntMin']}</p>
                <p class='qntStc'>Quantity en Stock: ${object['qntStock']}</p>
                <p>Categorie: ${object['catg']}</p>
            `;
            return product_card;
        }



        function getData(tableName) {
            var result;
            let myRequest = new XMLHttpRequest();
            myRequest.open("GET", "ajaxConn.php?table=" + tableName, false);
            myRequest.onreadystatechange = function () {
                if (this.readyState === 4 && this.status === 200) {
                    result = JSON.parse(this.responseText);
                }
            }
            myRequest.send();
            return result;
        }

        /* Create Filter */
        let filter = document.createElement('select');
        filter.className = 'form-control container';
        filter.style.width = 'fit-content';
        filter.innerHTML = "<option disabled selected>Choose a category</option>";
        getData("categories").forEach(function (catg, i) {
            filter.innerHTML += `<option value=${i}>${catg['name']}</option>`;
        });
        /* End of Create Filter */


        let formContainer = document.createElement('div');
        formContainer.className = 'col-md-10';
        formContainer.appendChild(filter);

        const categories = getData('categories');
        
        filter.addEventListener('change', function () {

            formContainer.innerHTML = `
            <div class= 'mb-3 d-flex justify-content-center'>
                <img src=${categories[filter.value]['img']} width='250px'  alt="">
            </div>
            <form method="post" class="container" enctype="multipart/form-data">
                <div class="mb-3">
                        <input type="hidden" class="form-control" id="title" name="oldName" required
                            value='${categories[filter.value]['name']}'>
                </div>

                <div class="mb-3">
                    <label for="title" class="form-label">Nouveau Nom de la catégorie</label>
                    <input type="text" class="form-control" id="title" name="name" required
                        value='${categories[filter.value]['name']}'>
                </div>

                <div class="mb-3">
                            <label for="title" class="form-label">Nouveau Description de la catégorie</label>
                            <textarea type="text" class="form-control" id="title" name="desc" rows="5"
                                required>${categories[filter.value]['descrt']}</textarea>
                </div>

                <div class="mb-3">
                    <label for="img" class="form-label">Upload Image</label>
                    <input type="file" class="form-control" id="img" name="img">
                </div>

                <input type="submit" class="btn btn-primary my-5" name="modifie" value="Modifier">
            </form>   
            `;

        });

        document.querySelector('.dashboard').appendChild(formContainer);

    </script>
</body>

</html>