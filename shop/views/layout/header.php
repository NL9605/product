<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fanimation Navigation</title>
    <link rel="stylesheet" href="../shop/assets/css/header.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/6ba0c41bed.js"></script>
</head>
<body>
<style>
    /* To keep the existing styles */
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap');

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }

    nav {
        position: fixed;
        z-index: 99;
        width: 100%;
        background: #354B59;
    }

    nav .wrapper {
        position: relative;
        max-width: 1300px;
        padding: 0px 30px;
        height: 70px;
        line-height: 70px;
        margin: auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-right: 20%;
    }

    .wrapper .logo {
        margin-top: 10px;
    }

    .nav-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .wrapper .nav-links {
        display: inline-flex;
        cursor: pointer;
    }

    .nav-links li {
        list-style: none;
    }

    .nav-links li a {
        position: relative; /* Add relative positioning */
        color: #f2f2f2;
        text-decoration: none;
        font-size: 18px;
        padding: 9px 15px;
        border-radius: 5px;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .nav-links li a::after {
        content: ""; /* Create a pseudo-element */
        position: absolute;
        left: 50%;
        bottom: 0; /* Position at the bottom */
        width: 0; /* Start with a width of 0 */
        height: 2px; /* Set the height of the underline */
        background: #f2f2f2; /* Set the color of the underline */
        transition: width 0.3s ease, left 0.3s ease; /* Add transition effects */
    }

    .nav-links li a:hover::after {
        width: 100%; /* Full width on hover */
        left: 0; /* Center the underline */
    }

    /* Active link */
    .nav-links li a.active::after {
        width: 100%; /* Keep the underline visible for the active link */
        left: 0; /* Center the underline */
    }

    .nav-links .mobile-item {
        display: none;
    }

    .wrapper .btn {
        color: #fff;
        font-size: 20px;
        cursor: pointer;
        display: none;
    }

    .wrapper .btn.close-btn {
        position: absolute;
        right: 30px;
        top: 10px;
    }

    .search-box__wrapper {
        display: flex;
        align-items: center;
        margin-right: 10px; /* Khoảng trống bên phải */
        margin-top: 10px; /* Điều chỉnh khoảng cách phía trên để hạ phần tìm kiếm xuống gần hơn với navbar */
    }

    .search-box {
        font-size: 14px;
        width: 160px;
        padding: 5px;
        border: none; /* Loại bỏ đường viền */
        outline: none; /* Loại bỏ viền khi được chọn */
        background: none; /* Loại bỏ màu nền */
        color:  #fff; /* Màu chữ */
        transition: border-bottom 0.3s; /* Thêm hiệu ứng chuyển tiếp */
    }

    .search-box:focus {
        border-bottom: 1px solid #fff; /* Thêm đường viền dưới khi được chọn */
    }

    .search-box__wrapper i{
        cursor: pointer;
        color:  #fff;
        margin-left: 5px; /* Thêm khoảng cách giữa ô tìm kiếm và biểu tượng */
    }

    /* Icon styling */
    .icon {
        display: flex;
        align-items: center;
    }

    .icon i {
        margin-left: 15px; /* Tăng khoảng cách từ biểu tượng người dùng */
        cursor: pointer;
        font-size: 20px;
        color: #fff;
    }

    /* Thêm khoảng cách cho biểu tượng giỏ hàng */
    .icon .fa-cart-shopping {
        margin-left: 20px; /* Khoảng cách giữa icon người dùng và giỏ hàng */
    }
    .user-menu {
        display: none; /* Ẩn menu mặc định */
        position: absolute; /* Vị trí tuyệt đối */
        background: #354B59; /* Màu nền của menu trùng với màu nền của nav */
        border-radius: 5px; /* Bo góc cho menu */
        padding: 10px; /* Khoảng cách bên trong */
        top: 60px; /* Điều chỉnh để hạ menu xuống dưới biểu tượng */
        right: 0; /* Căn phải menu */
        z-index: 100; /* Đảm bảo menu nằm trên các phần tử khác */
    }

    .user-menu a {
        display: block;
        color: white;
        text-decoration: none;
        margin: 5px 0;
    }

    /* Hiển thị menu khi biểu tượng người dùng được click */
    .icon:hover .user-menu {
        display: block; /* Hiển thị menu khi hover */
    }


    /* Media queries for responsiveness */
    @media screen and (max-width: 970px) {
        .wrapper .btn {
            display: block;
        }

        .wrapper .nav-links {
            position: fixed;
            height: 100vh;
            width: 100%;
            max-width: 350px;
            top: 0;
            left: -100%;
            background: #242526;
            display: block;
            padding: 50px 10px;
            line-height: 50px;
            overflow-y: auto;
            box-shadow: 0px 15px 15px rgba(0, 0, 0, 0.18);
            transition: all 0.3s ease;
        }

        /* Custom scroll bar */
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: #242526;
        }

        ::-webkit-scrollbar-thumb {
            background: #3A3B3C;
        }

        #menu-btn:checked ~ .nav-links {
            left: 0;
        }

        #menu-btn:checked ~ .btn.menu-btn {
            display: none;
        }

        #close-btn:checked ~ .btn.menu-btn {
            display: block;
        }

        .nav-links li {
            margin: 15px 10px;
        }

        .nav-links li a {
            padding: 0 20px;
            display: block;
            font-size: 20px;
        }

        .nav-links .desktop-item {
            display: none;
        }

        .nav-links .mobile-item {
            display: block;
            color: #f2f2f2;
            font-size: 20px;
            font-weight: 500;
            padding-left: 20px;
            cursor: pointer;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .nav-links .mobile-item:hover {
            background: #3A3B3C;
        }
    }

</style>
<nav>
    <div class="wrapper">
        <div class="logo"><a href="#">
                <img width="200" height="36" alt="Fanimation"
                     src="https://fanimation.com/wp-content/uploads/2021/04/Logo_white_1.png">
            </a></div>
        <div class="nav-container">
<!--            <input type="radio" name="slider" id="menu-btn">-->
<!--            <input type="radio" name="slider" id="close-btn">-->
            <ul class="nav-links">
                <label for="close-btn" class="btn close-btn"><i class="fas fa-times"></i></label>
                <li><a href="#" class="active">Home</a></li>
                <li><a href="#">Products</a></li>
                <li><a href="#">About Us</a></li>
                <li><a href="#">Explore</a></li>
                <li><a href="#">Help Center</a></li>
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
            <i class="fa-regular fa-user" id="user-icon"></i>
            <i class="fa-solid fa-cart-shopping" id="cart-icon"></i>
            <div class="user-menu" id="user-menu">
                <a href="login.html" id="login">Login</a>
                <a href="signup.html" id="signup">Sign Up</a>
                <a href="#" id="logout" style="display: none;">Logout</a>
            </div>
        </div>
    </div>
</nav>
<script>
    // Handle active link state in navigation
    document.querySelectorAll('.nav-links li a').forEach(link => {
        link.addEventListener('click', function() {
            document.querySelectorAll('.nav-links li a').forEach(a => a.classList.remove('active'));
            this.classList.add('active');
        });
    });

    // User login/logout functionality
    let isLoggedIn = false; // User login state

    const userIcon = document.getElementById('user-icon');
    const userMenu = document.getElementById('user-menu');
    const loginLink = document.getElementById('login');
    const signupLink = document.getElementById('signup');
    const logoutLink = document.getElementById('logout');
    const cartIcon = document.getElementById('cart-icon');

    userIcon.addEventListener('click', function() {
        // Toggle user menu visibility
        userMenu.style.display = userMenu.style.display === 'block' ? 'none' : 'block';
    });

    // Handle login functionality
    loginLink.addEventListener('click', function(event) {
        event.preventDefault();
        window.location.href = 'login.html'; // Redirect to login page
    });

    // Handle signup functionality
    signupLink.addEventListener('click', function(event) {
        event.preventDefault();
        window.location.href = 'signup.html'; // Redirect to signup page
    });

    // Handle logout functionality
    logoutLink.addEventListener('click', function(event) {
        event.preventDefault();
        // Simulate logout
        isLoggedIn = false;
        updateUserMenu();
    });

    // Handle cart icon click
    cartIcon.addEventListener('click', function() {
        window.location.href = 'checkout.html'; // Redirect to checkout page
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
        userMenu.style.display = 'none'; // Hide menu after clicking
    }

</script>
</body>
</html>
