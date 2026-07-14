<?php
/* ============================================================
   DATABASE CONNECTION
   ============================================================ */
$conn = mysqli_connect("localhost", "root", "", "ebankingdb");

if (!$conn) {
    die("Database Connection Failed");
}

/* ============================================================
   ASSUMED SCHEMA — RENAME IF YOUR ACTUAL TABLES/COLUMNS DIFFER
   ------------------------------------------------------------
   accounts table:
        id, status ('approved' | 'pending' | 'rejected'), balance
   cashiers table:
        id, status ('active' | 'inactive')
   payees table:
        id, account_id   (count of payees managed = count of rows)
   transactions table:
        id, amount, type ('credit' | 'debit'), created_at
   ============================================================ */

/* ---------- 1. Available Balance ----------
   Sum of balance across all approved accounts */
$availableBalance = 0;
$sql = "SELECT COALESCE(SUM(balance), 0) AS total_balance
        FROM accounts
        WHERE status = 'approved'";
$result = mysqli_query($conn, $sql);
if ($result && $row = mysqli_fetch_assoc($result)) {
    $availableBalance = $row['total_balance'];
}

/* ---------- 2. Manage Payee Count ----------
   Total number of payee records */
$payeeCount = 0;
$sql = "SELECT COUNT(*) AS total_payees FROM payees";
$result = mysqli_query($conn, $sql);
if ($result && $row = mysqli_fetch_assoc($result)) {
    $payeeCount = $row['total_payees'];
}

/* ---------- 3. Rejected Accounts Count ---------- */
$rejectedCount = 0;
$sql = "SELECT COUNT(*) AS total_rejected
        FROM accounts
        WHERE status = 'rejected'";
$result = mysqli_query($conn, $sql);
if ($result && $row = mysqli_fetch_assoc($result)) {
    $rejectedCount = $row['total_rejected'];
}

/* ---------- 4. Cashier Count ----------
   Total number of active cashiers */
$cashierCount = 0;
$sql = "SELECT COUNT(*) AS total_cashiers
        FROM cashiers
        WHERE status = 'active'";
$result = mysqli_query($conn, $sql);
if ($result && $row = mysqli_fetch_assoc($result)) {
    $cashierCount = $row['total_cashiers'];
}

/* ---------- 5. Total Amount ----------
   Sum of balance across ALL accounts (approved + pending etc.) */
$totalAmount = 0;
$sql = "SELECT COALESCE(SUM(balance), 0) AS grand_total FROM accounts";
$result = mysqli_query($conn, $sql);
if ($result && $row = mysqli_fetch_assoc($result)) {
    $totalAmount = $row['grand_total'];
}

/* ---------- Helper: format numbers for display ---------- */
function formatMoney($value) {
    return number_format((float) $value, 2);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AdminDashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="sidebar.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6fb;
        }

        /* CARDS */
        .card-box {
            height: 100%;
        }

        .card-body {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .vertical-line {
            border-left: 2px solid #ccc;
            height: 30px;
            margin: 0 5px;
        }

        .text-pink {
            color: #d6336c;
        }
    </style>
</head>

<body>

    <?php include 'sidebar.php'; ?>

    <!-- MAIN CONTENT -->
    <div class="main">

        <!-- TOP BAR -->
        <div class="d-flex justify-content-end align-items-center mb-4 gap-3">

            <button type="button" class="btn btn-light rounded-circle border-0" style="width: 40px; height: 40px; color: #495057;">
                <i class="bi bi-bell-fill"></i>
            </button>

            <div class="vertical-line"></div>

            <div class="profile-wrapper">
                <div class="d-flex align-items-center gap-2 profile-trigger">
                    <span class="fw-bold">Admin</span>
                    <img src="https://i.pravatar.cc/50" class="rounded-circle" width="35" alt="Avatar">
                </div>

                <div class="hover-card">
                </div>
            </div>
        </div>

        <!-- CARDS (now rendered with live DB values) -->
        <div class="row g-3">

            <div class="col-md-4">
                <div class="card shadow-sm card-box">
                    <div class="card-body">
                        <div>
                            <h6 class="text-success">Available Balance</h6>
                            <h3>&#8377; <?php echo formatMoney($availableBalance); ?></h3>
                        </div>
                        <i class="bi bi-currency-dollar fs-1 text-success"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm card-box">
                    <div class="card-body">
                        <div>
                            <h6 class="text-warning">Manage Payee</h6>
                            <h3><?php echo (int) $payeeCount; ?></h3>
                        </div>
                        <i class="bi bi-people-fill fs-1 text-warning"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm card-box">
                    <div class="card-body">
                        <div>
                            <h6 class="text-danger">Rejected Accounts</h6>
                            <h3><?php echo (int) $rejectedCount; ?></h3>
                        </div>
                        <i class="bi bi-x-circle fs-1 text-danger"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm card-box">
                    <div class="card-body">
                        <div>
                            <h6 class="text-primary">Cashier</h6>
                            <h3><?php echo (int) $cashierCount; ?></h3>
                        </div>
                        <i class="bi bi-person fs-1 text-primary"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm card-box">
                    <div class="card-body">
                        <div>
                            <h6 class="text-pink">Total Amount</h6>
                            <h3>&#8377; <?php echo formatMoney($totalAmount); ?></h3>
                        </div>
                        <i class="bi bi-cash fs-1 text-dark"></i>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <!-- JS -->
    <script src="sidebar.js"></script>

</body>

</html>
<?php
/* Close the database connection at the end of the script */
mysqli_close($conn);
?>