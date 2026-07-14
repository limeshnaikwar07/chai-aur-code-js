<?php
// You can add session or DB connection later here
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>e-Banking System</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .hero {
            height: 100%;
            width: 100%;
            background: url("IMAGES/paytmicons.png") no-repeat right 40px center,
                linear-gradient(135deg, #01152a, #035ce1);
            background-size: 35vw, cover;
            overflow: hidden;}

        .hero {
            height: 80vh;
            background: linear-gradient(135deg, #01152a, #035ce1);
            overflow: hidden;
        }

        .hero-img {
            max-width: 80%;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        .hero-content,
        .btn-custom {

            color: #fff;
            padding: 100px 30px;
            border-radius: 30px;
            text-decoration: none;
            width: 400px;
            justify-content: left;
            align-items: left;
            text-align: right;
        }

        .lead {
            font-size: large;
            font-weight: bold;

        }

        .footer {
            background: linear-gradient(135deg, #0d6efd, #001f3f);
            color: #fff;
            padding: 60px 0 20px;
            margin-top: 50px;
        }

        .footer h5 {
            font-size: 22px;
            margin-bottom: 20px;
            font-weight: bold;
            position: relative;
        }

        .footer h5::after {
            content: "";
            width: 60px;
            height: 3px;
            background: #ffd700;
            position: absolute;
            left: 0;
            bottom: -8px;
            border-radius: 5px;
        }

        .footer p {
            color: #e0e0e0;
            line-height: 1.8;
            font-size: 15px;
        }

        .footer-links {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-top: 15px;
        }

        .footer-links a {
            color: #fff;
            text-decoration: none;
            transition: 0.3s ease;
            font-size: 15px;
        }

        .footer-links a:hover {
            color: #ffd700;
            padding-left: 8px;
        }

        .contact-section {
            margin-top: 30px;
            /* text-align: center; */
        }

        .contact-section p {
            margin: 10px 0;
            font-size: 15px;
        }

        .footer hr {
            border: 0;
            height: 5px;
            background: rgba(255, 255, 255, 0.2);
            margin: 30px 0 15px;
            width:50%;
        }

        .footer-bottom {
            text-align: center;
            color: #dcdcdc;
            font-size: 14px;
        }

        .footer-box {
            margin-bottom: 25px;
        }

        @media(max-width:768px) {
            .footer {
                text-align: center;
            }

            .footer h5::after {
                left: 50%;
                transform: translateX(-50%);
            }

            .footer-links a:hover {
                padding-left: 0;
            }
        }
    </style>
</head>

<body>

   
    <!-- Enhanced e-Banking Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">

                <!-- About -->
                <div class="col-md-4 footer-box">
                    <h5>About e-Banking</h5>
                    <p>
                        Our e-Banking System provides secure and fast online banking
                        services including money transfers, account management,
                        balance checking, transaction history, and secure login
                        facilities for customers and bank staff.
                    </p>
                </div>

                <!-- Banking Services -->
                <div class="col-md-4 footer-box">
                    <h5>Banking Services</h5>

                    <div class="footer-links">
                        <a href="#">Online Account Management</a>
                        <a href="#">Secure Money Transfer</a>
                        <a href="#">Transaction History</a>
                        <a href="#">Cash Deposit & Withdrawal</a>
                        <a href="#">24/7 Customer Support</a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="col-md-4 footer-box">
                    <h5>Quick Links</h5>

                    <div class="footer-links">
                        <a href="<?php echo $user; ?>">User / Account Holder</a>
                        <a href="<?php echo $cashier; ?>">Cashier Panel</a>
                        <a href="<?php echo $admin; ?>">Admin Dashboard</a>
                        <a href="#">Privacy Policy</a>
                        <a href="#">Terms & Conditions</a>
                    </div>
                </div>

            </div>

            <!-- Contact Info -->
            <div class="row contact-section">

                <div class="col-md-4">
                    <p><strong>Email:</strong> support@ebanking.com</p>
                    <hr>
                </div>

                <div class="col-md-4">
                    <p><strong>Phone:</strong> +91 9876543210</p>
                    <hr>
                </div>

                <div class="col-md-4">
                    <p><strong>Location:</strong> Nagpur, Maharashtra, India</p>
                    <hr>
                </div>

            </div>

          

            <!-- Bottom -->
            <div class="footer-bottom">
                <small>
                    © 2026 e-Banking System | Secure Digital Banking Platform |
                    All Rights Reserved
                </small>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>