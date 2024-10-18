<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký</title>
</head>
<body>
<h2>Đăng ký tài khoản</h2>
<form action="signup_process.php" method="POST">
    <label for="username">Tên đăng nhập:</label>
    <input type="text" id="username" name="username" required><br><br>

    <label for="password">Mật khẩu:</label>
    <input type="password" id="password" name="password" required><br><br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required><br><br>

    <label for="phone">Số điện thoại:</label>
    <input type="text" id="phone" name="phone" required><br><br>

    <label for="address">Địa chỉ:</label>
    <input type="text" id="address" name="address" required><br><br>

    <button type="submit">Đăng ký</button>
</form>
</body>
</html>
