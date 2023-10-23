<!DOCTYPE html>
<html lang="en">


<?php include "../INCLUDES/header.php" ?>
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
if ($_SERVER['REQUEST_METHOD'] === "POST")
{
    $data = $_POST;
    require "../configs/config.php";
    $db = new mysqli($host, $username, $password, $database_name);
    if ($db->connect_error)
    {
        echo $db->connect_error;
    }

    if (!isset($_FILES['image']))
    {

    }
    $image_name = "";
    foreach ($_FILES['image']['error'] as $key => $error)
    {
        if ($error === UPLOAD_ERR_OK)
        {
            $image = $_FILES['image']['tmp_name'][$key];
            $imageInfo = getimagesize($image);
            if ($imageInfo !== false && $imageInfo['mime'] !== 'image/png')
            {
                echo "File must be a PNG image";
                die;
            }

            $gallery = dirname(dirname(dirname(__FILE__))) . '/gallery';

            $image_name = uniqid("image_", true) . ".png";
            $path = dirname(dirname(dirname(__FILE__))) . '/gallery/' . $image_name;
            if (move_uploaded_file($image, $path))
                {
                    //echo "File uploaded successfully and moved to '$path'.";
                }
                else
                {
                    echo "Error moving file.";
                    die;
                }
        }
    }

    $api_key = $data["api_key"];
    $title = $data["title"];
    $description = $data["description"];
    $author = $data["author"];
    $date = $data["date"];
    $body = $data["body"];

    $query = "INSERT INTO tbarticles (api_key,title,description,author,date,body) 
        VALUES ('$api_key', '$title', '$description', '$author', '$date', '$body')";
    $result = $db->query($query);
    if (!$result)
    {
    }

    $query = "INSERT INTO tbgallery
        (image_name, article_id) VALUES
        ('$image_name',
            (SELECT article_id FROM tbarticles WHERE api_key = '$api_key' AND title = '$title' LIMIT 1))
    ";
    $result = $db->query($query);
    //$result = $this->db->INSERT($statement);
    if (gettype($result) === 'string')
    {
        //$this->return_data('400', $result, 'error');
    }
    header("Location: home.php?api_key=" . $_GET['api_key']);
    //exit();
//$this->return_data('200', 'Article Successfully added', 'success');


}
?>

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
                            <form class="row m-3" <?php echo 'action="home.php?api_key=' . $_GET["api_key"] . '"' ?>
                                method="POST" id="add_article_form" enctype='multipart/form-data'>
                                <div class="min-h-75 w-35 input-group row g-3">
                                    <div class="col">
                                        <input type="text" class="w-100 form-control" placeholder="title" name="title"
                                            required id="title"></input>
                                    </div>
                                    <div class="col">
                                        <input type="text" class="w-100 form-control" placeholder="author" name="author"
                                            required id="author"></input>
                                    </div>
                                </div>
                                <div class="input-group row g-3">

                                    <div class="col">
                                        <input type="text" class="w-100 form-control" placeholder="description"
                                            name="description" required id="description"></input>
                                    </div>
                                    <div class="col">
                                        <input type="date" class="w-100 form-control" name="date" required id="name"></input>
                                    </div>
                                </div>
                                <div class="min-h-75 input-group mt-5 w-100">
                                    <input type='file' class='form-control' name='image[]' id='image'
                                        multiple='multiple' required id="image"/>
                                </div>
                                <div class="min-h-75 input-group my-5">
                                    <textarea class="w-100 form-control" placeholder="body" name="body"
                                        required id="body"></textarea>
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