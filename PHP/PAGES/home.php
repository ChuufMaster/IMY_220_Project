<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "../INCLUDES/header.php" ?>
</head>

<body>
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
                            <h1>New Article</h1>
                            <form class="row m-3" action="../API.php" method="POST" id="add_article" enctype='multipart/form-data'>
                                <div class="min-h-75 w-35 input-group row g-3">
                                    <div class="col">
                                        <input type="text" class="w-100 form-control" name="title"></input>
                                    </div>
                                    <div class="col">
                                        <input type="text" class="w-100 form-control" name="author"></input>
                                    </div>
                                </div>
                                <div class="min-h-75 input-group mt-5">
                                    <input type="text" class="w-100 custom-control" name="description" ></input>
                                </div>
                                <div class="min-h-75 input-group mt-5 custom-control">
                                    <input type='file' class='custom-control' name='image[]' id='image'
                                        multiple='multiple' />
                                </div>
                                <div class="min-h-75 input-group mt-5">
                                    <textarea class="w-100 custom-control" name="body"></textarea>
                                </div>
                                <div class="min-h-75 input-group mt-5">
                                    <input type="date" class="w-100 custom-control" name="date" ></input>
                                </div>
                                <input type="hidden" value="add_article" name="type">
                                <input type="hidden" value= <?php echo '"'.$_GET['api_key'].'"'?> name="api_key">
                                <input type="submit">
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