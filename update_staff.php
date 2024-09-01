<?php
// Include database connection
include('db_connection.php');

// Get the staff_id from the URL
$staff_id = isset($_GET['staff_id']) ? $_GET['staff_id'] : '';

if ($staff_id && $_SERVER['REQUEST_METHOD'] !== 'POST') {
    // Fetch the staff details based on the staff_id
    $query = "SELECT * FROM staff WHERE staff_id = ?";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $staff_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $staff = $result->fetch_assoc();
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission
    $staff_registration_number = $_POST['staff_registration_number'];
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $surname = $_POST['surname'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    
    // Add additional fields as necessary

    // Update the staff information
    $query = "UPDATE staff SET 
                staff_registration_number = ?, 
                first_name = ?, 
                middle_name = ?, 
                surname = ?, 
                phone = ?, 
                email = ? 
                -- Add additional fields here 
              WHERE staff_id = ?";
    
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("ssssssi", 
                          $staff_registration_number, $first_name, $middle_name, $surname, $phone, $email, $staff_id);
        
        if ($stmt->execute()) {
            echo "Staff information has been updated successfully.";
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

    // Redirect back to the staff list after updating
    header("Location: view_staff.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Staff Information</title>
</head>
<body>
    <h2>Update Staff Information</h2>
    <form action="update_staff.php?staff_id=<?php echo htmlspecialchars($staff_id); ?>" method="POST">
        <label for="staff_registration_number">Registration Number:</label>
        <input type="text" name="staff_registration_number" value="<?php echo htmlspecialchars($staff['staff_registration_number']); ?>" required><br>
        
        <label for="first_name">First Name:</label>
        <input type="text" name="first_name" value="<?php echo htmlspecialchars($staff['first_name']); ?>" required><br>
        
        <label for="middle_name">Middle Name:</label>
        <input type="text" name="middle_name" value="<?php echo htmlspecialchars($staff['middle_name']); ?>"><br>
        
        <label for="surname">Surname:</label>
        <input type="text" name="surname" value="<?php echo htmlspecialchars($staff['surname']); ?>" required
        <label for="surname">Surname:</label>
        <input type="text" name="surname" value="<?php echo htmlspecialchars($staff['surname']); ?>" required><br>
        
        <label for="phone">Phone:</label>
        <input type="text" name="phone" value="<?php echo htmlspecialchars($staff['phone']); ?>"><br>
        
        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($staff['email']); ?>"><br>
        
        <!-- Add additional fields here as needed -->
        
        <input type="submit" value="Update">
    </form>
    
    <a href="view_staff.php">Back to Staff List</a>
</body>
</html>
