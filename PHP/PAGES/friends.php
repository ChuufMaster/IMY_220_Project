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
        <div class="p-1 card h-100 fancy w-100">
            <span class="top-key"></span>
            <span class="text">
                <div class="row g-0" id="profile">
                    <div class="row">
                        <div class=" col-9 my-auto">
                            <div class="input-group">
                                <input class="w-100 form-control" type="text" id="friendName">
                            </div>
                        </div>
                        <div class="col-3">
                            <a class="fancy" href="#" id="add_friend">
                                <span class="overlay"></span>
                                <span class="top-key"></span>
                                <span class="text">ADD FRIEND</span>
                                <span class="bottom-key-1"></span>
                                <span class="bottom-key-2"></span>
                            </a>
                        </div>
                    </div>
                </div>
            </span>
            <span class="bottom-key-1"></span>
            <span class="bottom-key-2"></span>
        </div>
        <div class="row">
            <div class="col-9">
                <div class="row mt-3 g-3" id="friendsArticles"></div>
            </div>
            <div class="col-3">
                <div class="list-group mt-3" id="friendsList"></div>
            </div>
        </div>
    </div>
</body>

<footer>
    <script type="module" src="../../SCRIPTS/friends.js"></script>
    <?php include "../INCLUDES/footer.php" ?>
</footer>

</html>