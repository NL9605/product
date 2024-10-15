<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
ob_start();
include "../configs/database.php";
include_once '../models/CategoryModel.php';
include_once '../models/ProductModel.php';
include_once '../models/DiscountModel.php';
include_once '../models/SizeModel.php';
include_once '../models/ColorModel.php';


include "view/layout/header.php";
$conn = database();

if (isset($_GET['act'])) {
    switch ($_GET['act']) {
        case 'product':
            // Khởi tạo model sản phẩm
            $productModel = new ProductModel($conn);

            $products = $productModel->getAllProducts();
            // Gọi view hiển thị danh sách sản phẩm
            include "view/product/product.php";
            break;

        case 'createproduct':
            // Khởi tạo model sản phẩm
            $productModel = new ProductModel($conn);

            // Lấy danh sách danh mục
            $categoryModel = new CategoryModel($conn);
            $categories = $categoryModel->getAllCategories();

            // Lấy danh sách kích thước
            $sizeModel = new SizeModel($conn);
            $sizes = $sizeModel->getAllSizes();

            // Lấy danh sách khuyến mãi
            $discountModel = new DiscountModel($conn);
            $discounts = $discountModel->getAllDiscounts();

            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create'])) {
                $product_name = $_POST['product_name'];
                $product_description = $_POST['description'];
                $product_price = $_POST['price'];
                $category_id = $_POST['category_id'];
                $size_id = $_POST['size_id'];
                $discount_id = $_POST['discount_id'] ?? null; // Nếu không có discount_id thì gán là null


                $image_urls = ''; // Bắt đầu với hình ảnh trống
                if (isset($_FILES['image_files']) && is_array($_FILES['image_files']['name'])) {
                    $uploaded_images = [];
                    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
                    $max_file_size = 2 * 1024 * 1024; // 2MB

                    foreach ($_FILES['image_files']['name'] as $key => $filename) {
                        // Kiểm tra lỗi upload
                        if ($_FILES['image_files']['error'][$key] !== UPLOAD_ERR_OK) {
                            error_log('Lỗi tải lên file: ' . $_FILES['image_files']['error'][$key]);
                            continue; // Bỏ qua file nếu có lỗi
                        }

                        // Kiểm tra loại tệp
                        $file_type = mime_content_type($_FILES['image_files']['tmp_name'][$key]);
                        if (!in_array($file_type, $allowed_types)) {
                            error_log('Loại tệp không hợp lệ: ' . $filename);
                            continue; // Bỏ qua file không hợp lệ
                        }

                        // Kiểm tra kích thước tệp
                        if ($_FILES['image_files']['size'][$key] > $max_file_size) {
                            error_log('Tệp quá lớn: ' . $filename);
                            continue; // Bỏ qua file quá lớn
                        }

                        // Đảm bảo thư mục uploads tồn tại
                        $target_dir = __DIR__ . '/uploads/';
                        if (!is_dir($target_dir)) {
                            mkdir($target_dir, 0755, true);
                        }

                        // Tạo tên tệp duy nhất để tránh trùng lặp
                        $unique_name = uniqid() . '_' . basename($filename);
                        $target_file = $target_dir . $unique_name;

                        if (move_uploaded_file($_FILES['image_files']['tmp_name'][$key], $target_file)) {
                            // Lưu đường dẫn tương đối để dễ dàng truy cập
                            $uploaded_images[] = 'uploads/' . $unique_name;
                        } else {
                            error_log('Không thể tải lên hình ảnh: ' . $filename);
                        }
                    }

                    // Nếu có hình ảnh mới được tải lên, thêm chúng vào danh sách hình ảnh hiện tại
                    if (!empty($uploaded_images)) {
                        $image_urls = implode(',', $uploaded_images); // Lưu trữ URL hình ảnh
                    }
                }

                // Tạo sản phẩm mới
                $productModel->createProduct($product_name, $product_description, $product_price, $category_id, $size_id, $discount_id, $image_urls);

                // Chuyển hướng về trang danh sách sản phẩm
                header("Location: index.php?act=product");
                exit;
            }

            // Gọi view để hiển thị form tạo sản phẩm
            include 'view/product/create_product.php';
            break;



        case 'editproduct':
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $productModel = new ProductModel($conn);
                $product = $productModel->getProductById($id);

                // Kiểm tra xem sản phẩm có tồn tại hay không
                if (!$product) {
                    echo "<p>Không tìm thấy sản phẩm với ID: " . htmlspecialchars($id) . "</p>";
                    break; // Thoát khỏi case nếu sản phẩm không tồn tại
                }

                // Lấy danh sách danh mục, kích thước, khuyến mãi
                $categoryModel = new CategoryModel($conn);
                $sizeModel = new SizeModel($conn);
                $discountModel = new DiscountModel($conn);
                $categories = $categoryModel->getAllCategories();
                $sizes = $sizeModel->getAllSizes();
                $discounts = $discountModel->getAllDiscounts();

                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
                    $product_name = $_POST['product_name'];
                    $product_description = $_POST['description'];
                    $product_price = $_POST['price'];
                    $category_id = $_POST['category_id'];
                    $size_id = $_POST['size_id'];

                    // Kiểm tra discount_id
                    $discount_id = !empty($_POST['discount_id']) ? $_POST['discount_id'] : null; // Nếu rỗng, gán là NULL

                    // Xử lý file tải lên
                    $image_urls = $product['image_urls']; // Bắt đầu với hình ảnh hiện tại
                    if (isset($_FILES['images']) && is_array($_FILES['images']['name'])) { // Sửa tên trường
                        $uploaded_images = [];
                        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
                        $max_file_size = 2 * 1024 * 1024; // 2MB

                        foreach ($_FILES['images']['name'] as $key => $filename) {
                            // Kiểm tra lỗi upload
                            if ($_FILES['images']['error'][$key] !== UPLOAD_ERR_OK) {
                                continue; // Bỏ qua file nếu có lỗi
                            }

                            // Kiểm tra loại tệp
                            $file_type = mime_content_type($_FILES['images']['tmp_name'][$key]);
                            if (!in_array($file_type, $allowed_types)) {
                                continue; // Bỏ qua file không hợp lệ
                            }

                            // Kiểm tra kích thước tệp
                            if ($_FILES['images']['size'][$key] > $max_file_size) {
                                continue; // Bỏ qua file quá lớn
                            }

                            // Đảm bảo thư mục uploads tồn tại
                            $target_dir = __DIR__ . '/uploads/';
                            if (!is_dir($target_dir)) {
                                mkdir($target_dir, 0755, true);
                            }

                            // Tạo tên tệp duy nhất để tránh trùng lặp
                            $unique_name = uniqid() . '_' . basename($filename);
                            $target_file = $target_dir . $unique_name;

                            if (move_uploaded_file($_FILES['images']['tmp_name'][$key], $target_file)) {
                                // Lưu đường dẫn tương đối để dễ dàng truy cập
                                $uploaded_images[] = 'uploads/' . $unique_name; // Chỉnh sửa đường dẫn
                            }
                        }

                        // Nếu có hình ảnh mới được tải lên, thêm chúng vào danh sách hình ảnh hiện tại
                        if (!empty($uploaded_images)) {
                            $existing_images = !empty($image_urls) ? explode(',', $image_urls) : [];
                            $all_images = array_merge($existing_images, $uploaded_images);
                            $image_urls = implode(',', $all_images);
                        }
                    }

                    // Cập nhật sản phẩm
                    $productModel->editProduct($id, $product_name, $product_description, $product_price, $category_id, $size_id, $discount_id, $image_urls);

                    // Chuyển hướng về trang danh sách sản phẩm
                    header("Location: index.php?act=product");
                    exit;
                }

                include "view/product/editproduct.php";
            }
            break;


        case 'deleteproduct':
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $productModel = new ProductModel($conn);
                $productModel->deleteProduct($id); // Xóa sản phẩm
                header("Location: index.php?act=product");
                exit;
            }
            break;

        case 'color':
            // Khởi tạo model màu sắc
            $colorModel = new ColorModel($conn);
            // Lấy tất cả màu sắc
            $colors = $colorModel->getAllColors();
            include 'view/color/color.php';
            break;

        case 'createcolor':
            // Khởi tạo model màu sắc
            $colorModel = new ColorModel($conn);
            // Thêm màu sắc mới
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $colorName = $_POST['color_name'] ?? '';
                if ($colorModel->createColor($colorName)) {
                    header("Location: index.php?act=color");
                    exit;
                } else {
                    echo "Error creating color.";
                }
            }
            include 'view/color/createcolor.php';
            break;

        case 'editcolor':
            // Khởi tạo model màu sắc
            $colorModel = new ColorModel($conn);
            // Sửa màu sắc
            $colorId = $_GET['id'] ?? '';
            $color = $colorModel->getColorById($colorId);
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $colorName = $_POST['color_name'] ?? '';
                if ($colorModel->updateColor($colorId, $colorName)) {
                    header("Location: index.php?act=color");
                    exit;
                } else {
                    echo "Error updating color.";
                }
            }
            include 'view/color/editcolor.php';
            break;

        case 'deletecolor':
            // Khởi tạo model màu sắc
            $colorModel = new ColorModel($conn);
            // Xóa màu sắc
            $colorId = $_GET['id'] ?? '';
            if ($colorModel->deleteColor($colorId)) {
                header("Location: index.php?act=color");
                exit;
            } else {
                echo "Error deleting color.";
            }
            break;



        case 'category':
                $categoryModel = new CategoryModel($conn);
                $kq = $categoryModel->getAllCategories();
                include "view/product/category.php";
                break;
            case 'createcategory':
                if (isset($_POST['create']) && !empty($_POST['category_name'])) {
                    $name = $_POST['category_name'];
                    $categoryModel = new CategoryModel($conn);
                    $categoryModel->createCategory($name);

                    // Sau khi tạo danh mục thành công, bạn có thể chuyển hướng về danh sách hoặc hiển thị thông báo
                    header('Location: index.php?act=category'); // Chuyển hướng về danh sách danh mục
                    exit();
                }
                // Nếu không có dữ liệu POST, lấy danh sách danh mục để hiển thị
                $categoryModel = new CategoryModel($conn);
                $kq = $categoryModel->getAllCategories();
                include "view/product/category.php";
                break;

            case 'deletecategory':
                if(isset($_GET['id'])){
                    $id = $_GET['id'];
                    $categoryModel = new CategoryModel($conn);
                    $categoryModel->delcategory($id);
                }
                $categoryModel = new CategoryModel($conn);
                $kq = $categoryModel->getAllCategories();
                include "view/product/category.php";
                break;
            case 'editcategory':
                if(isset($_GET['id'])){
                    $id = $_GET['id'];
                    $categoryModel = new CategoryModel($conn);
                    $kq1=$categoryModel->getcategory($id);
                }else {
                    header('Location: index.php?act=category');
                    exit();
                }
                if(isset($_POST['id']) && isset($_POST['category_name'])) {
                    $id = $_POST['id'];
                    $name = $_POST['category_name'];  // Lấy tên danh mục mới từ form
                    $categoryModel = new CategoryModel($conn);
                    $categoryModel->updatecategory($id, $name);
                    $categoryModel = new CategoryModel($conn);
                }
                $kq = $categoryModel->getAllCategories();
                include "view/product/editcategory.php";
                break;
            case 'discount':
                $discountModel = new DiscountModel($conn);
                $discounts = $discountModel->getAllDiscounts(); // Lấy tất cả mã giảm giá
                include "view/discount/discount.php"; // Hiển thị danh sách mã giảm giá
                break;

            case 'creatediscount':
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create'])) {
                    $discount_code = $_POST['discount_code'];
                    $discount_percentage = $_POST['discount_percentage'];
                    $start_date = $_POST['start_date'];
                    $end_date = $_POST['end_date'];

                    $discountModel = new DiscountModel($conn);
                    $discountModel->createDiscount($discount_code, $discount_percentage, $start_date, $end_date);

                    header("Location: index.php?act=discount");
                    exit;
                }
                include "view/discount/creatediscount.php";
                break;

            case 'deletediscount':
                if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                    $discountModel = new DiscountModel($conn);
                    $discountModel->deleteDiscount($id);
                    header("Location: index.php?act=discount");
                    exit;
                }
                break;

            case 'editdiscount':
                if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                    $discountModel = new DiscountModel($conn);
                    $currentDiscount = $discountModel->getDiscountById($id);

                    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
                        $code = $_POST['discount_code'];
                        $percentage = $_POST['discount_percentage'];
                        $startdate = $_POST['start_date'];
                        $enddate = $_POST['end_date'];

                        // Cập nhật thông tin mã giảm giá
                        $discountModel->editDiscount($id, $code, $percentage, $startdate, $enddate);

                        header("Location: index.php?act=discount");
                        exit;
                    }
                } else {

                    header("Location: index.php?act=discount");
                    exit;
                }

                // Hiển thị form chỉnh sửa mã giảm giá
                include "view/discount/editdiscount.php";
                break;

            // Controller cho các hành động liên quan đến Size
            case 'size':
                $sizeModel = new SizeModel($conn);
                $kq = $sizeModel->getAllSizes(); // Lấy danh sách tất cả kích thước
                include "view/size/size.php"; // Hiển thị danh sách kích thước
                break;

            case 'createsize':
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create'])) {
                    $size_name = $_POST['size_name'];
                    $sizeModel = new SizeModel($conn);
                    $sizeModel->createSize($size_name);

                    header("Location: index.php?act=size");
                    exit;
                }
                include "view/size/createsize.php";
                break;

            case 'editsize':
                if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                    $sizeModel = new SizeModel($conn);
                    $currentSize = $sizeModel->getSizeById($id); // Lấy thông tin kích thước hiện tại

                    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
                        $size_name = $_POST['size_name'];
                        $sizeModel->editSize($id, $size_name); // Cập nhật thông tin kích thước

                        header("Location: index.php?act=size");
                        exit;
                    }
                }
                include "view/size/editsize.php"; // Hiển thị form chỉnh sửa kích thước
                break;

            case 'deletesize':
                if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                    $sizeModel = new SizeModel($conn);
                    $sizeModel->deleteSize($id); // Xóa kích thước

                    header("Location: index.php?act=size");
                    exit;
                }
                break;


            case 'order':
                include "view/order/order.php";
                break;

            default:
                include "view/layout/home.php";
                break;
        }
    }else{
            include "view/layout/home.php";
    }



    include "view/layout/footer.php";

ob_end_flush();
?>
