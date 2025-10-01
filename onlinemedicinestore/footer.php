<footer>
    <style>
        footer {
            background: #228B22; /* Green background */
            color: white;
            padding: 40px 0;
            font-family: Arial, sans-serif;
        }

        .footer-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            max-width: 1100px;
            margin: 0 auto;
            text-align: center;
        }

        .footer-section {
            flex: 1;
            margin: 20px;
            min-width: 200px;
        }

        .footer-section h2 {
            color: #ffcc00; /* Yellow-Gold headings */
            margin-bottom: 10px;
        }

        .footer-section p, .footer-section ul {
            font-size: 14px;
            line-height: 1.5;
            color: #f1f1f1;
        }

        .footer-section ul {
            list-style: none;
            padding: 0;
        }

        .footer-section ul li {
            margin: 5px 0;
        }

        .footer-section ul li a {
            color: #ffcc00; /* Yellow-Gold links */
            text-decoration: none;
            transition: 0.3s;
        }

        .footer-section ul li a:hover {
            color: #ffd700; /* Brighter Yellow on Hover */
        }

        .social-icons a {
            margin: 5px;
            display: inline-block;
        }

        .social-icons img {
            width: 30px;
            height: 30px;
            transition: transform 0.3s;
        }

        .social-icons img:hover {
            transform: scale(1.2);
        }

        .footer-bottom {
            background: #1a6e1a; /* Darker green bottom */
            text-align: center;
            padding: 10px;
            margin-top: 20px;
            font-size: 14px;
        }
    </style>

    <div class="footer-container">
        <div class="footer-section about">
            <h2>About Us</h2>
            <p>We provide the best quality medicines at affordable prices. Your health is our priority.</p>
        </div>

        <div class="footer-section links">
            <h2>Quick Links</h2>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="cart.php">Cart</a></li>
                <li><a href="checkout.php">Checkout</a></li>
            </ul>
        </div>

        <div class="footer-section contact">
            <h2>Contact Us</h2>
            <p>Email: medicalstore@gmail.com</p>
            <p>Phone: +91 98765 43210</p>
            <p>Address: 123, Rajgurunagar,Pune , India</p>
        </div>

        <!--<div class="footer-section social">
            <h2>Follow Us</h2>
            <div class="social-icons">
                <a href="#"><img src="images/facebook.png" alt="Facebook"></a>
                <a href="#"><img src="images/twitter.png" alt="Twitter"></a>
                <a href="#"><img src="images/instagram.png" alt="Instagram"></a>
            </div>-->
        </div>
    </div>

    <div class="footer-bottom">
        <p>&copy; <?php echo date("Y"); ?>  Online Medicine Store | All Rights Reserved</p>
    </div>
</footer>
