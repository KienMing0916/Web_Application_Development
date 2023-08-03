<?php
function validateProductForm($name, $description, $price, $promotion_price, $manufacture_date, $expired_date, $category_id) {
    $errorMessage = array();

    if(empty($name)) {
        $errorMessage[] = "Name field is empty.";
    }
    if(empty($description)) {
        $errorMessage[] = "Description field is empty.";
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
    if(empty($promotion_price)) {
        $errorMessage[] = "Promotion price field is empty.";
    }else if($promotion_price <= 0) {
        $errorMessage[] = "Please enter a valid promotion price.";
    }else {
        if(!is_numeric($promotion_price)) {
            $errorMessage[] = "Promotion prices can only be numbers.";
        }
    }
    if(empty($manufacture_date)) {
        $errorMessage[] = "Manufacture date field is empty.";
    }
    if(empty($expired_date)) {
        $errorMessage[] = "Expired date field is empty.";
    }
    if($promotion_price >= $price) {
        $errorMessage[] = "Promotion price must be cheaper than the original price.";
    }
    if($expired_date <= $manufacture_date) {
        $errorMessage[] = "Expired date must be later than the manufacture date.";
    }
    if(empty($category_id)) {
        $errorMessage[] = "No product category found.";
    }

    return $errorMessage;
}

function validateCategoryForm($category_name, $description) {
    $errorMessage = array();

    if(empty($category_name)) {
        $errorMessage[] = "Category name field is empty.";
    }
    if(empty($description)) {
        $errorMessage[] = "Description field is empty.";
    }

    return $errorMessage;
}

function validateCreateCustomerForm($username, $password, $confirmpassword, $firstname, $lastname, $gender, $birthdate, $email, $status) {
    $errorMessage = array();
    $passwordPattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{6,}$/";

    if(empty($username)) {
        $errorMessage[] = "Username field is empty.";
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
    }
    if(empty($lastname)) {
        $errorMessage[] = "Last name field is empty.";
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
    if(empty($status)) {
        $errorMessage[] = "Account status field is empty.";
    }

    return $errorMessage;
}

function validateUpdateCustomerForm($username, $firstname, $lastname, $gender, $birthdate, $email, $status, $db_password, $current_password, $new_password, $confirm_new_password) {
    $errorMessage = array();
    $passwordPattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{6,}$/";

    if(empty($username)) {
        $errorMessage[] = "Username field is empty.";
    }
    if(empty($firstname)) {
        $errorMessage[] = "First name field is empty.";
    }
    if(empty($lastname)) {
        $errorMessage[] = "Last name field is empty.";
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
    if(empty($status)) {
        $errorMessage[] = "Account status field is empty.";
    }
    if (empty($current_password) && empty($new_password) && empty($confirm_new_password)) {
        return $errorMessage;
    }
    if (empty($current_password) || empty($new_password) || empty($confirm_new_password)) {
        $errorMessage[] = "If you wish to change your password, please fill in all three password fields.";
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
        return $errorMessage;
    }
}

function validateOrderForm($selectedProductRow, $selectedCustomerID, $selectedProductID, $selectedProductQuantity){
    $errorMessage = array();

    if(empty($selectedCustomerID)) {
        $errorMessage[] = "Please select the customer name.";
    }

    for($i = 0; $i < $selectedProductRow; $i++) {
        if(empty($selectedProductID[$i])) {
            $errorMessage[] = "Please select the product for No. " . $i + 1 . ".";
        }
        if(empty($selectedProductQuantity[$i]) || !is_numeric($selectedProductQuantity[$i])){
            $errorMessage[] = "Please enter a number between 1-10 for purchase quantity of product No. " . $i + 1 . ".";
        }else{
            if($selectedProductQuantity[$i] <1 || $selectedProductQuantity[$i] >10) {
                $errorMessage[] = "The purchase quantity of product " . $i + 1 . " cannot be less than 0 or more than 10.";
            }
        }
    }
    return $errorMessage;
}

?>