<?php
include 'db.php'; // Include the database connection

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name'] ?? '');
    $professional_title = htmlspecialchars($_POST['professional_title'] ?? '');
    $organization = htmlspecialchars($_POST['organization'] ?? '');
    $expertise = htmlspecialchars($_POST['expertise'] ?? '');
    $career_description = htmlspecialchars($_POST['career_description'] ?? '');
    $phone = htmlspecialchars($_POST['phone'] ?? '');
    $email = htmlspecialchars($_POST['email'] ?? '');
    $location = htmlspecialchars($_POST['location'] ?? '');
    $linkedin = htmlspecialchars($_POST['linkedin'] ?? '');

    // Handle image upload
    $image = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $image = $uploadDir . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $image);
    }

    // Insert data into the database
    $stmt = $conn->prepare("INSERT INTO profiles (name, professional_title, organization, expertise, career_description, phone, email, location, linkedin, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$name, $professional_title, $organization, $expertise, $career_description, $phone, $email, $location, $linkedin, $image]);

    // Redirect to avoid resubmission on refresh
    header("Location: profiles.php");
    exit;
}

// Fetch all profiles
$stmt = $conn->query("SELECT * FROM profiles");
$profiles = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profiles - AnalyticaHub</title>
    <link rel="stylesheet" href="assets/css/tailwind.css">
    <style>
        body, html {
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        nav {
            height: 48px;
        }
        .add-profile-btn {
            background-color: #1d4ed8;
            color: white;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
            text-align: center;
        }
        .add-profile-btn:hover {
            background-color: #2563eb;
        }
        .popup-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 50;
            display: none;
            justify-content: center;
            align-items: center;
            overflow-y: auto;
        }
        .popup-container {
            max-width: 500px;
            width: 90%;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow-y: auto;
            max-height: 90vh;
        }
        .popup-container h2 {
            margin: 0 0 20px;
            font-size: 1.5rem;
        }
        .popup-container button.close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: transparent;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
        }
        .popup-container button.close-btn:hover {
            color: #ff0000;
        }
        footer {
            background-color: #1a202c;
            color: white;
            text-align: center;
            padding: 10px 0;
            font-size: 0.9rem;
            margin-top: auto;
        }
    </style>
</head>
<body class="bg-gradient-to-r from-gray-100 to-gray-200 text-gray-900 pt-16">

<!-- Navigation -->
<nav class="bg-blue-600 text-white px-4 fixed top-0 left-0 w-full shadow-md z-10 flex items-center">
    <div class="flex items-center">
        <h1 class="text-xl font-bold mr-6">AnalyticaHub</h1>
    </div>
    <ul class="flex justify-center w-full space-x-4">
        <li><a href="index.php" class="hover:text-gray-200">Home</a></li>
        <li><a href="profiles.php" class="hover:text-gray-200">Profiles</a></li>
    </ul>
</nav>

<!-- Profile Aggregator -->
<div class="max-w-6xl mx-auto mt-8 p-6">
    <h1 class="text-4xl font-bold text-blue-600 text-center mb-6">Professional Profiles</h1>
    <div class="flex justify-end mb-4">
        <button onclick="openPopup('add-profile-popup')" class="add-profile-btn">Add Profile</button>
    </div>

    <!-- Profiles Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php if (!empty($profiles)): ?>
            <?php foreach ($profiles as $index => $profile): ?>
                <div class="bg-white shadow-lg rounded-lg p-6 text-center">
                    <!-- Profile Image -->
                    <div class="w-24 h-24 mx-auto rounded-full overflow-hidden border border-gray-300 mb-4">
                        <img src="<?php echo htmlspecialchars($profile['image'] ?? 'assets/img/default-user.png'); ?>" alt="Profile Image" class="w-full h-full object-cover">
                    </div>
                    <h2 class="text-2xl font-semibold text-gray-800"><?php echo htmlspecialchars($profile['name'] ?? 'Not provided'); ?></h2>
                    <p class="text-gray-600">
                        <?php echo htmlspecialchars($profile['professional_title'] ?? 'Not provided'); ?> at
                        <span class="font-bold"><?php echo htmlspecialchars($profile['organization'] ?? 'Not provided'); ?></span>
                    </p>
                    <p class="text-gray-600">Expertise: <?php echo htmlspecialchars($profile['expertise'] ?? 'Not provided'); ?></p>
                    <button onclick="openPopup('learn-more-<?php echo $index; ?>')" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded-lg">Learn More</button>

                    <!-- Learn More Popup -->
                    <div id="learn-more-<?php echo $index; ?>" class="popup-overlay">
                        <div class="popup-container">
                            <button class="close-btn" onclick="closePopup('learn-more-<?php echo $index; ?>')">✖</button>
                            <h2 class="text-2xl font-bold text-gray-800 mb-4">About <?php echo htmlspecialchars($profile['name']); ?></h2>
                            <p class="text-gray-600 mb-4"><strong>Career Description:</strong></p>
                            <p class="text-gray-600 mb-4"><?php echo nl2br(htmlspecialchars($profile['career_description'] ?? 'No career description provided.')); ?></p>
                            <p class="text-gray-600"><strong>Contact:</strong></p>
                            <p class="text-gray-600">Email: <?php echo htmlspecialchars($profile['email']); ?></p>
                            <p class="text-gray-600">Phone: <?php echo htmlspecialchars($profile['phone']); ?></p>
                            <p class="text-gray-600">Location: <?php echo htmlspecialchars($profile['location']); ?></p>
                            <p><a href="<?php echo htmlspecialchars($profile['linkedin']); ?>" class="text-blue-500 underline hover:text-blue-700">LinkedIn</a></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-gray-600 text-center col-span-full">No profiles found.</p>
        <?php endif; ?>
    </div>
</div>

<!-- Add Profile Popup -->
<div id="add-profile-popup" class="popup-overlay">
    <div class="popup-container">
        <button class="close-btn" onclick="closePopup('add-profile-popup')">✖</button>
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Add New Profile</h2>
        <form method="POST" action="profiles.php" enctype="multipart/form-data">
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Name</label>
                <input type="text" name="name" class="w-full border rounded-lg p-2" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Professional Title</label>
                <input type="text" name="professional_title" class="w-full border rounded-lg p-2" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Organization</label>
                <input type="text" name="organization" class="w-full border rounded-lg p-2" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Expertise</label>
                <input type="text" name="expertise" class="w-full border rounded-lg p-2" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Career Description</label>
                <textarea name="career_description" rows="4" class="w-full border rounded-lg p-2" placeholder="Write about your career here..." required></textarea>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Phone</label>
                <input type="text" name="phone" class="w-full border rounded-lg p-2" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Email</label>
                <input type="email" name="email" class="w-full border rounded-lg p-2" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Location</label>
                <input type="text" name="location" class="w-full border rounded-lg p-2" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">LinkedIn</label>
                <input type="url" name="linkedin" class="w-full border rounded-lg p-2" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Profile Image</label>
                <input type="file" name="image" class="w-full border rounded-lg p-2">
            </div>
            <div class="flex justify-end">
                <button type="button" onclick="closePopup('add-profile-popup')" class="bg-gray-500 text-white px-4 py-2 rounded-lg mr-2">Cancel</button>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg">Submit</button>
            </div>
        </form>
    </div>
</div>

<!-- Footer -->
<footer>
    © 2024 AnalyticaHub. All Rights Reserved. Created by Pianos Gerald Manjera.
</footer>

<script>
    function openPopup(popupId) {
        document.getElementById(popupId).style.display = 'flex';
    }

    function closePopup(popupId) {
        document.getElementById(popupId).style.display = 'none';
    }
</script>
</body>