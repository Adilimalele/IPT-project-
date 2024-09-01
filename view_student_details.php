<?php
// Include database connection
include('db_connection.php');

// Get the registration_number from the URL
$registration_number = isset($_GET['registration_number']) ? $_GET['registration_number'] : '';

if ($registration_number) {
    // Fetch the staff details based on the registration_number
    $query = "SELECT * FROM students WHERE registration_number = ?";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $registration_number);
        $stmt->execute();
        $result = $stmt->get_result();
        $staff = $result->fetch_assoc();
    }
} else {
    echo "Invalid staff ID.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Staff Details</title>
</head>
<body>
    <h2>Staff Details</h2>
    <p><strong>Registration Number:</strong> <?php echo htmlspecialchars($staff['staff_registration_number']); ?></p>
    <p><strong>First Name:</strong> <?php echo htmlspecialchars($staff['first_name']); ?></p>
    <p><strong>Middle Name:</strong> <?php echo htmlspecialchars($staff['middle_name']); ?></p>
    <p><strong>Surname:</strong> <?php echo htmlspecialchars($staff['surname']); ?></p>
    <p><strong>Gender:</strong> <?php echo htmlspecialchars($staff['gender']); ?></p>
    <p><strong>Age:</strong> <?php echo htmlspecialchars($staff['age']); ?></p>
    <p><strong>Region:</strong> <?php echo htmlspecialchars($staff['address_region']); ?></p>
    <p><strong>District:</strong> <?php echo htmlspecialchars($staff['address_district']); ?></p>
    <p><strong>Ward:</strong> <?php echo htmlspecialchars($staff['address_ward']); ?></p>
    <p><strong>Village:</strong> <?php echo htmlspecialchars($staff['address_village']); ?></p>
    <p><strong>Street:</strong> <?php echo htmlspecialchars($staff['address_street']); ?></p>
    <p><strong>Phone:</strong> <?php echo htmlspecialchars($staff['phone']); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($staff['email']); ?></p>
    <p><strong>Relationship:</strong> <?php echo htmlspecialchars($staff['relationship']); ?></p>
    <p><strong>Marital Status:</strong> <?php echo htmlspecialchars($staff['marital_status']); ?></p>
    <p><strong>NIDA Number:</strong> <?php echo htmlspecialchars($staff['nida_number']); ?></p>
    <p><strong>Profile Photo:</strong> <img src="data:image/jpeg;base64,<?php echo base64_encode($staff['profile_photo']); ?>" alt="Profile Photo"></p>

    <a href="view_staff.php">Back to Staff List</a>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
