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
    } else if($price <= 0) {
        $errorMessage[] = "Please enter a valid price.";
    } else {
        if (!is_numeric($price)) {
            $errorMessage[] = "Prices can only be numbers.";
        }
    }
    if(empty($promotion_price)) {
        $errorMessage[] = "Promotion price field is empty.";
    } else if($promotion_price <= 0) {
        $errorMessage[] = "Please enter a valid promotion price.";
    } else {
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


?>