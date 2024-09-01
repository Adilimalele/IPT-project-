<?php
// Include database connection
include('db_connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $staff_registration_number = $_POST['staff_registration_number'];
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $surname = $_POST['surname'];
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $address_region = $_POST['address_region'];
    $address_district = $_POST['address_district'];
    $address_ward = $_POST['address_ward'];
    $address_village = $_POST['address_village'];
    $address_street = $_POST['address_street'];
    $alleges = isset($_POST['alleges']) ? (int)$_POST['alleges'] : 0; // Convert to integer (0 or 1)
    $disorder = isset($_POST['disorder']) ? (int)$_POST['disorder'] : 0; // Convert to integer (0 or 1)
    $disorder_details = $_POST['disorder_details'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $relationship = $_POST['relationship'];
    $marital_status = $_POST['marital_status'];
    $nida_number = $_POST['nida_number'];
    
    // Handling file upload
    $profile_photo = $_FILES['profile_photo']['tmp_name'];
    $profile_photo_blob = file_get_contents($profile_photo);

    // SQL Query to insert staff data
    $query = "INSERT INTO staff (
                staff_registration_number, first_name, middle_name, surname, gender, age, 
                address_region, address_district, address_ward, address_village, address_street, 
                alleges, disorder, disorder_details, phone, email, relationship, marital_status, nida_number, profile_photo
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare statement
    if ($stmt = $conn->prepare($query)) {
        // Bind parameters
        $stmt->bind_param(
            "sssssisssssiisisssib",
            $staff_registration_number, $first_name, $middle_name, $surname, $gender, $age,
            $address_region, $address_district, $address_ward, $address_village, $address_street,
            $alleges, $disorder, $disorder_details, $phone, $email, $relationship, $marital_status, $nida_number, $profile_photo_blob
        );

        // Execute the statement
        if ($stmt->execute()) {
            // Redirect to staff education form with the staff_registration_number as a GET parameter
            header("Location: register_staff_education.php?staff_registration_number=" . urlencode($staff_registration_number));
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>
