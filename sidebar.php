<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
       /* ============================================================
   sidebar.css
   Shared sidebar styling — link this once in <head> on every
   admin page:
       <link rel="stylesheet" href="sidebar.css">
   ============================================================ */

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

/* Highlights the link matching the current page */
.sidebar a.active-link {
    background: rgba(255, 255, 255, 0.3);
    font-weight: 600;
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

.submenu a.active-link {
    background: #e7edff;
    color: #2b4dbf;
    font-weight: 600;
}

.submenu.show {
    display: block;
}

.rotate {
    transform: rotate(90deg);
    transition: 0.3s;
}

.account {
    border: 1px solid white;
    border-radius: 10px;
    background: rgba(255, 255, 255, 0.2);
}

.account:hover {
    background: rgba(255, 255, 255, 0.4);
}

/* Pushes main content right so it doesn't sit under the sidebar.
   Apply .main to your page's content wrapper. */
.main {
    margin-left: 260px;
    padding: 20px;
}

/* ============================================================
   MOBILE TOPBAR + TOGGLE
   ------------------------------------------------------------
   Hidden on desktop. On small screens this becomes the fixed
   header row holding the toggle button and the E-BANKING logo
   side-by-side — they never overlap.
   ============================================================ */
.mobile-topbar {
    display: none;
}

.mobile-toggle {
    width: 42px;
    height: 42px;
    flex-shrink: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    background: rgba(255, 255, 255, 0.18);
    color: #fff;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 1.2rem;
    transition: background 0.2s ease;
}

.mobile-toggle:hover {
    background: rgba(255, 255, 255, 0.3);
}

.mobile-brand {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #fff;
    text-decoration: none;
    font-weight: 700;
    font-size: 1.05rem;
    letter-spacing: 0.5px;
    white-space: nowrap;
}

@media (max-width: 768px) {

    /* Sidebar becomes an off-canvas drawer */
    .sidebar {
        left: -280px;
        width: 260px;
        transition: left 0.3s ease;
        z-index: 1050;
        padding-top: 20px;
    }

    .sidebar.show {
        left: 0;
    }

    /* Hide the desktop logo inside the sidebar on mobile —
       the mobile-topbar shows it instead, so it's never duplicated
       or overlapped by the toggle button. */
    .sidebar-brand {
        display: none;
    }

    .main {
        margin-left: 0;
        padding-top: 78px; /* room for the fixed topbar */
    }

    .mobile-topbar {
        display: flex;
        align-items: center;
        gap: 14px;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        height: 58px;
        background: linear-gradient(90deg, #3b6ef5, #2b4dbf);
        padding: 0 16px;
        z-index: 1100;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
    }

    /* Dark overlay behind the drawer when it's open */
    .sidebar-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.35);
        z-index: 1040;
    }

    .sidebar-overlay.show {
        display: block;
    }
}
    </style>
</head>

<body>
<?php
/* ============================================================
   user_sidebar.php
   ------------------------------------------------------------
   Reusable USER-side sidebar (separate from the admin sidebar).
   Include once on every user-facing page:

       <?php include 'user_sidebar.php'; ?>

   Requires sidebar.css and sidebar.js to be linked/included on
   the page — same shared files used by the admin sidebar.
   ============================================================ */

$currentPage = basename($_SERVER['PHP_SELF']);

$payeePages = ['all_payee.php', 'manage_payee.php'];
$payeeOpen  = in_array($currentPage, $payeePages, true);

if (!function_exists('activeClass')) {
    function activeClass($page, $currentPage) {
        return $page === $currentPage ? ' active-link' : '';
    }
}
?>
<!-- MOBILE TOPBAR -->
<div class="mobile-topbar">
    <button class="mobile-toggle" id="sidebarToggleBtn" onclick="toggleSidebar()" aria-label="Toggle menu">
        <i class="bi bi-list" id="sidebarToggleIcon"></i>
    </button>
    <a href="User_dashboard.php" class="mobile-brand">
        <i class="bi bi-bank"></i> E-BANKING
    </a>
</div>

<div class="sidebar" id="sidebar">

    <a href="User_dashboard.php" class="sidebar-brand">
        <h4 class="mb-4"><i class="bi bi-bank"></i> E-BANKING</h4>
    </a>

    <a class="account mt-2<?php echo activeClass('User_dashboard.php', $currentPage); ?>" href="User_dashboard.php">
        <i class="bi bi-speedometer2 me-2"></i> Dashboard
    </a>

    <a class="<?php echo activeClass('user_acc_form.php', $currentPage); ?>" href="user_acc_form.php">
        <i class="bi bi-person-plus me-2"></i> Account Opening
    </a>

    <!-- PAYEE / BENEFICIARY -->
    <div>
        <div class="menu-toggle" onclick="toggleMenu('payeeMenu','payeeArrow')">
            <span><i class="bi bi-people-fill me-2"></i> Payee / Beneficiary</span>
            <i id="payeeArrow" class="bi bi-chevron-right<?php echo $payeeOpen ? ' rotate' : ''; ?>"></i>
        </div>

        <div id="payeeMenu" class="submenu<?php echo $payeeOpen ? ' show' : ''; ?>">
            <a href="all_payee.php" class="<?php echo activeClass('all_payee.php', $currentPage); ?>">All Payee</a>
            <a href="manage_payee.php" class="<?php echo activeClass('manage_payee.php', $currentPage); ?>">Manage Payee</a>
        </div>
    </div>

    <a class="<?php echo activeClass('Transaction_history.php', $currentPage); ?>" href="Transaction_history.php">
        <i class="bi bi-clock-history me-2"></i> Transaction History
    </a>

    <a class="<?php echo activeClass('report.php', $currentPage); ?>" href="report.php">
        <i class="bi bi-file-earmark-text me-2"></i> Report
    </a>

</div>

<!-- Overlay shown behind the sidebar drawer on mobile; tapping it closes the menu -->
<div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

    <!-- JS Runtimes -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
      /* ============================================================
   sidebar.js
   Shared sidebar toggle behavior — link this once before
   </body> on every admin page:
       <script src="sidebar.js">
   ============================================================ */

function toggleMenu(menuId, arrowId) {
    let menu = document.getElementById(menuId);
    let arrow = document.getElementById(arrowId);

    menu.classList.toggle("show");
    arrow.classList.toggle("rotate");
}

/* ============================================================
   MOBILE SIDEBAR DRAWER
   Opens/closes the off-canvas sidebar and swaps the toggle
   button icon between hamburger (☰) and cross (✕).
   ============================================================ */
function toggleSidebar() {
    const sidebar = document.getElementById("sidebar");
    const overlay = document.getElementById("sidebarOverlay");
    const icon = document.getElementById("sidebarToggleIcon");

    const isOpen = sidebar.classList.toggle("show");
    overlay.classList.toggle("show", isOpen);

    if (isOpen) {
        icon.classList.remove("bi-list");
        icon.classList.add("bi-x-lg");
    } else {
        icon.classList.remove("bi-x-lg");
        icon.classList.add("bi-list");
    }
}

function closeSidebar() {
    const sidebar = document.getElementById("sidebar");
    const overlay = document.getElementById("sidebarOverlay");
    const icon = document.getElementById("sidebarToggleIcon");

    sidebar.classList.remove("show");
    overlay.classList.remove("show");
    icon.classList.remove("bi-x-lg");
    icon.classList.add("bi-list");
}

/* Auto-close the drawer when a sidebar link is tapped on mobile,
   so the menu doesn't stay open after navigating. */
document.addEventListener("DOMContentLoaded", function () {
    const sidebar = document.getElementById("sidebar");
    if (!sidebar) return;

    sidebar.querySelectorAll("a[href]:not([href='#'])").forEach(function (link) {
        link.addEventListener("click", function () {
            if (window.innerWidth <= 768) {
                closeSidebar();
            }
        });
    });
});
    </script>

</body>

</html>