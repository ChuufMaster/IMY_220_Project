<!DOCTYPE html>
<html lang="en">


<?php include "../INCLUDES/header.php";
require_once '../CLASSES/database.php';
if ($_SERVER["REQUEST_METHOD"] === "POST")
{
    require "../configs/congfig.php";
    $db = new mysqli($host, $username, $password, $database_name);
    $request_body = $_POST;
    if ($request_body["type"] === 'login')
    {
        $email = $request_body['email'];
        $password = $request_body['password'];
        if (empty($email) || empty($password))
        {
            header("Location: ../../index.html");
        }
        // Check if the user already exists
        $statement = [
            "tables" => "users",
             "where" => [
                "email" => [$email, "="],
             ]
        ];
        //$result = $this->db->SELECT($statement);
        $result = $db->query("SELECT * FROM users WHERE email = '$email'");
        //if (gettype($result) === 'string')
        //{
        //    $this->return_data('400', $result, "string test");
        //}
        if ($result->num_rows === 0)
        {
            //$return = array(
            //    'message' => "There is no account associated with that Email. Please try again."
            //);
            //$this->return_data('400', $return, "error");
            header("Location: ../../index.html");
        }
        $row = $result->fetch_assoc();
        $db_password = $row['password'];
        //$salted_password = $row['salt'] . $password;
        if ($password === $db_password)
        {
            $api_key = $row['api_key'];
            $return = array(
                'message' => "Login Successful!",
                'api_key' => $api_key
            );
            header("Location: activity.php?api_key=$api_key");
            //exit();
            //$this->return_data('200', $return, "Success");
        }
        else
        {
            header("Location: ../../index.html");
            //$return = array(
            //    'message' => "Incorrect Email or Password."
            //);

            //$this->return_data('400', $return, "error");
        }
    }
    else if ($request_body["type"] === "sign_up")
    {
        $email = $request_body['email'];
        $password = $request_body['password'];
        $first_name = $request_body['first_name'];
        $last_name = $request_body['last_name'];
        $send = array();
        if (empty($email) || empty($password))
        {
            $send = array(
                'message' => "Email and password are required."
            );
            header("Location: ../../index.html");
        }
        // Check if the user already exists
        $statement = [
            "tables" => "users",
            "where" => [
                "email" => $email
            ]
            ];

        //$result = $this->db->SELECT($statement);
        $result = $db->query("SELECT * FROM users where email = '$email'");
        if ($result->num_rows > 0)
        {
            $send = array(
                'message' => "An account already exists with that Email."
            );
            header("Location: ../../index.html");
            //$this->return_data('400', $send, "error");
        }
        // Generate a random salt
        //$salt = bin2hex(random_bytes(6));

        // Combine the salt with the password
        //$salted_password = $salt . $password;

        // Hash the salted password
        //$hashed_password = password_hash($salted_password, PASSWORD_DEFAULT);

        $api_key = bin2hex(random_bytes(16));
        $statement = [
            "table" => "users",
            "data" => [
                "email" => $email,
                "password" => $password,
                "first_name" => $first_name,
                "last_name" => $last_name,
                "api_key" => $api_key
            ]
            ];
        //$this->db->INSERT($statement);
        $result = $db->query("INSERT INTO users (email, password, first_name,last_name, api_key) VALUES ($email, $password, $first_name, $last_name, $api_key)");
        $send = array(
            'message' => "Signup successful!"
        );
        $return = array(
            'message' => "Login Successful!",
            'api_key' => $api_key
        );
        header("Location: activity.php?api_key=$api_key");
        //exit();
    }
}

?>

<body>
    <div class="container mb-5 mt-3 pb-5">
        <div class="row g-3">
            <?php



            error_reporting(E_ALL);
            ini_set('display_errors', 1);
            $url = 'http://localhost/IMY_220_Project/PHP/API.php';

            // Data to send in the POST request (can be an associative array)
            $data = array(
                'type' => 'get_activity',
            );

            // Initialize cURL session
            //$ch = curl_init();
            
            // Set cURL options
            //curl_setopt($ch, CURLOPT_URL, $url);
            //curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            //curl_setopt($ch, CURLOPT_POST, true);
            //curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data)); // Convert data to URL-encoded format
            
            // Execute cURL session and get the response
            

            $host = "localhost";
            $username = "u21456552";
            $password = "jdqmbgai";
            $database_name = "u21456552";

            $db = new mysqli($host, $username, $password, $database_name);
            if ($db->connect_error)
            {
                echo $db->connect_error;
            }
            $query = "SELECT * from tbarticles a LEFT JOIN tbgallery g ON g.article_id=a.article_id ORDER BY a.date DESC";
            $result = $db->query($query);

            $response;
            if (!$result)
            {
                echo $db->error;
            }
            while ($row = $result->fetch_assoc())
            {
                $response[] = $row;
            }

            // Process the API response
            //$response = get_activity($db);
            //echo( $result);
            if ($response)
            {
                //echo $response;
                //$response = json_decode($response, true);
                foreach ($response as $row)
                {
                    echo '
					<div class="col-6">
						<div class="p-1 card h-100 fancy">
                        <span class="top-key"></span>
                        <span class="text">
                                <div class="row g-0">
                                    <div class="col-4">
                                        <div class="image-container">
                                            <img src="../../gallery/' . $row['image_name'] . '" alt="Article Image" class="img-fluid">
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        <div class="card-body">
                                            <h5 class="card-title">' . $row['title'] . '</h5>
                                            <h6 class="card-subtitle"> - ' . $row['author'] . '</h6>
                                            <p class="card-text">' . $row['description'] . '</p>
                                            <a class="fancy" data-bs-toggle="collapse" href="#body' . $row['article_id'] . '" role="button" aria-expand="false" aria-controls="body' . $row["article_id"] . '">
                                                <span class="top-key"></span>
                                                <span class="text">FULL ARTICLE</span>
                                                <span class="bottom-key-1"></span>
                                                <span class="bottom-key-2"></span>
                                            </a>
                                            <div class="collapse" id="body' . $row["article_id"] . '">
                                                <div class="card card-body">
                                                    ' . $row["body"] . '
                                                </div>
                                            </div>
                                            <p class="card-text"><small class="text-muted">' . $row['date'] . '</small></p>
                                        </div>
                                    </div>
                                </div>
                            </span>
                            <span class="bottom-key-1"></span>
                            <span class="bottom-key-2"></span>
                        </div>
					</div>';
                }
            }
            else
            {
                echo 'No API response received.';
            }
            ?>
        </div>
    </div>
</body>

<footer>
    <?php include "../INCLUDES/footer.php" ?>
</footer>

</html>