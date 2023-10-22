<!DOCTYPE html>
<html lang="en">


<?php include "../INCLUDES/header.php";
require_once '../CLASSES/database.php';
if ($_SERVER["REQUEST_METHOD"] === "POST")
{
    require "../configs/congfig.php";
    $db = new mysqli($host, $username, $password, $database_name);
    
    
}

?>

<body>
    <div class="container mb-5 mt-3 pb-5">
        
    </div>
</body>

<footer>
    <?php include "../INCLUDES/footer.php" ?>
</footer>

</html>