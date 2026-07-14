<?php
/* ============================================================
   User_dashboard.php
   ------------------------------------------------------------
   ASSUMED SCHEMA — rename if your actual tables/columns differ:

     accounts table:
         id, user_id, status ('approved' | 'pending' | 'rejected')
     transactions table:
         id, user_id, transaction_no, account_no, amount,
         type, status, created_at
   ============================================================ */

require_once 'auth_check.php';   // redirects to login.php if not logged in
require_once 'db.php';

/* ---------- Check if the user has an approved account ---------- */
$hasApprovedAccount = false;
$stmt = mysqli_prepare($conn, "SELECT COUNT(*) AS cnt FROM accounts WHERE user_id = ? AND status = 'approved'");
mysqli_stmt_bind_param($stmt, "i", $loggedInUserId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
if ($row = mysqli_fetch_assoc($result)) {
    $hasApprovedAccount = ((int) $row['cnt']) > 0;
}
mysqli_stmt_close($stmt);

/* ---------- Fetch this user's transactions ---------- */
$transactions = [];
$stmt = mysqli_prepare($conn, "
    SELECT transaction_no, account_no, amount, type, status, created_at
    FROM transactions
    WHERE user_id = ?
    ORDER BY created_at DESC
    LIMIT 50
");
mysqli_stmt_bind_param($stmt, "i", $loggedInUserId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
while ($row = mysqli_fetch_assoc($result)) {
    $transactions[] = $row;
}
mysqli_stmt_close($stmt);

function statusBadgeClass($status) {
    switch (strtolower($status)) {
        case 'success':  return 'btn-success';
        case 'pending':  return 'btn-warning';
        case 'failed':   return 'btn-danger';
        default:         return 'btn-secondary';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="sidebar.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6fb;
            margin: 0;
        }

        .card-body {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* PROFILE HOVER DROPDOWN */
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
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: all 0.25s ease-in-out;
            z-index: 1050;
        }

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

        /* Responsive tweaks for dashboard-specific content */
        @media (max-width: 768px) {
            .report-card {
                max-width: 100% !important;
            }
        }
    </style>
</head>

<body>

    <?php include 'user_sidebar.php'; ?>

    <!-- MAIN CONTENT -->
    <div class="main">

        <div class="card w-100 mb-4 shadow-sm p-2">
            <div class="align-items-center d-flex justify-content-end w-100">
                <div class="align-items-center mb-2 mt-2">
                    <div class="profile-wrapper">

                        <div class="d-flex align-items-center gap-2 profile-trigger">
                            <span class="me-1">Hey, Mr. <?php echo htmlspecialchars($loggedInUserName); ?>!</span>
                            <img src="https://i.pravatar.cc/50" class="rounded-circle" width="35" alt="Avatar">
                        </div>

                        <div class="hover-card">
                            <div class="p-3">
                                <a href="profile.php" class="menu-link">
                                    <i class="bi bi-person me-1"></i> My Profile
                                </a>
                                <a href="#" class="menu-link" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                                    <i class="bi bi-key me-1"></i> Change Password
                                </a>
                                <hr class="menu-divider">
                                <a href="logout.php" class="menu-link logout">
                                    <i class="bi bi-box-arrow-right me-1"></i> Log Out
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- DASHBOARD HEADING + ALERT + REPORT BUTTON -->
        <div class="container-fluid px-0">
            <div class="row align-items-center g-3 mb-4">

                <div class="col-12 col-md-4">
                    <h3 class="text-secondary m-0 mb-2">Dashboard</h3>

                    <?php if (!$hasApprovedAccount): ?>
                        <div class="alert alert-danger alert-dismissible fade show m-0" role="alert">
                            <strong>Alert!</strong> New User, Account not opened yet.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="col-12 col-md-8 d-flex justify-content-md-end justify-content-start align-items-center">
                    <div class="card p-3 mb-0 shadow-sm report-card" style="max-width: 350px; border-radius: 12px; border: none;">
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-primary d-flex align-items-center gap-2 w-100"
                                id="toggleReportFields" style="border-radius: 8px; font-weight: 500;">
                                <i class="bi bi-file-earmark-text"></i> Generate Report
                            </button>
                        </div>

                        <!-- Date range fields — hidden until "Generate Report" is clicked -->
                        <div id="dateSelectionFields" style="display:none;" class="mt-3">
                            <form action="report.php" method="GET">
                                <div class="mb-2">
                                    <label class="form-label small text-muted mb-1">From</label>
                                    <input type="date" name="from_date" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small text-muted mb-1">To</label>
                                    <input type="date" name="to_date" class="form-control" required>
                                </div>
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary w-100">Generate</button>
                                    <button type="button" id="cancelReport" class="btn btn-outline-secondary w-100">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- TRANSACTION TABLE — now populated from the database -->
        <div class="card-box mt-3">
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
                        <?php if (empty($transactions)): ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    No transactions found yet.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($transactions as $i => $txn): ?>
                                <tr>
                                    <td><?php echo $i + 1; ?></td>
                                    <td><?php echo htmlspecialchars($txn['transaction_no']); ?></td>
                                    <td><?php echo htmlspecialchars($txn['account_no']); ?></td>
                                    <td>&#8377; <?php echo number_format((float) $txn['amount'], 2); ?></td>
                                    <td><?php echo htmlspecialchars($txn['type']); ?></td>
                                    <td>
                                        <span class="btn btn-sm <?php echo statusBadgeClass($txn['status']); ?>">
                                            <?php echo htmlspecialchars($txn['status']); ?>
                                        </span>
                                    </td>
                                    <td><?php echo date('Y-m-d', strtotime($txn['created_at'])); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- CHANGE PASSWORD MODAL -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 16px;">
                <div class="modal-header border-0 pt-4 px-4">
                    <h5 class="modal-title fw-bold" id="changePasswordModalLabel">
                        <i class="bi bi-shield-lock text-primary me-2"></i>Reset Password
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-4 pb-4">
                    <form id="dashboardResetForm">

                        <div class="mb-3">
                            <label for="currentPassword" class="form-label small text-muted mb-1">Enter Current Password</label>
                            <input type="password" class="form-control" id="currentPassword" style="height: 48px; border-radius: 10px;" required>
                        </div>

                        <div class="mb-3">
                            <label for="newPassword" class="form-label small text-muted mb-1">Enter New Password</label>
                            <input type="password" class="form-control" id="newPassword" style="height: 48px; border-radius: 10px;" required minlength="8">
                        </div>

                        <div class="mb-4">
                            <label for="confirmPassword" class="form-label small text-muted mb-1">Confirm New Password</label>
                            <input type="password" class="form-control" id="confirmPassword" style="height: 48px; border-radius: 10px;" required minlength="8">
                        </div>

                        <div class="alert alert-danger p-2 small d-none" id="modalResetError"></div>
                        <div class="alert alert-success p-2 small d-none" id="modalResetSuccess">
                            <i class="bi bi-check-circle me-1"></i> Password updated successfully!
                        </div>

                        <button type="submit" class="btn btn-primary w-100 fw-bold" style="height: 48px; border-radius: 10px;">
                            Update Password
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="sidebar.js"></script>

    <script>
        // Real backend call to update_password.php instead of a fake client-side success
        document.getElementById('dashboardResetForm').addEventListener('submit', function (event) {
            event.preventDefault();

            const currentPass = document.getElementById('currentPassword').value;
            const newPass = document.getElementById('newPassword').value;
            const confirmPass = document.getElementById('confirmPassword').value;

            const errorPanel = document.getElementById('modalResetError');
            const successPanel = document.getElementById('modalResetSuccess');

            errorPanel.classList.add('d-none');
            successPanel.classList.add('d-none');

            if (newPass !== confirmPass) {
                errorPanel.textContent = "New passwords do not match.";
                errorPanel.classList.remove('d-none');
                return;
            }

            fetch('update_password.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    current_password: currentPass,
                    new_password: newPass
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        successPanel.textContent = data.message;
                        successPanel.classList.remove('d-none');
                        document.getElementById('dashboardResetForm').reset();

                        setTimeout(() => {
                            const modalEl = document.getElementById('changePasswordModal');
                            const modalInstance = bootstrap.Modal.getInstance(modalEl);
                            if (modalInstance) modalInstance.hide();
                            successPanel.classList.add('d-none');
                        }, 1800);
                    } else {
                        errorPanel.textContent = data.message || "Something went wrong.";
                        errorPanel.classList.remove('d-none');
                    }
                })
                .catch(() => {
                    errorPanel.textContent = "Network error. Please try again.";
                    errorPanel.classList.remove('d-none');
                });
        });

        // Report date-range toggle — now safely checks elements exist first
        const toggleBtn = document.getElementById('toggleReportFields');
        const dateFields = document.getElementById('dateSelectionFields');
        const cancelBtn = document.getElementById('cancelReport');

        if (toggleBtn && dateFields) {
            toggleBtn.addEventListener('click', function () {
                const isHidden = dateFields.style.display === 'none' || dateFields.style.display === '';
                dateFields.style.display = isHidden ? 'block' : 'none';
                toggleBtn.classList.toggle('btn-primary', !isHidden);
                toggleBtn.classList.toggle('btn-outline-secondary', isHidden);
            });
        }

        if (cancelBtn && dateFields && toggleBtn) {
            cancelBtn.addEventListener('click', function () {
                dateFields.style.display = 'none';
                toggleBtn.classList.replace('btn-outline-secondary', 'btn-primary');
            });
        }
    </script>

</body>

</html>
<?php mysqli_close($conn); ?>