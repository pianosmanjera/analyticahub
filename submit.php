<?php
include 'db.php'; // Include the database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $current_role = $_POST['current_role'];
    $organization = $_POST['organization'];
    $expertise = $_POST['expertise'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $linkedin = $_POST['linkedin'];
    $location = $_POST['location'];

    $stmt = $conn->prepare("INSERT INTO profiles (name, current_role, organization, expertise, email, phone, linkedin, location) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$name, $current_role, $organization, $expertise, $email, $phone, $linkedin, $location]);

    echo "Profile submitted successfully!";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Submit Profile</title>
</head>
<body>
<h1>Submit Profile</h1>
<form method="POST" action="submit.php">
    <label>Name: <input name="name" required></label><br>
    <label>Current Role: <input name="current_role" required></label><br>
    <label>Organization: <input name="organization" required></label><br>
    <label>Expertise: <input name="expertise" required></label><br>
    <label>Email: <input name="email" required></label><br>
    <label>Phone: <input name="phone" required></label><br>
    <label>LinkedIn: <input name="linkedin" required></label><br>
    <label>Location: <input name="location" required></label><br>
    <button type="submit">Submit</button>
</form>
</body>
</html>

