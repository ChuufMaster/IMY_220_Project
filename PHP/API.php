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

    private function get_response($result)
    {
        $jsonKeys = [
            "tags",
            "list"
        ];
        if (gettype($result) == 'string')
        {
            $this->return_data("500", $result, 'error');
        }

        while ($row = mysqli_fetch_assoc($result))
        {
            foreach ($jsonKeys as $key)
            {
                if (isset($row[$key]))
                {
                    $column = json_decode($row[$key], true);
                    $row[$key] = $column;
                }
            }
            $response[] = $row;
        }
        return $response;
    }

    public function request()
    {
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
            case 'get_user_profile':
                $this->get_user_profile($data);
                break;
            case 'get_lists':
                $this->get_lists($data);
                break;
            case 'update_info':
                $this->update_info($data);
                break;
            case 'update_profile_pic':
                $this->update_profile_pic($data);
                break;
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


        $random_images = [
            'doodle.png',
            'existence.png',
            'raccoon.jpg',
            'react.jpeg'
        ];
        $statement = [
            'table' => 'gallery',
            'data' => [
                'api_key' => $api_key,
                'image_name' => $random_images[array_rand($random_images)]
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
        $this->check_set('tags', 'Tags must be set', $data);
        if (!isset($_FILES['image']))
        {

            $this->return_data('400', $_FILES['image'], 'error');
        }

        $image_name = "";

        $filetype = array('jpeg', 'jpg', 'png', 'gif', 'PNG', 'JPEG', 'JPG');
        foreach ($_FILES as $key)
        {

            $gallery = dirname(dirname(__FILE__)) . '/gallery';
            if (!file_exists($gallery))
            {
                mkdir($gallery, 0755, true);
            }

            $image_name = uniqid("image_", true) . ".png";
            $path = dirname(dirname(__FILE__)) . '/gallery/' . $image_name;
            $file_ext = pathinfo($image_name, PATHINFO_EXTENSION);
            if (in_array(strtolower($file_ext), $filetype))
            {

                if (move_uploaded_file($key['tmp_name'], $path))
                {
                    //echo 'yes';
                }
                else
                {
                    //echo 'no';
                }

            }
            else
            {
                echo "FILE_TYPE_ERROR";
            } // Its simple code.Its not with proper validation.
        }

        //echo ($data['tags']);
        $statement = [
            'table' => "tbarticles",
            'data' => [
                    'api_key' => $data['api_key'],
                    'title' => $data['title'],
                    'description' => $data['description'],
                    'author' => $data['author'],
                    'date' => $data['date'],
                    'body' => $data['body'],
                    //'tags' => json_encode($data['tags'])
                    'tags' => $data['tags']
                ]
            ];
        $result = $this->db->INSERT($statement);

        if (gettype($result) === 'string')
        {
            $this->return_data('400', $result, 'error');
        }
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
        //header("Location: PAGES/home.php?api_key=" . $statement['api_key']);
        //exit();
        $this->return_data('200', 'Article Successfully added', 'success');
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
            $tags = json_decode($row['tags'], true);
            $row['tags'] = $tags;
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
            $tags = json_decode($row['tags'], true);
            $row['tags'] = $tags;
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
        $response = $this->get_response($result);
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
        $response = $this->get_response($result);
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

    public function get_user_profile($data)
    {
        $this->check_set("api_key", 'Api Key expected', $data);
        $this->check_set("email", 'Account Email expected', $data);

        $statement = [
            'tables' => ['users'],
            'where' => [
                'users' => [
                    'email' => [$data['email'], '=']
                ]
            ],
            'left_join' => [
                'tables' => ['profilegallery'],
                'columns' => [
                    ['api_key' => [
                        ['users', 'api_key'], '='
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
        //var_dump($response);
        $friendTest = [
            'tables' => 'friends',
            'where' => [
                'account_id' => [$data['api_key'], '=', 'AND'],
                'friend_id' => [$response[0]['api_key'], '=']
            ]
            ];

        $friendResult = $this->db->SELECT($friendTest);

        if (gettype($result) == 'string')
        {
            $this->return_data("500", $result, 'error');
        }


        //var_dump($friendResult);
        if ($friendResult->num_rows > 0)
        {

            $response['friends'] = true;
        }
        else
        {
            $response['friends'] = false;
        }

        $this->return_data('200', $response, 'Success');

    }

    public function get_lists($data)
    {
        $this->check_set('api_key', 'Api key expected', $data);
        $statement = [
            'tables' => 'lists',
            'where' => [
                'api_key' => [$data['api_key'], '=']
            ]
            ];

        $result = $this->db->SELECT($statement);
        $response = $this->get_response($result);
        $this->return_data('200', $response, 'Success');
    }

    public function add_list($data)
    {
        $this->check_set('api_key', 'Api key expected', $data);
        $this->check_set('list', 'List expected', $data);
        $this->check_set('name', 'List name expected', $data);

        $statement = [
            'table' => 'list',
            'data' => [
                'api_key' => $data['api_key'],
                'list' => $data['list'],
                'name' => $data['name']
            ]
            ];

        $result = $this->db->INSERT($statement);
        if (gettype($result) == "string")
        {
            $this->return_data("500", $result, "error");
        }
        $this->return_data('200', 'List successfully added', 'Success');
    }

    public function update_info($data)
    {
        $this->check_set('api_key', 'Api Key expected', $data);
        $this->check_set('info_column', 'Info type expected', $data);
        $this->check_set('info_value', 'Info value expected', $data);

        $statement = [
            'table' => 'users',
            'data' => [
                $data['info_column'] => $data['info_value']
            ],
            'where' => [
                'api_key' => [$data['api_key'], '=']
            ]
        ];

        $result = $this->db->UPDATE($statement);

        if (gettype($result) == "string")
        {
            $this->return_data("500", $result, "error");
        }
        $this->return_data('200', 'Details successfully updated', 'Success');
    }

    public function update_profile_pic($data)
    {
        $this->check_set('api_key', 'Api Key expected', $data);
        if (!isset($_FILES['picture']))
        {

            $this->return_data('400', $_FILES['picture'], 'error');
        }

        $image_name = "";

        $filetype = array('jpeg', 'jpg', 'png', 'gif', 'PNG', 'JPEG', 'JPG');
        foreach ($_FILES as $key)
        {

            $gallery = dirname(dirname(__FILE__)) . '/PROFILES';
            if (!file_exists($gallery))
            {
                mkdir($gallery, 0755, true);
            }

            $file_name = $key['name'];
            $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
            $image_name = uniqid("image_", true) . "." . $file_ext;
            $path = dirname(dirname(__FILE__)) . '/PROFILES/' . $image_name;
            if (in_array(strtolower($file_ext), $filetype))
            {

                if (move_uploaded_file($key['tmp_name'], $path))
                {
                    //echo 'yes';
                }
                else
                {
                    //echo 'no';
                }

            }
            else
            {
                echo "FILE_TYPE_ERROR";
            } // Its simple code.Its not with proper validation.
        }

        /*$statement = [
            'table' => 'profilegallery',
            'data' => [
                'api_key' => $data['api_key'],
                'image_name' => $image_name
            ]
            ];*/
        $statement = [
            'table' => 'profilegallery',
            'data' => [
                'image_name' => $image_name
            ],
            'where' => [
                'api_key' => [$data['api_key'], '=']
                ]
            ];
        $result = $this->db->UPDATE($statement);
        if (gettype($result) === 'string')
        {

            //$result = $this->db->UPDATE($statement);
            $this->return_data('400', $result, 'error');

        }
        $this->return_data('200', $image_name, 'success');
    }
}

$api = API::instance();
$api->request();

?>