
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Abril+Fatface&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="mainhome.css">
    <title>SlideShow</title>
</head>
<body>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600&display=swap');





    /* Styles chung cho toàn trang */
    html, body {
        max-width: 100vw; /* Không cho phép nội dung vượt quá kích thước khung nhìn */
        overflow-x: hidden; /* Ẩn thanh cuộn ngang */
    }

    * {
        box-sizing: border-box; /* Đảm bảo padding và border không làm tăng kích thước phần tử */
        margin: 0;
        padding: 0;
    }

    .slide-show {
        position: relative;
        width: 100%; /* Đặt chiều rộng cho slideshow */
        height: 500px; /* Đặt chiều cao cho slideshow */
        overflow: hidden; /* Ẩn các phần tử tràn */
    }

    .list-image {
        position: relative;
        width: 100%;
        height: 100%;
    }

    .list-image .slide {
        position: absolute; /* Đặt các slide chồng lên nhau */
        top: 0;
        left: 0;
        width: 100%;
        height: 100%; /* Đảm bảo slide chiếm toàn bộ chiều cao */
        opacity: 0; /* Ẩn các slide */
        transition: opacity 1s ease-in-out; /* Thêm hiệu ứng chuyển đổi opacity */
    }

    .list-image .slide.active {
        opacity: 1; /* Hiển thị slide hiện tại */
    }

    /* Đặt lớp text-overlay ở chính giữa */
    .text-overlay {
        position: absolute;
        top: 50%; /* Đặt ở giữa chiều cao */
        left: 50%; /* Đặt ở giữa chiều rộng */
        transform: translate(-50%, -50%); /* Di chuyển về chính giữa */
        color: white;
        text-align: center; /* Căn giữa văn bản */
        z-index: 2; /* Đảm bảo văn bản hiển thị trên hình ảnh */
    }

    .learn-more-btn {
        margin-top: 50px;
        padding: 15px 30px; /* Thêm padding cho nút */
        color: white; /* Màu chữ cho nút */
        border: 2px solid white;
        cursor: pointer; /* Hiển thị con trỏ khi di chuột qua */
        text-decoration: none;
        font-size: 18px;
    }

    body, p, h1, h2, a, button, .learn-more-btn {
        font-family: 'Open Sans', sans-serif;
    }

    .btn {
        cursor: pointer;
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        color: white;
        font-size: 24px;
        z-index: 10; /* Đảm bảo nút hiển thị trên các slide */
    }

    .btns-left {
        left: 10px;
    }

    .btns-right {
        right: 10px;
    }

    .index-image {
        position: absolute;
        bottom: 10px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
    }

    .index-item {
        width: 10px;
        height: 10px;
        margin: 0 5px;
        border-radius: 50%;
        background-color: gray;
        opacity: 0.5; /* Đặt độ mờ cho chỉ báo */
    }

    .index-item.active {
        opacity: 1; /* Độ mờ cho chỉ báo hiện tại */
    }

    .text-overlay h1 {
        font-size: 20px; /* Giảm cỡ chữ của h1 */
        font-weight: normal; /* Giữ định dạng chữ đậm */
        margin: 20px 0 60px 0;
    }

    .text-overlay h3 {
        font-size: 90px; /* Tăng cỡ chữ của h3 */
        font-weight: bold; /* Bạn có thể thay đổi kiểu chữ nếu muốn */
        margin: 5px 0; /* Khoảng cách giữa các phần tử */
        font-family: 'Abril Fatface', cursive;
        letter-spacing: 4px;
    }


    /* Phần wrap image và danh sách hình ảnh */
    .wrap-image {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .introduction p {
        font-size: 18px; /* Điều chỉnh kích thước chữ nếu cần */
        line-height: 1.5; /* Tăng khoảng cách giữa các dòng */
        margin: 60px 0 60px; /* Thêm khoảng cách trên và dưới cho đoạn văn */
        text-align: center; /* Căn giữa văn bản nếu cần */
    }

    .list {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .row-1, .row-2 {
        display: flex;
        justify-content: center;
        width: 100%;
        max-width: 800px;
    }

    .row-1 > div, .row-2 > div {
        flex: 1;
        margin: 0 5px;
        position: relative;
    }

    .img-container {
        position: relative;
        width: 400px;
        height: 300px;
        margin: 5px;
        overflow: hidden;
        transition: transform 0.3s ease-in-out;
    }

    .img-container:hover {
        transform: scale(1.05); /* Khi hover, hình ảnh sẽ phóng to nhẹ */
    }


    .img-container a {
        display: block;
        width: 100%;
        height: 100%;
        color: inherit;
    }

    .wrap-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        background: linear-gradient(160deg, #ffffff 0%, #cabaad 100%);
        padding: 5px;
    }

    .img-container p {
        position: absolute;
        bottom: 10px;
        left: 10px;
        margin: 0;
        color: white;
        font-size: 18px;
        font-weight: bold;
        padding: 5px 10px;
        opacity: 0;
        transition: opacity 0.3s ease-in-out;
    }

    .img-container:hover p {
        opacity: 1; /* Hiển thị nút khi hover */
    }

    .row-2 {
        margin-top: 10px;
    }
    .row-2 > div {
        margin: 0 2px;
    }

    /* Phần why */
    .why {
        position: relative; /* Để sử dụng absolute cho h2 */
        text-align: center; /* Căn giữa văn bản */
        margin-top: 20px; /* Thêm khoảng cách trên cho phần why */
    }

    .why img {
        width: 100vw; /* Đặt chiều rộng của ảnh bằng 100% */
        height: auto; /* Đảm bảo chiều cao tự động theo tỷ lệ của ảnh */
        max-width: 100%; /* Giới hạn chiều rộng tối đa bằng với container */
        overflow: hidden;
    }

    .why h2 {
        position: absolute; /* Đặt h2 ở vị trí tuyệt đối */
        top: 25%; /* Đặt h2 ở giữa ảnh theo chiều dọc */
        left: 50%; /* Đặt h2 ở giữa ảnh theo chiều ngang */
        transform: translate(-50%, -50%); /* Căn giữa hoàn toàn */
        color: white; /* Màu chữ */
        z-index: 1; /* Đảm bảo h2 nằm trên cùng */
        font-size: 70px; /* Giữ kích thước font chữ ở 70px */
        font-weight: bold; /* Làm chữ đậm */
        white-space: nowrap; /* Ngăn không cho chữ xuống dòng */
        overflow: hidden; /* Ẩn các chữ không hiển thị nếu quá dài */
    }

    .why p {
        position: absolute; /* Đặt p ở vị trí tuyệt đối */
        bottom: 435px; /* Đặt cách đáy hình ảnh một khoảng nhất định */
        left: 62%; /* Đặt p ở giữa theo chiều ngang */
        transform: translateX(-50%); /* Căn giữa hoàn toàn */
        color: rgb(0, 0, 0); /* Màu chữ */
        z-index: 1; /* Đảm bảo p nằm trên cùng */
        font-size: 20px; /* Kích thước chữ */
        text-align: center; /* Căn giữa văn bản */
        margin: 0; /* Bỏ bỏ margin để căn giữa chính xác */
        font-style: italic; /* Đặt chữ nghiêng */
    }


    /*klkl*/


</style>
<div class="slide-show">
    <div class="list-image">
        <div class="slide active"> <!-- Thêm lớp active cho slide đầu tiên -->
            <img src="../../images/3.jpg" width="100%" alt="">
            <div class="text-overlay">
                <h3>New for 2024</h3>
                <h1>A collection with a Fan for Every space</h1>
                <a href="#" class="learn-more-btn">Learn More</a>
            </div>
        </div>
        <div class="slide">
            <img src="../../images/7.jpg" width="100%" alt="">
            <div class="text-overlay">
                <h3>TriAire</h3>
                <h1>Two of your favourite finishes now available in Marine Grade</h1>
                <a href="#" class="learn-more-btn">Learn More</a>
            </div>
        </div>
        <div class="slide">
            <img src="../../images/22.jpg" width="100%" alt="">
            <div class="text-overlay">
                <h3>Wrap</h3>
                <h1>Brush satin brass + Matte white</h1>
                <a href="#" class="learn-more-btn">Learn More</a>
            </div>
        </div>
        <div class="slide">
            <img src="../../images/23.jpg" width="100%" alt="">
            <div class="text-overlay">
                <h3>Neutral & Now</h3>
                <h1>Featuring the new Antique Graphite finish with new Light Oak finish Blades</h1>
                <a href="#" class="learn-more-btn">Learn More</a>
            </div>
        </div>
    </div>
    <div class="btns-left btn">❮</div>
    <div class="btns-right btn">❯</div>
    <div class="index-image">
        <div class="index-item index-item-0 active"></div>
        <div class="index-item index-item-1"></div>
        <div class="index-item index-item-2"></div>
        <div class="index-item index-item-3"></div>
    </div>
    <script src="mainhome.js"></script>
</div>
</div>
<div class="wrap-image">
    <div class="introduction">
        <p>Fanimation fans are the perfect fusion of beauty and functionality. With designs for every
            </br>style and technology-driven controls for your convenience, Fanimation fans inspire your home. </br>
            They integrate into any space and allow you to make a statement that is all your own.
        </p>
    </div>
    <div class="list">
        <div class="row-1">
            <div class="ceilingfan">
                <div class="img-container">
                    <a href="#"> <!-- Thêm thẻ a để link -->
                        <img src="../../images/Remove-bg.ai_1728388796796.png" alt="">
                        <p>Ceiling Fans</p>
                    </a>
                </div>
            </div>
            <div class="pedestialfan">
                <div class="img-container">
                    <a href="#">
                        <img src="../../images/gg.png" alt="">
                        <p>Pedestal Fans</p>
                    </a>
                </div>
            </div>
            <div class="wallfan">
                <div class="img-container">
                    <a href="#">
                        <img src="../../images/gg4ez.png" alt="">
                        <p>Wall Fans</p>
                    </a>
                </div>
            </div>
        </div>
        <div class="row-2">
            <div class="exhaustfan">
                <div class="img-container">
                    <a href="#">
                        <img src="../../images/Remove-bg.ai_1728333774158.png" alt="">
                        <p>Exhaust Fans</p>
                    </a>
                </div>
            </div>
            <div class="accessories">
                <div class="img-container">
                    <a href="#">
                        <img src="../../images/Remove-bg.ai_1728332740308.png" alt="">
                        <p>Accessories</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="why">
    <img src="../../images/gg3ez.jpg" alt="">
    <h2>The Art of Choosing a Fan</h2>
    <p>"Where will your fan go,and what features the fan most?"</p>
</div>
<!-- best seller  -->
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const slides = document.querySelectorAll('.list-image .slide'); // Chọn tất cả các slide
        const btnRight = document.querySelector('.btns-right');
        const btnLeft = document.querySelector('.btns-left');
        const indicators = document.querySelectorAll('.index-item');
        let current = 0;

        // Hàm thay đổi slide
        const handleChangeSlide = (next = true) => {
            // Ẩn slide hiện tại
            slides[current].classList.remove('active');
            indicators[current].classList.remove('active');

            // Chuyển slide
            if (next) {
                current = (current === slides.length - 1) ? 0 : current + 1; // Chuyển sang slide tiếp theo
            } else {
                current = (current === 0) ? slides.length - 1 : current - 1; // Quay về slide trước
            }

            // Hiển thị slide mới
            slides[current].classList.add('active');
            indicators[current].classList.add('active');
        };

        // Thiết lập auto chuyển slide sau 4 giây
        let interval = setInterval(() => handleChangeSlide(true), 4000);

        // Nút bấm bên phải
        btnRight.addEventListener('click', () => {
            clearInterval(interval); // Dừng auto chuyển slide
            handleChangeSlide(true); // Chuyển tới slide tiếp theo
            interval = setInterval(() => handleChangeSlide(true), 4000); // Khởi động lại auto chuyển slide
        });

        // Nút bấm bên trái
        btnLeft.addEventListener('click', () => {
            clearInterval(interval); // Dừng auto chuyển slide
            handleChangeSlide(false); // Quay về slide trước
            interval = setInterval(() => handleChangeSlide(true), 4000); // Khởi động lại auto chuyển slide
        });
    });

</script>

</body>
</html>
