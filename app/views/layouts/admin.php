<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'KIB Admin' ?></title>
    <link rel="stylesheet" href="<?= AssetHelper::asset('css/admin.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
    window.APP_BASE_PATH = '<?= AssetHelper::getBasePath() ?>';
    </script>
    <style>
    body {
        margin: 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .admin-container {
        display: flex;
        min-height: 100vh;
    }

    .admin-sidebar {
        width: 250px;
        background: #3B82F6;
        color: white;
        position: fixed;
        height: 100vh;
        overflow-y: auto;
        transition: all 0.3s ease;
        z-index: 1000;
        transform: translateX(-100%);
    }

    .admin-sidebar.open {
        transform: translateX(0);
    }

    .admin-sidebar.collapsed {
        width: 70px;
    }

    .admin-sidebar.collapsed .sidebar-text {
        display: none;
    }

    .sidebar-toggle {
        position: fixed;
        top: 1rem;
        left: 1rem;
        z-index: 1001;
        background: #3B82F6;
        border: none;
        padding: 0.75rem 1rem;
        border-radius: 8px;
        cursor: pointer;
        font-size: 1.5rem;
        color: white;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .sidebar-toggle:hover {
        background: #2563EB;
        transform: scale(1.05);
    }

    .admin-sidebar.collapsed.open {
        transform: translateX(0);
    }

    .sidebar-icon {
        min-width: 30px;
        text-align: center;
        display: inline-block;
    }

    .admin-content {
        width: 100%;
        padding: 1rem;
        margin-left: 0;
        transition: all 0.3s ease;
    }

    .sidebar-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 999;
    }

    .sidebar-overlay.active {
        display: block;
    }

    .admin-header {
        background: white;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        padding: 1.5rem 2rem;
        margin-bottom: 2rem;
        border-radius: 8px;
    }

    .admin-header-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
    }

    .admin-header-title {
        flex: 1;
    }

    .admin-header-greeting {
        flex-shrink: 0;
        margin-left: 2rem;
    }

    .admin-header h1 {
        margin: 0;
        color: #1e293b;
        font-size: 1.75rem;
        font-weight: 600;
    }

    .admin-header .user-greeting {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #64748b;
        font-size: 0.875rem;
        margin: 0;
    }

    .admin-header .user-greeting svg {
        width: 32px;
        height: 32px;
        flex-shrink: 0;
    }

    .sidebar-logo {
        padding: 1.5rem;
        border-bottom: 1px solid #334155;
    }

    .sidebar-logo h2 {
        margin: 0;
        font-size: 1.25rem;
    }

    .sidebar-menu {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .sidebar-menu li a {
        display: block;
        padding: 1rem 1.5rem;
        color: rgba(255, 255, 255, 0.7);
        text-decoration: none;
        transition: all 0.3s;
    }

    .sidebar-menu li a:hover,
    .sidebar-menu li a.active {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        color: white;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: white;
        padding: 1.5rem;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .stat-card h3 {
        color: #64748b;
        font-size: 0.875rem;
        margin: 0 0 0.5rem 0;
    }

    .stat-value {
        font-size: 2rem;
        font-weight: 700;
        color: #1e293b;
    }

    .table {
        background: white;
        border-radius: 8px;
        overflow-x: auto;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        -webkit-overflow-scrolling: touch;
    }

    .table table {
        width: 100%;
        border-collapse: collapse;
        margin: 0;
    }

    .table th {
        background: #f8fafc;
        padding: 1rem 0.75rem;
        text-align: left;
        font-weight: 600;
        color: #64748b;
        white-space: nowrap;
        min-width: 100px;
    }

    .table td {
        padding: 1rem 0.75rem;
        border-top: 1px solid #e2e8f0;
        white-space: nowrap;
        min-width: 100px;
    }

    .table td:last-child,
    .table th:last-child {
        min-width: 120px;
        text-align: center;
    }

    .btn {
        padding: 0.5rem 1rem;
        border-radius: 6px;
        text-decoration: none;
        display: inline-block;
        font-size: 0.875rem;
        font-weight: 500;
        cursor: pointer;
        border: none;
    }

    .btn-primary {
        background: #3B82F6;
        color: white;
    }

    .btn-primary:hover {
        background: #2563EB;
    }

    .btn-success {
        background: #10b981;
        color: white;
    }

    .btn-danger {
        background: #ef4444;
        color: white;
    }

    .btn-sm {
        padding: 0.25rem 0.75rem;
        font-size: 0.75rem;
    }

    /* Mobile First - Responsive */
    @media (min-width: 640px) {
        .admin-sidebar {
            transform: translateX(0);
        }

        .sidebar-toggle {
            display: none;
        }

        .admin-content {
            margin-left: 250px;
            padding: 2rem;
        }

        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (min-width: 768px) {
        .stats-grid {
            grid-template-columns: repeat(3, 1fr);
        }

        .admin-sidebar.collapsed~.admin-content {
            margin-left: 70px;
        }
    }

    @media (min-width: 1024px) {
        .stats-grid {
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        }
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }

    @media (max-width: 639px) {
        .page-header {
            flex-direction: column;
            gap: 1rem;
            align-items: stretch;
        }

        .page-header button {
            width: 100%;
        }

        .admin-header {
            padding: 1rem;
        }

        .admin-header h1 {
            font-size: 1.5rem;
        }

        .admin-header-container {
            flex-direction: column;
            align-items: flex-start;
        }

        .admin-header-greeting {
            margin-left: 0;
            margin-top: 0.5rem;
        }

        .admin-header .user-greeting {
            font-size: 0.8rem;
        }

        .admin-header .user-greeting svg {
            width: 24px;
            height: 24px;
        }

        .table {
            display: block;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .table table {
            min-width: 700px;
            width: max-content;
        }

        .table .btn-sm {
            padding: 0.5rem;
        }
    }
    </style>
</head>

<body>
    <button class="sidebar-toggle" onclick="toggleSidebar()">
        <i class="fas fa-bars" id="menuIcon"></i>
    </button>

    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <div class="admin-container">
        <!-- Sidebar -->
        <aside class="admin-sidebar" id="adminSidebar">
            <div class="sidebar-logo">
                <span class="sidebar-icon"><i class="fas fa-chart-line"></i></span>
                <span class="sidebar-text">
                    <h2>KIB Admin</h2>
                </span>
            </div>
            <ul class="sidebar-menu">
                <li><a href="<?= AssetHelper::getBasePath() ?>/admin/dashboard"
                        class="<?= $active === 'dashboard' ? 'active' : '' ?>">
                        <span class="sidebar-icon"><i class="fas fa-tachometer-alt"></i></span>
                        <span class="sidebar-text">Dashboard</span>
                    </a></li>
                <li><a href="<?= AssetHelper::getBasePath() ?>/admin/services"
                        class="<?= $active === 'services' ? 'active' : '' ?>">
                        <span class="sidebar-icon"><i class="fas fa-bullseye"></i></span>
                        <span class="sidebar-text">Services</span>
                    </a></li>
                <li><a href="<?= AssetHelper::getBasePath() ?>/admin/portfolio"
                        class="<?= $active === 'portfolio' ? 'active' : '' ?>">
                        <span class="sidebar-icon"><i class="fas fa-images"></i></span>
                        <span class="sidebar-text">Portfolio</span>
                    </a></li>
                <li><a href="<?= AssetHelper::getBasePath() ?>/admin/messages"
                        class="<?= $active === 'messages' ? 'active' : '' ?>">
                        <span class="sidebar-icon"><i class="fas fa-envelope"></i></span>
                        <span class="sidebar-text">Messages</span>
                    </a></li>
                <li><a href="<?= AssetHelper::getBasePath() ?>/admin/analytics"
                        class="<?= $active === 'analytics' ? 'active' : '' ?>">
                        <span class="sidebar-icon"><i class="fas fa-chart-bar"></i></span>
                        <span class="sidebar-text">Analytics</span>
                    </a></li>
                <?php if (Auth::isAdmin()): ?>
                <li><a href="<?= AssetHelper::getBasePath() ?>/admin/settings"
                        class="<?= $active === 'settings' ? 'active' : '' ?>">
                        <span class="sidebar-icon"><i class="fas fa-cog"></i></span>
                        <span class="sidebar-text">Paramètres</span>
                    </a></li>
                <?php endif; ?>
                <li><a href="<?= AssetHelper::getBasePath() ?>/logout">
                        <span class="sidebar-icon"><i class="fas fa-sign-out-alt"></i></span>
                        <span class="sidebar-text">Déconnexion</span>
                    </a></li>
            </ul>
        </aside>

        <!-- Main Content -->
        <div class="admin-content">
            <div class="admin-header">
                <div class="admin-header-container">
                    <div class="admin-header-title">
                        <h1><?= $pageTitle ?? 'Administration' ?></h1>
                    </div>
                    <div class="admin-header-greeting user-greeting">
                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="16" cy="16" r="16" fill="#3B82F6" />
                            <circle cx="16" cy="12" r="5" fill="white" />
                            <path d="M6 26c0-5.5 4.5-10 10-10s10 4.5 10 10" fill="white" />
                        </svg>
                        <span>Bonjour, <?= htmlspecialchars($user['name'] ?? 'Admin') ?></span>
                    </div>
                </div>
            </div>

            <?= $content ?? '' ?>
        </div>
    </div>

    <script>
    function toggleSidebar() {
        const sidebar = document.getElementById('adminSidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const icon = document.getElementById('menuIcon');

        sidebar.classList.toggle('open');
        overlay.classList.toggle('active');

        // Changer l'icône
        if (sidebar.classList.contains('open')) {
            icon.className = 'fas fa-times';
        } else {
            icon.className = 'fas fa-bars';
        }
    }

    // Auto-close sidebar on mobile when clicking outside
    if (window.innerWidth < 640) {
        const sidebar = document.getElementById('adminSidebar');
        const overlay = document.getElementById('sidebarOverlay');

        // Close sidebar when clicking outside on mobile
        overlay.addEventListener('click', function() {
            sidebar.classList.remove('open');
            overlay.classList.remove('active');
            document.getElementById('menuIcon').className = 'fas fa-bars';
        });
    }
    </script>
</body>

</html>