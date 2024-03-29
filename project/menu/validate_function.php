<?php
function validateEmailForm($firstname, $lastname, $email, $phonenumber, $address, $message){
    $errorMessage = array();

    if (empty($firstname)) {
        $errorMessage[] = "First name field is empty.";
    }else if (!ctype_alpha($firstname)) {
        $errorMessage[] = "First name can only be letters and no spaces allowed.";
    }else if (strlen($firstname) > 30) {
        $errorMessage[] = "First name cannot be more than 30 characters.";
    }
    if (empty($lastname)) {
        $errorMessage[] = "Lastname field is empty.";
    }else if (!ctype_alpha($lastname)) {
        $errorMessage[] = "Last name can only be letters and no spaces allowed.";
    }else if (strlen($lastname) > 30) {
        $errorMessage[] = "Last name cannot be more than 30 characters.";
    }
    if(empty($email)) {
        $errorMessage[] = "Email field is empty.";
    }else {
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errorMessage[] = "Invalid email format.";
        }
    }
    if (empty($phonenumber)) {
        $errorMessage[] = "Phone number field is empty.";
    }else if (!preg_match('/^0(?:\d-?){8,9}\d$/', $phonenumber)) {
        $errorMessage[] = "Phone number is not in the correct Malaysia format.";
    }
    if(empty($address)) {
        $errorMessage[] = "Address field is empty.";
    }else if (strlen($address) > 150) {
        $errorMessage[] = "Address cannot exceed 150 characters.";
    }
    if (empty($message)) {
        $errorMessage[] = "Message field is empty.";
    }else if (strlen($message) > 150) {
        $errorMessage[] = "Message cannot exceed 150 characters.";
    }

    return $errorMessage;
}

function validateProductForm($name, $checkCount, $description, $price, $promotion_price, $manufacture_date, $expired_date, $category_id, $image) {
    $errorMessage = array();
    $target_directory = "uploaded_product_img/";

    if(empty($name)) {
        $errorMessage[] = "Product name field is empty.";
    }else if (strlen($name) > 50) {
        $errorMessage[] = "Product name cannot exceed 50 characters.";
    }
    if ($checkCount > 0) {
        $errorMessage[] = "The product name already exists.";
    }
    if (empty($description)) {
        $errorMessage[] = "Description field is empty.";
    }else if (strlen($description) > 200) {
        $errorMessage[] = "Description cannot exceed 200 characters.";
    }
    if(empty($price)) {
        $errorMessage[] = "Price field is empty.";
    }else if($price <= 0) {
        $errorMessage[] = "Please enter a valid price.";
    }else {
        if (!is_numeric($price)) {
            $errorMessage[] = "Prices can only be numbers.";
        }
    }
    if(empty($manufacture_date)) {
        $errorMessage[] = "Manufacture date field is empty.";
    }else {
        $currentDate = date('Y-m-d');
        if($manufacture_date > $currentDate) {
            $errorMessage[] = "Manufacture date cannot be in future.";
        }
    }

    if (!empty($expired_date)) {
        if ($expired_date <= $manufacture_date) {
            $errorMessage[] = "Expired date must be later than the manufacture date.";
        }
    }
    if($promotion_price >= $price) {
        $errorMessage[] = "Promotion price must be cheaper than the original price.";
    }
    if(empty($category_id)) {
        $errorMessage[] = "No product category found.";
    }

    $errors = validateImage($image, $target_directory, $errorMessage);
    $errorMessage = $errors;

    return $errorMessage;
}

function validateCategoryForm($category_name, $description, $checkCount) {
    $errorMessage = array();

    if(empty($category_name)) {
        $errorMessage[] = "Category name field is empty.";
    }else if (strlen($category_name) > 50) {
        $errorMessage[] = "Category name cannot exceed 50 characters.";
    }
    if ($checkCount > 0) {
        $errorMessage[] = "The product category name already exists.";
    }
    if(empty($description)) {
        $errorMessage[] = "Description field is empty.";
    }else if (strlen($description) > 200) {
        $errorMessage[] = "Description cannot exceed 200 characters.";
    }

    return $errorMessage;
}
function validateCreateCustomerForm($username, $usernameCount, $password, $confirmpassword, $firstname, $lastname, $gender, $birthdate, $email, $emailCount, $status, $image){
    $errorMessage = array();
    $passwordPattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{6,}$/";
    $target_directory = "uploaded_customer_img/";

    if (empty($username)) {
        $errorMessage[] = "Username field is empty.";
    } else if (!preg_match('/^[a-zA-Z0-9_]{5,20}$/', $username)) {
        $errorMessage[] = "Username can only contain letters, numbers, and underscores, and must be between 5 and 20 characters.";
    }
    
    if ($usernameCount > 0) {
        $errorMessage[] = "Username already taken. Please choose a different username.";
    }

    if(empty($password)) {
        $errorMessage[] = "Password field is empty.";
    }else {
        if (!preg_match($passwordPattern, $password)) {
            $errorMessage[] = "Password must be at least 6 characters long and contain at least one uppercase letter, one lowercase letter, and one number. No special symbols allowed.";
        }
    }
    if (empty($confirmpassword)) {
        $errorMessage[] = "Confirm password field is empty.";
    }
    if (!empty($password) && !empty($confirmpassword)) {
        if ($password !== $confirmpassword) {
            $errorMessage[] = "Password and confirm password do not match.";
        }
    }
    if(empty($firstname)) {
        $errorMessage[] = "First name field is empty.";
    }else if (!ctype_alpha($firstname)) {
        $errorMessage[] = "First name can only be letters and no spaces allowed.";
    }else if (strlen($firstname) > 30) {
        $errorMessage[] = "First name cannot be more than 30 characters.";
    }
    if(empty($lastname)) {
        $errorMessage[] = "Last name field is empty.";
    }else if (!ctype_alpha($lastname)) {
        $errorMessage[] = "Last name can only be letters and no spaces allowed.";
    }else if (strlen($lastname) > 30) {
        $errorMessage[] = "Last name cannot be more than 30 characters.";
    }
    if(empty($gender)) {
        $errorMessage[] = "Gender field is empty.";
    }
    if(empty($birthdate)) {
        $errorMessage[] = "Date of birth field is empty.";
    }else {
        $currentDate = date('Y-m-d');
        if($birthdate > $currentDate) {
            $errorMessage[] = "Date of birth cannot be in the future.";
        }
    }
    if(empty($email)) {
        $errorMessage[] = "Email field is empty.";
    }else{
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errorMessage[] = "Invalid email format.";
        }
    }
    if ($emailCount > 0) {
        $errorMessage[] = "Email already taken. Please choose a different email.";
    }
    if(empty($status)) {
        $errorMessage[] = "Account status field is empty.";
    }

    $errors = validateImage($image, $target_directory, $errorMessage);
    $errorMessage = $errors;

    return $errorMessage;
}

function validateUpdateCustomerForm($username, $firstname, $lastname, $gender, $birthdate, $email, $emailCount, $status, $db_password, $current_password, $new_password, $confirm_new_password, $image){
    $errorMessage = array();
    $passwordPattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{6,}$/";
    $target_directory = "uploaded_customer_img/";

    if (empty($username)) {
        $errorMessage[] = "Username field is empty.";
    } else if (strlen($username) < 5 || strlen($username) > 20) {
        $errorMessage[] = "Username must be between 5 and 20 characters.";
    }

    if(empty($firstname)) {
        $errorMessage[] = "First name field is empty.";
    }else if (!ctype_alpha($firstname)) {
        $errorMessage[] = "First name can only be letters and no spaces allowed.";
    }else if (strlen($firstname) > 30) {
        $errorMessage[] = "First name cannot be more than 30 characters.";
    }
    if(empty($lastname)) {
        $errorMessage[] = "Last name field is empty.";
    }else if (!ctype_alpha($lastname)) {
        $errorMessage[] = "Last name can only be letters and no spaces allowed.";
    }else if (strlen($lastname) > 30) {
        $errorMessage[] = "Last name cannot be more than 30 characters.";
    }
    if(empty($gender)) {
        $errorMessage[] = "Gender field is empty.";
    }
    if(empty($birthdate)) {
        $errorMessage[] = "Date of birth field is empty.";
    }else {
        $currentDate = date('Y-m-d');
        if($birthdate > $currentDate) {
            $errorMessage[] = "Date of birth cannot be in the future.";
        }
    }
    if(empty($email)) {
        $errorMessage[] = "Email field is empty.";
    }else{
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errorMessage[] = "Invalid email format.";
        }
    }
    if ($emailCount > 0) {
        $errorMessage[] = "Email already taken. Please choose a different email.";
    }
    if(empty($status)) {
        $errorMessage[] = "Account status field is empty.";
    }

    if (empty($current_password) && empty($new_password) && empty($confirm_new_password)) {
        $errors = validateImage($image, $target_directory, $errorMessage);
        $errorMessage = $errors;

        return $errorMessage;
    }
    if (empty($current_password) || empty($new_password) || empty($confirm_new_password)) {
        $errorMessage[] = "If you wish to change your password, please fill in all three password fields.";
        $errors = validateImage($image, $target_directory, $errorMessage);
        $errorMessage = $errors;

        return $errorMessage;
    }else {
        if (!preg_match($passwordPattern, $new_password)) {
            $errorMessage[] = "Password must be at least 6 characters long and contain at least one uppercase letter, one lowercase letter, and one number. No special symbols allowed.";
        }
        if ($new_password !== $confirm_new_password) {
            $errorMessage[] = "New password and confirm password do not match.";
        }
        if (!password_verify($current_password, $db_password)) {
            $errorMessage[] = "Incorrect current password.";
        }
        $errors = validateImage($image, $target_directory, $errorMessage);
        $errorMessage = $errors;
        
        return $errorMessage;
    }
}

// accept $selectedProductRow, $selectedProductID, $selectedProductQuantity as references instead values
function validateOrderForm(&$selectedProductRow, $selectedCustomerID, &$selectedProductID, &$selectedProductQuantity, $organizedProducts){
    $errorMessage = array();
    $selectedProductRowWithoutDuplicate = array_filter(array_unique($selectedProductID));
    $countedProduct = array_count_values($selectedProductID);
    $countedEmptyProductFields = isset($countedProduct) && array_key_exists('', $countedProduct) ? $countedProduct[''] : 0;

    if(empty($selectedCustomerID)) {
        $errorMessage[] = "Please select the customer name.";
    }

    if (sizeof($selectedProductRowWithoutDuplicate) != sizeof($selectedProductID)){
        foreach ($selectedProductID as $key => $val){
            if(!array_key_exists($key, $selectedProductRowWithoutDuplicate)){
                // this condition is set to block unselected products (Exp two empty product fields)
                if($val != ''){ 
                    $errorMessage[] = "Duplicate product was chosen - " . $organizedProducts[$val]['name'] . ".";
                    unset($selectedProductID[$key]);
                    unset($selectedProductQuantity[$key]);
                    $selectedProductRow = isset($selectedProductRowWithoutDuplicate) ? count($selectedProductRowWithoutDuplicate) + $countedEmptyProductFields : count($_POST['product']);
                }
            }
        }
        $selectedProductID = array_values($selectedProductID);
        $selectedProductQuantity = array_values($selectedProductQuantity);
    }

    for ($i = 0; $i < $selectedProductRow; $i++) {
        if (empty($selectedProductID[$i])) {
            $errorMessage[] = "Please select the product for No. " . ($i + 1) . ".";
        }
        if (empty($selectedProductQuantity[$i]) || !is_numeric($selectedProductQuantity[$i])) {
            $errorMessage[] = "Please enter a number between 1-10 for purchase quantity of product No. " . ($i + 1) . ".";
        } else {
            if ($selectedProductQuantity[$i] < 1 || $selectedProductQuantity[$i] > 10) {
                $errorMessage[] = "The purchase quantity of product " . ($i + 1) . " cannot be less than 1 or more than 10.";
            }
        }
    }

    return $errorMessage;
}

function validateImage($image, $target_directory, $errorMessage) {
    
    if (!empty($_FILES["image"]["name"])) {
        if ($image) {
            // upload file to folder
            $file_type = pathinfo($image, PATHINFO_EXTENSION);
    
            $check = getimagesize($_FILES["image"]["tmp_name"]);
            if ($check !== false) {
                $allowed_file_types = array("jpg", "jpeg", "png", "gif");
                if (!in_array($file_type, $allowed_file_types)) {
                    $errorMessage[] = "Only JPG, JPEG, PNG, GIF files are allowed.";
                }
                if (file_exists($image)) {
                    $errorMessage[] = "Image already exists. Try to change the file name.";
                }
                if ($_FILES['image']['size'] > (512 * 1024)) {
                    $errorMessage[] = "Image must be less than 512 KB in size.";
                }
                list($width, $height) = getimagesize($_FILES["image"]["tmp_name"]);
                if ($width !== $height) {
                    $errorMessage[] = "Image must be square in dimensions.";
                }
                if (!is_dir($target_directory)) {
                    mkdir($target_directory, 0777, true);
                }

            } else {
                $errorMessage[] = "Submitted file is not an image.";
            }

            if (empty($errorMessage)) {
                // Upload the file only when there are no error messages
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $image)) {
                    // File uploaded successfully
                } else {
                    $errorMessage[] = "Unable to upload the photo. Update the record to upload the photo.";
                }
            }
        }
    }

    return $errorMessage;
}
?>






