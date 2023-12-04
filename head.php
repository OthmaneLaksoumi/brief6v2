<nav class="navbar navbar-expand-lg bg-body-tertiary container">
    <div class="collapse navbar-collapse position-relative " id="navbarTogglerDemo01">
        <a class="navbar-brand col-5" href="admin.php">ElectroNacer</a>

        <ul class="navbar-nav me-auto mb-2 mb-lg-0 ">
            <li class="nav-item">
                <a class="nav-link active" href="admin.php">Home</a>
            </li>

            <li class="nav-item">
                <a class="nav-link active" href="productsUser.php">Products</a>
            </li>
            <?php
            
            if ($_SESSION["role"] === 1) { ?>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="dashboard.php" id="home">Dashboard</a>
                </li>
            <?php } ?>
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="logout.php">Log Out</a>
            </li>

        </ul>

    </div>
</nav>