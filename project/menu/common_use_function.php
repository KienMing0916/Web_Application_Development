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

function validateCustomerForm($username, $firstname, $lastname, $gender, $birthdate, $email, $status) {
    $errorMessage = array();

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

    return $errorMessage;
}

function validateCustomerFormPassword($password, $confirmpassword) {
    $errorMessage = array();

    if(empty($password)) {
        $errorMessage[] = "Password field is empty.";
    }else {
        $passwordPattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{6,}$/";
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

    return $errorMessage;
}

?>