<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6fb;
        }

        /* SIDEBAR */
        .sidebar {
            width: 260px;
            height: 100vh;
            background: linear-gradient(180deg, #3b6ef5, #2b4dbf);
            color: white;
            position: fixed;
            left: 0;
            top: 0;
            padding: 20px;
            overflow-y: auto;
        }

        .sidebar a {
            display: block;
            color: white;
            padding: 10px;
            border-radius: 8px;
            text-decoration: none;
            margin-bottom: 8px;
        }

        .sidebar a:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        /* TOGGLE */
        .menu-toggle {
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            padding: 10px;
            border-radius: 8px;
        }

        .menu-toggle:hover {
            background: rgba(255, 255, 255, 0.15);
        }

        /* SUBMENU */
        .submenu {
            background: #fff;
            border-radius: 10px;
            margin-top: 5px;
            padding: 5px 0;
            display: none;
            border: 1px solid #e5e5e5;
        }

        .submenu a {
            color: #333;
            padding: 10px 12px;
            display: block;
            border-radius: 6px;
            text-decoration: none;
        }

        .submenu a:hover {
            background: #f2f4f8;
        }

        .submenu.show {
            display: block;
        }

        .rotate {
            transform: rotate(90deg);
            transition: 0.3s;
        }

        /* MAIN */
        .main {
            margin-left: 260px;
            padding: 20px;
        }

        .card-body {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .account {
            border: 1px solid white;
            border-radius: 10%;
            background: rgba(255, 255, 255, 0.2);
        }

        .account:hover {
            background: rgba(255, 255, 255, 0.4);
        }

        /* PROFILE HOVER DROPDOWN STYLES */
        .profile-wrapper {
            position: relative;
            display: inline-block;
            padding-bottom: 10px;
            cursor: pointer;
        }

        .hover-card {
            position: absolute;
            top: 100%;
            right: 0;
            width: 220px;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(0, 0, 0, 0.08);

            /* Hidden states */
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: all 0.25s ease-in-out;
            z-index: 1050;
        }

        /* Show card on wrapper hover */
        .profile-wrapper:hover .hover-card {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .menu-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 12px;
            color: #495057;
            text-decoration: none;
            font-size: 0.95rem;
            border-radius: 8px;
            transition: background-color 0.2s ease, color 0.2s ease;
        }

        .menu-link:hover {
            background-color: #f8f9fa;
            color: #0d6efd;
        }

        .menu-divider {
            margin: 8px 0;
            border-color: #e9ecef;
            opacity: 1;
        }

        .menu-link.logout {
            color: #dc3545;
        }

        .menu-link.logout:hover {
            background-color: #fff5f5;
            color: #a71d2a;
        }
    </style>
</head>

<body>
    <?php include 'sidebar.php'; ?>

    <div class="sidebar">
        <h4 class="mb-4"><i class="bi bi-bank"></i> E-BANKING</h4>
        <hr>
        <a href="User_dashboard.php"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>
        <hr>
        <a href="user_acc_form.php"><i class="bi bi-person-plus "></i> Account Opening</a>

        <div>
            <div class="menu-toggle" onclick="toggleMenu('payeeMenu','payeeArrow')">
                <span>
                    <i class="bi bi-people-fill me-2"></i> Payee / Beneficiary
                </span>
                <i id="payeeArrow" class="bi bi-chevron-right"></i>
            </div>

            <div id="payeeMenu" class="submenu">
                <a href="#">All Payee</a>
                <a href="#">Manage Payee</a>
            </div>
        </div>

        <a class="mt-2" href="Transaction_history.php"><i class="bi bi-clock-history me-2"></i> Transaction History</a>
        <hr>

        <div>
            <a class="account mt-2" href="report.php"> <i class="bi bi-file-earmark-text me-2 "></i>Report</a>
        </div>
    </div>

    <div class="main">

        <div class="d-flex justify-content-end align-items-center mb-4">
            <div class="profile-wrapper">

                <div class="d-flex align-items-center gap-2 profile-trigger">
                    <span class="me-1">Hey, Mr. Limesh!</span>
                    <img src="https://i.pravatar.cc/50" class="rounded-circle" width="35" alt="Avatar">
                </div>

                <div class="hover-card">
                    <div class="p-3">
                        <a href="profile.php" class="menu-link">
                            <i class="bi bi-person me-1"></i> My Profile
                        </a>
                        <a href="" class="menu-link" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                            <i class="bi bi-key me-1"></i> Change Password
                        </a>
                        <hr class="menu-divider">
                        <a href="UserLogin.php" class="menu-link logout">
                            <i class="bi bi-box-arrow-right me-1"></i> Log Out
                        </a>
                    </div>
                </div>

            </div>
        </div>

        <div class=" w-50 alert alert-warning alert-dismissible fade show " role="alert">
            <strong>Alert ! </strong> New User, Account not opened yet.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <!-- Report button and date selection fields with interactive toggling and styling for a modern look. -->
        <div class="d-flex justify-content-end w-100">
            <div class="card p-3 mb-4 shadow-sm" style="max-width: 350px; border-radius: 12px; border: none;">
                <div class="d-flex justify-content-end">
                    <button class="btn btn-primary  text-light d-flex align-items-center gap-2  w-100" id="toggleReportFields" style="border-radius: 8px; max-width: 350px; font-weight: 500;">
                        <a class="text-light" href="process_report.php"><i class="bi bi-file-earmark-text"></i> Generate Report</a>
                    </button>
                </div>
                <div id="dateSelectionFields" class="mt-3" style="display: none;">
                    <form action="process_report.php" method="GET">
                        <div class="row g-2">
                            <div class="col-6">
                                <label class="form-label small text-muted mb-1">From Date</label>
                                <input type="date" class="form-control form-control-sm" name="from_date" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label small text-muted mb-1">To Date</label>
                                <input type="date" class="form-control form-control-sm" name="to_date" required>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end gap-2 mt-3">
                            <button type="button" class="btn btn-light btn-sm" id="cancelReport">Cancel</button>
                            <button type="submit" class="btn btn-success btn-sm px-3">Fetch Report</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <h5 class="mb-3">Transaction History</h5>

        <div class="card-box">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>S.No</th>
                            <th>Transaction No</th>
                            <th>Account No</th>
                            <th>Amount</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>TXN987654321</td>
                            <td>1002938475</td>
                            <td>$1,250.00</td>
                            <td>Transfer</td>
                            <td><span class="btn btn-success btn-sm">Success</span></td>
                            <td>2026-06-03</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Interactive Date Picker Toggler
        const toggleBtn = document.getElementById('toggleReportFields');
        const dateFields = document.getElementById('dateSelectionFields');
        const cancelBtn = document.getElementById('cancelReport');

        toggleBtn.addEventListener('click', function() {
            if (dateFields.style.display === 'none') {
                dateFields.style.display = 'block';
                toggleBtn.classList.replace('btn-primary', 'btn-outline-secondary');
            } else {
                dateFields.style.display = 'none';
                toggleBtn.classList.replace('btn-outline-secondary', 'btn-primary');
            }
        });

        cancelBtn.addEventListener('click', function() {
            dateFields.style.display = 'none';
            toggleBtn.classList.replace('btn-outline-secondary', 'btn-primary');
        });

        // Payee Dropdown Sidebar Toggle
        function toggleMenu(menuId, arrowId) {
            const menu = document.getElementById(menuId);
            const arrow = document.getElementById(arrowId);

            menu.classList.toggle('show');
            arrow.classList.toggle('rotate');
        }
    </script>
</body>

</html>