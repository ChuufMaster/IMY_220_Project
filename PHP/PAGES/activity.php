<!DOCTYPE html>
<html lang="en">


<?php include "../INCLUDES/header.php" ?>

<body>
    <div class="container mb-5 mt-3 pb-5">
            <div class="row g-3">
                <?php
                $url = 'http://localhost/IMY_220_Project/PHP/API.php';

                // Data to send in the POST request (can be an associative array)
                $data = array(
                    'type' => 'get_activity',
                );

                // Initialize cURL session
                $ch = curl_init();

                // Set cURL options
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data)); // Convert data to URL-encoded format
                
                // Execute cURL session and get the response
                $response = curl_exec($ch);

                // Check for cURL errors
                if (curl_errno($ch))
                {
                    echo 'Curl error: ' . curl_error($ch);
                }

                // Close cURL session
                curl_close($ch);

                // Process the API response
                
                if ($response)
                {
                    //echo $response;
                    $response = json_decode($response, true);
                    foreach ($response['data'] as $row)
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
                                            <a class="fancy" data-bs-toggle="collapse" href="#body'.$row['article_id'].'" role="button" aria-expand="false" aria-controls="body'.$row["article_id"].'">
                                                <span class="top-key"></span>
                                                <span class="text">FULL ARTICLE</span>
                                                <span class="bottom-key-1"></span>
                                                <span class="bottom-key-2"></span>
                                            </a>
                                            <div class="collapse" id="body'.$row["article_id"].'">
                                                <div class="card card-body">
                                                    '.$row["body"].'
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