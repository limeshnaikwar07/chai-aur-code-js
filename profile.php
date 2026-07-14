<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Opening Form</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="sidebar.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6fb;
            margin: 0;
        }
        /* MAIN CONTENT */
        .main {
            margin-left: 260px;
            padding: 25px;
            min-height: 100vh;
        }
        /* FORM CARD */
        .form-card {
            background: #fff;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
       }
        /* PROFILE DROPDOWN */
        .profile-wrapper {
            position: relative;
            display: inline-block;
            cursor: pointer;
        }

        .hover-card {
            position: absolute;
            top: 100%;
            right: 0;
            width: 220px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            border: 1px solid #eee;
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: all .25s ease;
            z-index: 999;
        }

        .profile-wrapper:hover .hover-card {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        .menu-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            color: #495057;
            text-decoration: none;
            border-radius: 8px;
        }
        .menu-link:hover {
            background: #f8f9fa;
            color: #0d6efd;
        }

        .menu-divider {
            margin: 8px 0;
        }

        .logout {
            color: #dc3545;
        }

        .logout:hover {
            background: #fff5f5;
        }

        @media(max-width:768px) {
            .main {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?>
    <!-- MAIN CONTENT -->
    <div class="main">

        <!-- PROFILE -->
        <div class="d-flex justify-content-end mb-4">

            <div class="profile-wrapper">

                <div class="d-flex align-items-center gap-2">
                    <span>Hey, Mr. Limesh!</span>
                    <img src="https://i.pravatar.cc/50"
                        width="40"
                        class="rounded-circle"
                        alt="">
                </div>

                <div class="hover-card">
                    <div class="p-3">

                        <a href="#" class="menu-link">
                            <i class="bi bi-person"></i>
                            My Profile
                        </a>

                        <a href="#" class="menu-link">
                            <i class="bi bi-key"></i>
                            Change Password
                        </a>

                        <hr class="menu-divider">

                        <a href="#" class="menu-link logout">
                            <i class="bi bi-box-arrow-right"></i>
                            Logout
                        </a>

                    </div>
                </div>

            </div>

        </div>

        <!-- FORM CARD -->
        <h3 class="text-secondary mb-4">
            Profile
        </h3>

        <div class="form-card w-50">
            <div class="text-primary text-center fw-bold w-100 mb-4 mt-0 shadow-lg p-3">
                User Profile
            </div>
            <form>
                <div class="row">

                    <div class="col-md-12 mb-3 text-primary fw-bold">
                        <label class="form-label">First Name</label>
                        <input type="text"
                            class="form-control"
                            required>
                    </div>

                    <div class="col-md-12 mb-3 text-primary fw-bold">
                        <label class="form-label">Last Name</label>
                        <input type="text"
                            class="form-control"
                            required>
                    </div>
                    <div class="col-md-12 mb-3 text-primary fw-bold">
                        <label class="form-label">Email Address</label>
                        <input type="email"
                            class="form-control text-muted bg-light"
                            value="limeshnaikwa@gmail.com"
                            readonly
                            required>
                    </div>
                    <div class="col-md-12 mb-3 text-primary fw-bold">
                        <label class="form-label">Mobile Number</label>
                        <input type="tel"
                            class="form-control"
                            required>
                    </div>
                    <div class="col-md-12 mb-3 text-primary fw-bold">
                        <label class="form-label">Registration Date</label>
                        <input type="datetime-local"
                            id="registrationDate"
                            class="form-control text-muted bg-light"
                            readonly
                            required>
                    </div>

                </div>
                <button type="submit"
                    class="btn btn-primary mt-3" style="border-radius: 20px; font-weight: 500; min-width: 160px;">
                    Update
                </button>

            </form>

        </div>
        <?php include 'footer.php'; ?>
    </div>

    <script src="sidebar.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const now = new Date();

            // Format to YYYY-MM-DDTHH:MM local time string
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const day = String(now.getDate()).padStart(2, '0');
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');

            const currentDateTime = `${year}-${month}-${day}T${hours}:${minutes}`;

            // Inject into the input field
            document.getElementById('registrationDate').value = currentDateTime;
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>