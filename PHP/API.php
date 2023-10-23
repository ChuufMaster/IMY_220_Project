<?php
// Assuming you have established a database connection

header("Access-Control-Allow-Origin: http://localhost"); // Replace with your allowed origin
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");

require_once 'CLASSES/database.php';
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
class API
{
    private $host;
    private $username;
    private $password;
    private $database_name;
    private $db;
    public $status_codes = array(
    '400' => 'HTTP/1.1 400 Bad Request',
    '200' => 'HTTP/1.1 200 OK',
    '500' => 'HTTP/1.1 500 Internal Server Error'
    );

    public static function instance()
    {
        static $instance = null;
        if ($instance === null)
        {
            $instance = new API();
        }
        return $instance;
    }

    public function __construct()
    {
        $this->host = "localhost";
        $this->username = "u21456552";
        $this->password = "jdqmbgai";
        $this->database_name = "u21456552";
        //$this->username = "root";
        //$this->password = "";
        //$this->database_name = "imy_21456552";
        //$this->db = Database::instance($this->host, $this->username, $this->password, $this->database_name);
        require "./configs/config.php";
        $this->db = Database::instance($host, $username, $password, $database_name);
    }

    private function return_data($header, $data, $status)
    {

        header($this->status_codes[$header]);
        header('content-Type:application/json');
        $response = array("status" => $status,
        "data" => $data
        );

        echo json_encode($response);
        exit();
    }

    private function check_set($to_check, $message, $data)
    {
        try
        {
            if (!isset($data[$to_check]) || empty($to_check))
                $this->return_data('400', $message, 'error');
        }
        catch (error)
        {
            $this->return_data('500', $message, 'error');
        }
    }

    private function check_set_optional($to_check, $data)
    {

        if (!isset($data[$to_check]) || empty($to_check))
            return false;
        return $data[$to_check];
    }

    public function request()
    {
        //echo "poes";
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        if ($data === null)
            $data = $_POST;
        if ($_SERVER['REQUEST_METHOD'] !== "POST")
        {
            $this->return_data('400', 'Method must be post', 'error');

        }
        if (!isset($data) || empty($data))
        {
            $this->return_data('400', 'Request Body expected', "error");
            //$this->return_data('400', $data, "error");
        }

        $this->getType($data);

    }

    public function getType($data)
    {
        $this->check_set('type', 'Type must be set', $data);
        $type = $data['type'];
        //$this->return_data('400', 'Request Body expected', "error");

        switch ($type)
        {
            case 'login':
                $this->handleLoginRequest($data);
                break;
            case 'get_by_conditions':
                $this->get_by_conditions($data);
                break;
            case 'add_article':
                $this->add_article($data);
                break;
            case 'get_activity':
                $this->get_activity($data);
                break;
            case 'sign_up':
                $this->sign_up($data);
                break;
            case 'get_profile':
                $this->get_profile($data);
                break;
            case 'get_MyArticles':
                $this->get_MyArticles($data);
                break;
            case 'get_friends':
                $this->get_friends($data);
                break;
            case 'get_friendsArticles':
                $this->get_friendsArticles($data);
                break;
            case 'add_friend':
                $this->add_friend($data);
            default:
                $this->return_data('400', 'Type is expected or is incorrect', 'error');
                break;
        }
    }

    private function sign_up($request_body)
    {
        // Validate the input
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
            $this->return_data('400', $send, "error");
        }
        // Check if the user already exists
        $statement = [
            "tables" => "users",
            "where" => [
                "email" => $email
            ]
            ];

        $result = $this->db->SELECT($statement);
        if ($result->num_rows > 0)
        {
            $send = array(
                'message' => "An account already exists with that Email."
            );
            $this->return_data('400', $send, "error");
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
        $this->db->INSERT($statement);
        $send = array(
            'message' => "Signup successful!"
        );
        $return = array(
            'message' => "Login Successful!",
            'api_key' => $api_key
        );
        header("Location: PAGES/activity.php?api_key=$api_key");
        exit();
        //$this->return_data('200', $send, "success");
    }

    private function handleLoginRequest($request_body)
    {

        $email = $request_body['email'];
        $password = $request_body['password'];
        if (empty($email) || empty($password))
        {
            $return = array(
                'message' => "Email and password are required."
            );

            $this->return_data('400', $return, "error");
        }
        // Check if the user already exists
        $statement = [
            "tables" => "users",
             "where" => [
                "email" => [$email, "="],
             ]
        ];
        $result = $this->db->SELECT($statement);
        if (gettype($result) === 'string')
        {
            $this->return_data('400', $result, "string test");
        }
        if ($result->num_rows === 0)
        {
            $return = array(
                'message' => "There is no account associated with that Email. Please try again."
            );
            $this->return_data('400', $return, "error");
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
            header("Location: PAGES/activity.php?api_key=$api_key");
            exit();
            //$this->return_data('200', $return, "Success");
        }
        else
        {
            $return = array(
                'message' => "Incorrect Email or Password."
            );

            $this->return_data('400', $return, "error");
        }
    }

    private function get_by_conditions($data)
    {
        $this->check_set('tables', 'Table must be set', $data);
        //$this->check_set('where', 'Conditions must be set', $data);

        $results = $this->db->SELECT($data);
        if (gettype($results) === 'string')
            $this->return_data('500', $results, 'error');


        $response = array();

        if ($results->num_rows <= 0)
        {
            $this->return_data('200', 'No results found', 'Success');
        }

        while ($row = mysqli_fetch_assoc($results))
        {
            $response[] = $row;
        }

        $this->return_data('200', $response, 'Success');
    }

    private function add_article($data)
    {
        $this->check_set('title', 'Title must be set', $data);
        $this->check_set('author', 'Author must be set', $data);
        $this->check_set('body', 'Body must be set', $data);
        $this->check_set('date', 'Date must be set', $data);
        if (!isset($_FILES['image']))
        {

            $this->return_data('400', $_FILES['image'], 'error');
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

                $gallery = dirname(dirname(__FILE__)) . '/gallery';
                if (!file_exists($gallery))
                {
                    mkdir($gallery, 0755, true);
                }

                $image_name = uniqid("image_", true) . ".png";
                $path = dirname(dirname(__FILE__)) . '/gallery/' . $image_name;
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

        /*$query = "INSERT INTO tbarticles (user_id, title, description, author, date)
                              VALUES ((SELECT user_id FROM tbusers WHERE email = '$email'),
                                      '$article_name',
                                      '$article_description',
                                      '$article_author',
                                      '$article_date')";*/

        $statement = [
            'table' => "tbarticles",
            'data' => [
                    'api_key' => $data['api_key'],
                    'title' => $data['title'],
                    'description' => $data['description'],
                    'author' => $data['author'],
                    'date' => $data['date'],
                    'body' => $data['body']
                ]
            ];
        $result = $this->db->INSERT($statement);

        /* $query = "INSERT INTO tbgallery (image_name, article_id)
                          VALUES ('$image_name', (SELECT article_id FROM tbarticles WHERE user_id = '$userid' AND title = '$article_name' LIMIT 1))";*/
        $statement = [
            'table' => 'tbgallery',
            "data" => [
                'image_name' => $image_name,
                'article_id' => [
                    "(SELECT article_id FROM tbarticles WHERE api_key = '" . $data['api_key'] . "' AND title = '" . $data['title'] . "' LIMIT 1)"]

                ]
            ];
        $result = $this->db->INSERT($statement);
        if (gettype($result) === 'string')
        {
            $this->return_data('400', $result, 'error');
        }
        header("Location: PAGES/home.php?api_key=" . $statement['api_key']);
        exit();
        //$this->return_data('200', 'Article Successfully added', 'success');
    }

    public function get_activity($data)
    {
        $statement = [
            'tables' => ["tbarticles"],
            'left_join' => [
                "tables" => ['tbgallery'],
                'columns' => [
                        ["article_id" => [
                            ["tbarticles", "article_id"], "="
                        ]]
                    ]
                    ],
            "order_by" => [
                "tbarticles" => [
                    "date" => "DESC"
                ]
            ]
            ];
        $result = $this->db->SELECT($statement);
        if (gettype($result) === 'string')
        {
            $this->return_data("500", $result, 'error');
        }
        while ($row = mysqli_fetch_assoc($result))
        {
            $response[] = $row;
        }

        $this->return_data('200', $response, 'Success');
    }

    public function get_profile($data)
    {
        $this->check_set("api_key", "Api key expected", $data);
        $statement = [
            "tables" => ["users"],
            "where" =>
            [
                "users" => [
                    "api_key" => [$data["api_key"], "="]
                ]
            ],
            "left_join" => [
                "tables" => ["profilegallery"],
                "columns" => [
                    ["api_key" => [
                            ["users", "api_key"], "="
                        ]]
                ]
            ]
        ];
        $result = $this->db->SELECT($statement);
        if (gettype($result) == 'string')
        {
            $this->return_data("500", $result, 'error');
        }

        while ($row = mysqli_fetch_assoc($result))
        {
            $response[] = $row;
        }

        $this->return_data('200', $response, 'Success');
    }

    public function get_MyArticles($data)
    {
        $this->check_set('api_key', 'API key expected', $data);

        $statement = [
            'tables' => ["tbarticles"],
            'left_join' => [
                "tables" => ['tbgallery'],
                'columns' => [
                        ["article_id" => [
                            ["tbarticles", "article_id"], "="
                        ]]
                    ]
                    ],
            "order_by" => [
                "tbarticles" => [
                    "date" => "DESC"
                ]
                ],
            "where" => [
                "tbarticles" => [
                    "api_key" => [$data["api_key"], "="]
                ]
            ]
            ];

        $result = $this->db->SELECT($statement);
        if (gettype($result) == 'string')
        {
            $this->return_data("500", $result, 'error');
        }

        while ($row = mysqli_fetch_assoc($result))
        {
            $response[] = $row;
        }

        $this->return_data('200', $response, 'Success');
    }

    public function get_friends($data)
    {
        $this->check_set('api_key', 'Api key expected', $data);

        $statement = [
            'tables' => ["friends"],
            'left_join' => [
                'tables' => ['users'],
                'columns' => [
                    ['api_key' => [
                        ['friends', 'friend_id'], '='
                    ]]
                ]
                    ],
                    'where' => [
                        'friends' => ['account_id' => [$data['api_key'], '=']]
                    ]
                    ];
        $result = $this->db->SELECT($statement);
        if (gettype($result) == 'string')
        {
            $this->return_data("500", $result, 'error');
        }

        while ($row = mysqli_fetch_assoc($result))
        {
            $response[] = $row;
        }

        $this->return_data('200', $response, 'Success');
    }

    public function get_friendsArticles($data)
    {
        $this->check_set('api_key', 'Api key expected', $data);

        $statement = [
            'tables' => ["friends"],
            'left_join' => [
                'tables' => ['users', 'tbarticles', 'tbgallery'],
                'columns' => [
                    ['api_key' => [
                        ['friends', 'friend_id'], '='
                    ]],
                    ['api_key' => [
                        ['friends', 'friend_id'], '='
                    ]],
                    ["article_id" => [
                        ["tbarticles", "article_id"], "="
                    ]]

                ]
                    ],
                    'where' => [
                        'friends' => ['account_id' => [$data['api_key'], '=']]
                    ]
                    ];
        $result = $this->db->SELECT($statement);
        if (gettype($result) == 'string')
        {
            $this->return_data("500", $result, 'error');
        }

        while ($row = mysqli_fetch_assoc($result))
        {
            $response[] = $row;
        }

        $this->return_data('200', $response, 'Success');
    }

    public function add_friend($data)
    {
        $this->check_set('friendName', 'Friend name expected', $data);
        $this->check_set('api_key', 'API key expected', $data);

        $statement = [
            'tables' => 'users',
            'where' => [
                "email" => [$data['friendName'], '=']
            ]];
        $result = $this->db->SELECT($statement);

        if (gettype($result) == 'string')
        {
            $this->return_data('500', $result, 'error');
        }

        while ($row = mysqli_fetch_assoc($result))
        {
            $response[] = $row;
        }

        if (count($response) <= 0)
        {
            $this->return_data('No user found', $response, 'error');
        }

        

        $statement = [
            "table" => "friends",
            "data" => [
                "account_id" => $data["api_key"],
                "friend_id" => $response[0]["api_key"]
            ]
            ];

        $result = $this->db->INSERT($statement);
        if (gettype($result) == "string")
        {
            $this->return_data("500", $result, "error");
        }
        $statement = [
            "table" => "friends",
            "data" => [
                "account_id" => $response[0]["api_key"],
                "friend_id" => $data["api_key"]
            ]
            ];
        $result = $this->db->INSERT($statement);

        if (gettype($result) == "string")
        {
            $this->return_data("500", $result, "error");
        }
        $this->return_data('200', $response, 'Success');
    }

}

$api = API::instance();
$api->request();

?>