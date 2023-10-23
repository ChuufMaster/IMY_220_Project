<!DOCTYPE html>
<html lang="en">


<?php include "../INCLUDES/header.php";
require_once '../CLASSES/database.php';
if ($_SERVER["REQUEST_METHOD"] === "POST")
{
    require "../configs/congfig.php";
}

?>

<body>
    <div class="container mb-5 mt-3 pb-5">

        <div class="col-6 mx-auto mt-3">
            <div class="p-1 card h-100 fancy">
                <span class="top-key"></span>
                <span class="text">
                    <div class="row g-0" id="profile">
                       
                    </div>
                </span>
                <span class="bottom-key-1"></span>
                <span class="bottom-key-2"></span>
            </div>
        </div>
    <div class="row mt-3 g-3" id="myArticles">

    </div>
    </div>
</body>

<footer>
    <script type="module" src="../../SCRIPTS/profiles.js"></script>
    
    <?php include "../INCLUDES/footer.php" ?>
</footer>

</html>