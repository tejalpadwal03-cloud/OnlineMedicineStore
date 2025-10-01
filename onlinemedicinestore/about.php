<?php
session_start();
include 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Online Medicine Store</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* ✅ Background section */
        .about-section {
            background: url('images/banner3.jpg') no-repeat center center/cover;
            min-height: 60vh;
            color: white;
            text-align: center;
            padding: 50px 20px;
        }

        .about-section h1 {
            font-size: 36px;
            margin-bottom: 10px;
        }

        .about-section p {
            font-size: 18px;
            max-width: 800px;
            margin: 0 auto;
            line-height: 1.8;
        }

        /* ✅ Content container */
        .about-content {
            background-color: #ffffff;
            padding: 40px 20px;
            max-width: 1000px;
            margin: 30px auto;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .about-content h2 {
            color: #1d5636;
            font-size: 28px;
            margin-bottom: 15px;
            text-align: center;
        }

        .about-content p {
            color: #555;
            font-size: 16px;
            line-height: 1.8;
            margin-bottom: 20px;
            text-align: justify;
        }

        /* ✅ Team Section */
        .team-section {
            text-align: center;
            margin-top: 40px;
        }

        .team-section h2 {
            color: #1d5636;
            font-size: 28px;
            margin-bottom: 20px;
        }

        .team-member {
            display: inline-block;
            margin: 20px;
            text-align: center;
        }

        .team-member img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .team-member h3 {
            font-size: 18px;
            color: #333;
            margin: 5px 0;
        }

        .team-member p {
            font-size: 14px;
            color: #777;
        }
    </style>
</head>
<body>

<div class="about-section">
    <h1>About Us</h1>
    <p>We provide the best quality medicines at affordable prices. Your health is our priority.</p>
</div>

<div class="about-content">
    <h2>Our Mission</h2>
    <p>Our mission is to make healthcare accessible and affordable for everyone. We are committed to providing high-quality medicines directly to your doorstep with a seamless ordering experience.</p>

    <h2>Our Vision</h2>
    <p>To become the most trusted online medicine store, ensuring timely delivery and customer satisfaction. We aim to build a healthier society by making medicines available to all.</p>

    <h2>Why Choose Us?</h2>
    <p>✔️ Certified by health authorities</p>
    <p>✔️ Fast and secure delivery</p>
    <p>✔️ High-quality medicines from trusted manufacturers</p>
    <p>✔️ 24/7 customer support for all your queries</p>
</div>

<div class="team-section">
    <h2>Meet Our Team</h2>
    <div class="team-member">
        <img src="images/team1.jpg" alt="Team Member">
        <h3>John Doe</h3>
        <p>CEO & Founder</p>
    </div>
    <div class="team-member">
        <img src="images/team2.jpg" alt="Team Member">
        <h3>Jane Smith</h3>
        <p>Chief Pharmacist</p>
    </div>
    <div class="team-member">
        <img src="images/team3.jpg" alt="Team Member">
        <h3>Michael Johnson</h3>
        <p>Operations Manager</p>
    </div>
</div>

</body>
</html>

<?php include 'footer.php'; ?>
