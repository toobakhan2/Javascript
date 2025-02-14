<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input data
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $rating = $_POST['rating'] ?? '';

    // Basic validation
    // we can handle validation in php here but as required in the task we are also handling it in javascript.
    $errors = [];
    if (empty($name)) {
        $errors[] = 'Name is required.';
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'A valid email address is required.';
    }

    if (is_null($rating) || $rating < 1 || $rating > 5) {
        $errors[] = 'Rating must be an integer between 1 and 5.';
    }

    // Return response based on validation
    if (empty($errors)) {
        echo json_encode([
            'success' => true,
            'name' => htmlspecialchars($name, ENT_QUOTES, 'UTF-8'),
            'email' => htmlspecialchars($email, ENT_QUOTES, 'UTF-8'),
            'rating' => (int)$rating,
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'errors' => $errors,
        ]);
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bartlett</title>
    <!-- css link -->
     <link rel="stylesheet" href="css/style.css">
     <!-- bootstrap -->
      <link rel="stylesheet" href="css/bootstrap.min.css">
      <!-- icon -->
       <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css">
   
        
</head>
<body>
    <header>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="banner-content">
                        <h1>We’d Love Your Feedback</h1>
                    <p class="banner-text">
                        Tell us how we did! Your thoughts make us better, so let us know what rocked and what could use a little extra shine!
                    </p>
                    <a  class="theme-btn" href="#review"><span>Review Now!</span></a>
                    </div>
                </div>
                <div class="col-md-6">
                    <img src="img/review.gif" alt="" class="w-100">
                </div>
            </div>
        </div>
    </header>
    <section id="review">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="wrapper">
                        <h2>Rate Botterill & Bartlett’s 1-Day Business Workshop!</h2>
                        <p class="content">We’re all ears! How was it for you? Rate us from 1 (awful) to 5 (awesome).</p>
                    </div>
                    <!-- Adding novalidate to force my own validation -->
                        <form action="" novalidate method="POST"id="review_form">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="response_images">
                                        <img src="img/curiouscat.gif" class="w-50">
                                    </div>
                                </div>
                                 <!-- fields -->
                                <div class="col-md-6">
                                   
                                 <!-- name -->
                                 <div class="input-wrap val_input">

                                    <input type="text" id="name"   name="name" placeholder="">
                                    <label for="name">Full Name</label>
                                    <span class="error-message"></span>
                                 </div>
                                 <!-- email -->
                                 <div class="input-wrap val_input">

                                    <input type="email" id="email"  name="email" placeholder="">
                                    <label for="email">Email</label>
                                    <span class="error-message"></span>
                                 </div>
                                 <!-- rating -->
                                    <div class="input-wrap">
                                        <h3>Star Rating</h3>
                                        <div class="rating">
                                            <input type="number" name="rating" id="rating" hidden>
                                            <i class='bx bx-star star' data-value="1" style="--i: 0;"></i>
                                            <i class='bx bx-star star' data-value="2" style="--i: 1;"></i>
                                            <i class='bx bx-star star' data-value="3" style="--i: 2;"></i>
                                            <i class='bx bx-star star' data-value="4" style="--i: 3;"></i>
                                            <i class='bx bx-star star' data-value="5" style="--i: 4;"></i>
                                        </div>
                                        <span class="error-message"></span>
                                    </div>
                                <!--  -->

                                <div class="input-wrap  ">
                                    <button class="theme-btn dark" id="submit" name="submit" type="submit"><span>Submit Your Rating</span></button>
                                </div>
                                </div>

                            </div>
                        </form>
                </div>
            </div>
        </div>
    </section>
    <!-- Modal -->
    <div class="popup" id="success_popup">
        <div class="popup_content">
            <div class="img-wrap">
                <img src="img/happy.webp" id="star_1" class="popup_img">
            </div>
            <span class="close">&times;</span>
            <div class="success-message">Thank You, <b class="name_box"></b>,  for Your Review!
             <br>   <span class="validating">We appreciate your feedback, whether it’s positive or constructive. Your thoughts help us improve and serve you better!</span></div>
        </div>
    </div>
    ]
    <script src="js/script.js"></script>
</body>
</html>