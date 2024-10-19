<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fanimation Navigation</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/6ba0c41bed.js"></script>
    <link rel="stylesheet" href="http://localhost/Fanimation/shop/assets/css/header.css">
</head>
<body>
<nav>
    <div class="wrapper">
        <div class="logo"><a href="http://localhost/Fanimation/home.php">
                <img width="200" height="36" alt="Fanimation"
                     src="https://fanimation.com/wp-content/uploads/2021/04/Logo_white_1.png">
            </a></div>
        <div class="nav-container">
            <!--            <input type="radio" name="slider" id="menu-btn">-->
            <!--            <input type="radio" name="slider" id="close-btn">-->
            <?php
            $current_page = basename($_SERVER['PHP_SELF']); // Lấy tên tệp PHP hiện tại
            ?>

            <ul class="nav-links">
                <label for="close-btn" class="btn close-btn"><i class="fas fa-times"></i></label>
                <li><a href="http://localhost/Fanimation/home.php" class="<?= ($current_page == 'home.php') ? 'active' : '' ?>">Home</a></li>
                <li><a href="http://localhost/Fanimation/shop/controllers/ProductController.php" class="<?= ($current_page == 'ProductController.php') ? 'active' : '' ?>">Products</a></li>
                <li><a href="http://localhost/Fanimation/shop/views/about_us/aboutus.php" class="<?= ($current_page == 'aboutus.php') ? 'active' : '' ?>">About Us</a></li>
                <li><a href="https://fanimation.com/wp-content/uploads/2024/03/2024-Fanimation-Product-Catalog-LTFC0324.pdf">Explore</a></li>
                <li><a href="http://localhost/Fanimation/shop/views/Help/Help_Center.php">Help Center</a></li>
            </ul>

            <label for="menu-btn" class="btn menu-btn"><i class="fas fa-bars"></i></label>
        </div>
        <form class="search-box__wrapper">

            <input class="search-box" type="text" name="search" id="search">
            <i class="fas fa-search"></i>

        </form>


        <script>
            (function ($) {
                "use strict";

                $.fn.placeholderTypewriter = function (options) {
                    var settings = $.extend({
                        delay: 50,
                        pause: 1000,
                        text: []
                    }, options);

                    function typeString($target, index, cursorPosition, callback) {
                        var text = settings.text[index];
                        var placeholder = $target.attr('placeholder') || '';
                        $target.attr('placeholder', placeholder + text[cursorPosition]);

                        if (cursorPosition < text.length - 1) {
                            setTimeout(function () {
                                typeString($target, index, cursorPosition + 1, callback);
                            }, settings.delay);
                            return true;
                        }
                        callback();
                    }

                    function deleteString($target, callback) {
                        var placeholder = $target.attr('placeholder');
                        var length = placeholder.length;

                        $target.attr('placeholder', placeholder.substr(0, length - 1));

                        if (length > 1) {
                            setTimeout(function () {
                                deleteString($target, callback);
                            }, settings.delay);
                            return true;
                        }
                        callback();
                    }

                    function loopTyping($target, index) {
                        $target.attr('placeholder', '');
                        typeString($target, index, 0, function () {
                            setTimeout(function () {
                                deleteString($target, function () {
                                    loopTyping($target, (index + 1) % settings.text.length);
                                });
                            }, settings.pause);
                        });
                    }

                    return this.each(function () {
                        loopTyping($(this), 0);
                    });
                };

            }(jQuery));

            $(document).ready(function () {
                var placeholderText = [
                    "What do you need to buy?",
                    "Celling fan?",
                    "Pedestal fan?",
                    "Wall fan?",
                    "Exhaust fan?",
                    "Accessories?"
                ];

                $('#search').placeholderTypewriter({
                    text: placeholderText,
                    delay: 100,
                    pause: 2000
                });
            });
        </script>

        <div class="icon">
            <span id="username-display" style="color: #fff; display: none;"></span>
            <i class="fa-regular fa-user" id="user-icon"></i>
            <i class="fa-solid fa-cart-shopping" id="cart-icon" onclick="goToCheckout()">
                <span id="cart-count" style="color: white">0</span>
            </i>
            <div id="cart-items"></div> <!-- Giỏ hàng -->


            <div class="user-menu" id="user-menu">
                <a href="http://localhost/Fanimation/shop/views/customer/login.php" id="login">Login</a>
                <a href="http://localhost/Fanimation/shop/views/customer/signup.php" id="signup">Sign Up</a>
                <a href="http://localhost/Fanimation/home.php" id="logout" style="display: none;">Logout</a>
            </div>
    </div>
    </div>
</nav>
<script>

    // User login/logout functionality
    let isLoggedIn = false; // User login state

    const userIcon = document.getElementById('user-icon');
    const userMenu = document.getElementById('user-menu');
    const loginLink = document.getElementById('login');
    const signupLink = document.getElementById('signup');
    const logoutLink = document.getElementById('logout');

    // Check local storage for login state
    if (localStorage.getItem('isLoggedIn') === 'true') {
        isLoggedIn = true;
    }

    // Update user menu visibility based on login state
    updateUserMenu();

    userIcon.addEventListener('click', function() {
        // Toggle user menu visibility
        userMenu.style.display = userMenu.style.display === 'block' ? 'none' : 'block';
    });

    // Handle login functionality
    loginLink.addEventListener('click', function(event) {
        event.preventDefault();
        if (!isLoggedIn) {
            // Simulate login
            isLoggedIn = true; // Set the login state to true
            localStorage.setItem('isLoggedIn', 'true'); // Save state in local storage
            updateUserMenu(); // Update the user menu visibility
            window.location.href = 'http://localhost/Fanimation/shop/views/customer/login.php'; // Redirect to login page
        }
    });

    // Handle signup functionality
    signupLink.addEventListener('click', function(event) {
        event.preventDefault();
        window.location.href = 'http://localhost/Fanimation/shop/views/customer/signup.php'; // Redirect to signup page
    });

    // Handle logout functionality
    logoutLink.addEventListener('click', function(event) {
        event.preventDefault();
        // Simulate logout
        isLoggedIn = false; // Set login state to false
        localStorage.setItem('isLoggedIn', 'false'); // Update local storage
        updateUserMenu(); // Update the user menu visibility
        window.location.href = 'http://localhost/Fanimation/home.php'; // Redirect to homepage
    });

    function updateUserMenu() {
        if (isLoggedIn) {
            loginLink.style.display = 'none';
            signupLink.style.display = 'none';
            logoutLink.style.display = 'block';
        } else {
            loginLink.style.display = 'block';
            signupLink.style.display = 'block';
            logoutLink.style.display = 'none';
        }
    }

    // Add to cart functionality
    function addToCart(productId, productName, productPrice, selectedColor) {
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        const existingProductIndex = cart.findIndex(item => item.id === productId && item.color === selectedColor);

        if (existingProductIndex !== -1) {
            // If product already exists in the cart, increase the quantity
            cart[existingProductIndex].quantity += 1;
        } else {
            // If new product, add to cart
            cart.push({ id: productId, name: productName, price: productPrice, color: selectedColor || 'No color', quantity: 1 });
        }

        // Save updated cart to local storage
        localStorage.setItem('cart', JSON.stringify(cart));

        // Update cart icon and badge
        updateCartIcon();

        // Optionally, show a notification or message that the product was added
        alert(`${productName} has been added to cart!`);
    }

    // Function to update the cart icon and badge
    function updateCartIcon() {
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        const cartCount = cart.reduce((total, item) => total + item.quantity, 0);
        const cartCountBadge = document.getElementById('cart-count');

        if (cartCount > 0) {
            cartCountBadge.innerText = cartCount; // Set the badge text
            cartCountBadge.style.display = 'block'; // Make sure the badge is visible
        } else {
            cartCountBadge.innerText = '';
            cartCountBadge.style.display = 'none'; // Hide the badge
        }
    }

    // Navigate to checkout page
    function goToCheckout() {
        window.location.href = 'http://localhost/Fanimation/shop/views/product/checkout.php'; // Change this URL to your checkout page
    }

    // Call this function to initialize the cart display on page load
    updateCartIcon();
</script>

</body>
</html>

