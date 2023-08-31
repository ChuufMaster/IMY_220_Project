<!DOCTYPE html>
<html lang="en">


<?php include "../INCLUDES/header.php" ?>


<body>
<script src="../../SCRIPTS/script.js"></script>

    <div class="container mt-5 mb-5">
        <div class="row justify-content-center align-items-center">
            <div class="col-5 h-50">
                <!-- ========================= CARD COL ========================= -->
                <div class="card text-center h-100 w-100 justify-content-center shadow fancy d-flex">
                    <span class="top-key"></span>
                    <span class="text">
                        <!-- ========================= CARD ========================= -->
                        <div class="card-body w-100 h-75">
                            <!-- ========================= CARD BODY ========================= -->
                            <h1>ADD ARTICLE</h1>
                            <form class="row m-3" action="../API.php" method="POST" id="add_article_form"
                                enctype='multipart/form-data'>
                                <div class="min-h-75 w-35 input-group row g-3">
                                    <div class="col">
                                        <input type="text" class="w-100 form-control" placeholder="title" name="title" required></input>
                                    </div>
                                    <div class="col">
                                        <input type="text" class="w-100 form-control" placeholder="author" name="author" required></input>
                                    </div>
                                </div>
                                <div class="input-group row g-3">

                                    <div class="col">
                                        <input type="text" class="w-100 form-control" placeholder="description" name="description" required></input>
                                    </div>
                                    <div class="col">
                                        <input type="date" class="w-100 form-control" name="date" required></input>
                                    </div>
                                </div>
                                <div class="min-h-75 input-group mt-5 w-100">
                                    <input type='file' class='form-control' name='image[]' id='image'
                                        multiple='multiple'  required/>
                                </div>
                                <div class="min-h-75 input-group my-5">
                                    <textarea class="w-100 form-control" placeholder="body" name="body" required></textarea>
                                </div>
                                <input type="hidden" value="add_article" name="type">
                                <input type="hidden" value=<?php echo '"' . $_GET['api_key'] . '"' ?> name="api_key">
                                <a class="fancy" href="#" id="add_article">
                                    <span class="overlay"></span>
                                    <span class="top-key"></span>
                                    <span class="text">ADD</span>
                                    <span class="bottom-key-1"></span>
                                    <span class="bottom-key-2"></span>
                                </a>
                            </form>
                            <!-- ========================= FORM ========================= -->
                        </div>
                        <!-- ========================= CARD BODY ========================= -->
                    </span>
                    <span class="bottom-key-1"></span>
                    <span class="bottom-key-2"></span>
                </div>
                <!-- ========================= CARD ========================= -->
            </div>
        </div>
    </div>
</body>
<footer>
    <?php include "../INCLUDES/footer.php" ?>
</footer>

</html>