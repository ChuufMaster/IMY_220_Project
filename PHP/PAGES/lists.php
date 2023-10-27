<!DOCTYPE html>
<html lang="en">


<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "../INCLUDES/header.php";


?>

<body>
    <div class="container mb-5 mt-3 pb-5">
        <div class="row g-3" id="lists">
        </div>
    </div>
</body>

<footer>
    <script type="module" src="../../SCRIPTS/lists.js"></script>

    <?php include "../INCLUDES/footer.php" ?>
</footer>

</html>