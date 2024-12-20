<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Analytica</title>
    <link rel="stylesheet" href="assets/css/tailwind.css">
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        nav {
            height: 48px; /* Compact navbar height */
        }
        .carousel-container {
            flex: 1; /* Ensures the carousel fills all remaining space */
            position: relative;
            overflow: hidden;
        }
        #carousel {
            display: flex;
            height: 100%;
            transition: transform 0.5s ease-in-out;
        }
        .carousel-slide {
            flex: 0 0 100%;
            height: 100%;
            position: relative;
        }
        .carousel-slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: brightness(80%); /* Darkens the image by 20% */
        }
        .carousel-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            color: white;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.7);
        }
        .carousel-text h1 {
            font-size: 4rem;
            font-weight: bold;
        }
        .carousel-text p {
            font-size: 1.2rem;
            margin-top: 0.5rem;
        }
        .carousel-indicators {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            justify-content: center;
            gap: 8px;
        }
        .carousel-indicators button {
            width: 12px;
            height: 12px;
            background-color: rgba(255, 255, 255, 0.6);
            border: none;
            border-radius: 50%;
            cursor: pointer;
        }
        .carousel-indicators button.active {
            background-color: white;
        }
        .arrow-button {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            z-index: 10;
            width: 40px;
            height: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .arrow-button:hover {
            background-color: rgba(0, 0, 0, 0.8);
        }
        .arrow-left {
            left: 10px;
        }
        .arrow-right {
            right: 10px;
        }
        footer {
            background-color: #1a202c; /* Dark gray footer */
            color: white;
            text-align: center;
            padding: 10px 0;
            font-size: 0.9rem;
        }
    </style>
</head>
<body class="bg-gray-900">

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

<!-- Carousel -->
<div class="carousel-container">
    <!-- Arrow Buttons -->
    <button class="arrow-button arrow-left" onclick="prevSlide()">&#10094;</button>
    <button class="arrow-button arrow-right" onclick="nextSlide()">&#10095;</button>

    <div id="carousel">
        <div class="carousel-slide">
            <img src="assets/img/slide1.jpg" alt="Slide 1">
            <div class="carousel-text">
                <h1>Empowering Development Through Data and Collaboration</h1>
                <p>Discover a network of professionals revolutionizing humanitarian services and development analytics.</p>
            </div>
        </div>
        <div class="carousel-slide">
            <img src="assets/img/slide2.jpg" alt="Slide 2">
            <div class="carousel-text">
                <h1>Insights Driving Humanitarian Solutions</h1>
                <p>Showcasing expertise in geospatial analysis, policy development, and participatory research for impactful action.</p>
            </div>
        </div>
        <div class="carousel-slide">
            <img src="assets/img/slide3.jpg" alt="Slide 3">
            <div class="carousel-text">
                <h1>Connect with Experts Making a Difference</h1>
                <p>Explore profiles of consultants transforming communities through data, development, and humanitarian work.</p>
            </div>
        </div>
    </div>

    <!-- Carousel Indicators -->
    <div class="carousel-indicators">
        <button onclick="showSlide(0)" class="active"></button>
        <button onclick="showSlide(1)"></button>
        <button onclick="showSlide(2)"></button>
    </div>
</div>

<!-- Footer -->
<footer>
    © 2024 AnalyticaHub. All Rights Reserved. Created by Pianos Gerald Manjera.
</footer>

<script>
    let currentSlide = 0;

    function showSlide(slide) {
        const carousel = document.getElementById('carousel');
        const indicators = document.querySelectorAll('.carousel-indicators button');
        const totalSlides = document.querySelectorAll('.carousel-slide').length;

        // Update the active slide
        currentSlide = slide >= 0 && slide < totalSlides ? slide : 0;

        // Apply transform for sliding
        carousel.style.transform = `translateX(-${currentSlide * 100}%)`;

        // Update active indicator
        indicators.forEach((indicator, index) => {
            indicator.classList.toggle('active', index === currentSlide);
        });
    }

    function prevSlide() {
        const totalSlides = document.querySelectorAll('.carousel-slide').length;
        currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
        showSlide(currentSlide);
    }

    function nextSlide() {
        const totalSlides = document.querySelectorAll('.carousel-slide').length;
        currentSlide = (currentSlide + 1) % totalSlides;
        showSlide(currentSlide);
    }

    // Auto-rotate slides
    setInterval(() => {
        nextSlide();
    }, 5000);
</script>

</body>
</html>
