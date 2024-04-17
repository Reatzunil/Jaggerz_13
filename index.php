<?php

require_once 'includes/connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process form data
    $username = $_POST['username'];
    $password = $_POST['password'];
    $number = $_POST['number'];
    $email = $_POST['email'];
    
    // File upload handling
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["file"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["file"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow only certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            echo "The file ". basename( $_FILES["file"]["name"]). " has been uploaded.";
            
            // Insert data into the database
            $sql = "INSERT INTO users (username, password, number, email, image)
            VALUES ('$username', '$password', '$number', '$email', '$target_file')";

            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

// Close MySQL connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, inital-scale=1.0">
    <title>Jagger Cuts and Tattoo</title>
    
    <!--website's icon-->
    <link rel="icon" type="image/png" href="images-folder/logo.png">

    <!--font awesome cdn link-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!---custom css file link---->
    <link rel="stylesheet" href="styles.css">

    <style>
        .slider {
    position: relative;
    max-width: 100%;
    overflow: hidden;
    margin-top: 20px;
    }

.slide {
    display: none;
    width: 100%;
}

.prev, .next {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background-color: rgba(0, 0, 0, 0.5);
    color: white;
    border: none;
    cursor: pointer;
    padding: 10px;
    z-index: 1000;
}

.prev {
    left: 0;
}

.next {
    right: 0;
}
    </style>
</head>
<body>
    
<!----header section starts---->

<header class="header">

    <a href="#" class="logo">
        <img src="images-folder/logo.png" width="70px">
    </a>

    <nav class="navbar">
        <a href="#home">home</a>
        <a href="#about">about</a>
        <a href="#products">products</a>
        <a href="#services">services</a>
        <a href="#booking">reservation</a>
        <a href="#contacts">contacts</a>
    </nav>

        <div class="icons">
            <div class="fas fa-bars" id="menu-btn">
            </div>
        </div>
    <div class="navbar1">
        <a href="#" onclick="showPersonDetails()">Login</a>
    </div>

    <div id="personModal" class="modal">
        <span class="close-btn" onclick="closePersonDetails()">&times;</span>

        <div id="loginModal">
            <div class="modal-content">
                <h2>Choose Login Type</h2>
        
                <button id="adminLoginBtn">Admin Login</button>
                <button id="userLoginBtn">User Login</button>
        
                <!-- Admin Login Form -->
                <div id="adminLoginForm" style="display:none;">
                    <h2>Admin Login Form</h2>
                    <form id="adminForm">
                        <input type="text" id="adminUsername" placeholder="Username">
                        <input type="password" id="adminPassword" placeholder="Password">
                        <button type="button" onclick="login('admin')">Login</button>
                    </form>
                </div>
                
                <!-- User Login Form -->
                <div id="userLoginForm" style="display:none;">
                    
                    <div id="userLoginForm1">

                        <h2>User Login Form</h2>
                        <form id="userForm">
                        <form method="POST" action="login.php">
                            <input type="text" name="username" placeholder="Username" required>
                            <input type="password" name="password" placeholder="Password" required>
                            <button type="submit">Login</button>
                            <h2>Not yet Registered?</h2>
                            <button id="userRegisterBtn" name="login">Register</button>
                        </form>
                    </div>
                    
                    <div id="successMessage"></div>
                    <div id="userRegistrationForm" style="display:none;">
                        <h2>User Registration Form</h2>
                        <form id="registerForm" method="POST" enctype="multipart/form-data" action="#">
                            <input type="text" id="user_user" name="username" placeholder="Username" required>
                            <input type="password" id="user_pass" name="password" placeholder="Password" required>
                            <input type="tel" name="number" placeholder="Contact#" required>
                            <input type="email" id="user_email" name="email" placeholder="Email" required>
                            <div class="upload-container">
                            <label for="file-upload" class="custom-button">Upload ID</label>
                            <input type="file" id="file-upload" name="file" accept="image/*" onchange="previewImage(event)" required>
                            </div>
                            <div id="image-preview"></div>
                            <button type="submit">Register Now</button>
                            <h2>Already a User?</h2>
                            <button id="userLoginBtn1">Login</button> 
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<!---header section ends-->

<!---home section starts-->

<section class="home" id="home">
    
    <div class="content">
        <h3>Always looks good</h3>
        <p>In JavaScript, there will be times when you need to access an HTML element. The querySelector method is a web API that selects the first element that matches the specified CSS selector passed into it.</p>
        <a href="#booking" class="btn">Reserve Now</a>
    </div>
    <div class="slider">
        <img src="images-folder/photo1.jpg" class="slide">
        <img src="images-folder/photo2.jpg" class="slide">
        <img src="images-folder/photo1.jpg" class="slide">
        <!-- Add more images as needed -->
            
        <!-- Previous and next buttons -->
        <button class="prev" onclick="plusSlides(-1)">&#10094;</button>
        <button class="next" onclick="plusSlides(1)">&#10095;</button>
    </div>
</section>

<!---home section ends-->

<!---about section starts-->

<section class="about" id="about">

    <h1 class="heading"><span>about</span>us</h1>

    <div class="row">

        <div class="image">
            <img src="images-folder/logo_1.jpg" width="400px">
        </div>

        <div class="content">
            <h3>What makes us special?</h3>
            <p>It appears that you’re trying to create a centered layout with a background image using CSS. Let’s break down your code snippet</p>
            <div class="hidden" id="additional-info">
                <p>This is additional information that slides down when you click on "Learn More".</p>
            </div>
            <a href="#" class="btn" id="learn-more-btn">Learn More</a>
        </div>

    </div>
</section>
<!---about section ends-->


<!---products section starts----->

<section class="products" id="products">

    <h1 class="heading">our<span>products</span></h1>

    <div class="box-container">
        
        <div class="box">
            <div class="image">
                <img src="images-folder/product-1.jpg" width="250px" height="350px" alt="">
            </div>
            <div class="content">
                <h3>Pomade Hair Wax</h3>
                
            <div class="price">₱150</div>
            </div>
        </div>
    </div>
</section>

<!---products section ends----->

<!---services section starts----->
<section class="services" id="services"> 

    <h1 class="heading"> our<span>services</span></h1>

    <div class="box-container">

        <div class="box">
            <img src="images-folder/minimalist.jpg" width="250px" height="350px" alt="">
            <h3>Minimalist Tattoo</h3>
            <div class="price">₱150</div>
        </div>
        <div class="box">
            <img src="images-folder/tattoo.jpg" width="250px" height="350px" alt="">
            <h3>Tattoo</h3>
            <div class="price">₱800</div>
        </div>
        <div class="box">
            <img src="images-folder/service.jpg" width="250px" height="350px" alt="">
            <h3>Haircut</h3>
            <div class="price">₱150</div>
            <h3>With shave</h3>
            <div class="price">₱200</div>
            <h3>With shampoo</h3>
            <div class="price">₱200</div>
            <h3>With haircolor</h3>
            <div class="price">₱500</div>
        </div>
        
    </div>
</section>

<!---services section ends----->

<!---booking section starts----->

<section class="booking" id="booking">

    <h1 class="heading"> <span>reserve</span>now</h1>

    <div class="row">
        <form action="" method="post">
            <div class="inputBox">
                <span class="fas fa-user"></span>
                <input type="text" name="name" placeholder="Name">
            </div>

            <div class="inputBox">
                <span class="fas fa-envelope"></span>
                <input type="email" name="email" placeholder="Email">
            </div>

            <div class="inputBox">
                <span class="fas fa-phone"></span>
                <input type="tel" name="number" placeholder="Number">
            </div>

            <div class="inputWithIcon">
                <label for="availability" class="date-picker-label">
                    <span class="fas fa-calendar"></span>
                    <input type="date" id="availability" name="availability" placeholder="Availability">
                </label>
            </div>

            <div class="inputWithIcon">
                <label for="time" class="time-picker-label">
                    <span class="fas fa-clock time-picker-icon"></span>
                    <input type="time" id="time" name="time" placeholder="Time">
                </label>
            </div>

            <div class="inputBox">
                <span class="fas fa-bar"></span>
                <select id="services">
                    <option value="2">Minimalist Tattoo</option>
                    <option value="3">Tattoo</option>
                    <option value="4">HairCut</option>
                    <option value="5">HairCut with shave</option>
                    <option value="6">Haircut wiht haircolor</option>
                    <option value="7">HairCut with shampoo</option>
                </select>
            </div>

            <div class="upload-container">
                <label for="file-upload" class="custom-button">Upload ID</label>
                <input type="file" id="file-upload" accept="image/" onchange="previewImage(event)">
            </div>

            <div id="image-preview"></div>

            <button id="reserveBtn" class="btn">Reserve Now</button>
        </form>
    </div>
</section>
   
<!---booking ends here--->

<!---contact section starts----->

<section class="contacts" id="contacts">

    <h1 class="heading"> <span>contact</span>us</h1>

    <div class="row">

        <iframe class="map" src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d247.39745675318113!2d124.53892297913605!3d7.199782656765955!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zN8KwMTEnNTkuNiJOIDEyNMKwMzInMjEuMCJF!5e0!3m2!1sen!2sph!4v1709469690633!5m2!1sen!2sph" allowfullscreen="" loading="lazy"></iframe>
    
        <form action="" method="post" class="contacts"> 
            <h4>Get in touch</h4>
            <br>
            <div class="inputBox">
                <h3>Poblacion 5, Midsayap, Cotabato, Philippines</h3>
                <h3>906-461-8563</h3>
                <h3>regfuna@gmail.com</h3>
            </div>
            <br>
            <button type="submit" name="send" class="btn">Contact now</button>
        </form>

    </div>
</section>

<!---contact section ends----->

<!---footer section starts----->

<section class="footer">

    <div class="share">
        
    </div>

    <div class="links">
        <a href="#">home</a>
        <a href="#">about</a>
        <a href="#">products</a>
        <a href="#">reservation</a>
        <a href="#">contacts</a>
    </div>
    <div class="contact">
       <h3> Poblacion 5, Midsayap, Cotabato, Philippines</h3>
       <h3> 906-461-8563</h3>
       <h3> regfuna@gmail.com</h3>
    </div>
    <div class="credit">created by <span>da barberz</span> | all rights reserved</div>
</section>


<script>

let slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
    showSlides(slideIndex += n);
}

function currentSlide(n) {
    showSlides(slideIndex = n);
}

function showSlides(n) {
    let i;
    const slides = document.getElementsByClassName("slide");
    if (n > slides.length) {slideIndex = 1}    
    if (n < 1) {slideIndex = slides.length}
    for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";  
    }
    slides[slideIndex-1].style.display = "block";  
}
</script>

<!----custom js file link---->
<script src="script.js"></script>

</body>
</html>