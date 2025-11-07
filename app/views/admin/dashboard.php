<div class="stats-grid" id="statsGrid">
    <div class="stat-card">
        <h3>Messages non lus</h3>
        <div class="stat-value" id="unreadMessages"><?= $stats['unread_messages'] ?? 0 ?></div>
    </div>
    
    <div class="stat-card">
        <h3>Devis en attente</h3>
        <div class="stat-value" id="pendingQuotes"><?= $stats['pending_quotes'] ?? 0 ?></div>
    </div>
    
    <div class="stat-card">
        <h3>Services actifs</h3>
        <div class="stat-value" id="activeServices"><?= $stats['total_services'] ?? 0 ?></div>
    </div>
    
    <div class="stat-card">
        <h3>Réalisations</h3>
        <div class="stat-value" id="totalRealizations"><?= $stats['total_realizations'] ?? 0 ?></div>
    </div>
    
    <div class="stat-card">
        <h3>Vues aujourd'hui</h3>
        <div class="stat-value" id="todayViews"><?= $stats['today_views'] ?? 0 ?></div>
    </div>
    
    <div class="stat-card">
        <h3>Utilisateurs en ligne</h3>
        <div class="stat-value" id="usersOnline"><?= $stats['users_online'] ?? 0 ?></div>
    </div>
</div>

<div style="margin-top: 2rem;">
    <h2>Activité récente</h2>
    <div id="recentActivity" class="table">
        <table>
            <thead>
                <tr>
                    <th>Action</th>
                    <th>Date</th>
                    <th>Utilisateur</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="3" style="text-align: center;">Chargement...</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script>
fetch('/api/admin/dashboard')
    .then(r => r.json())
    .then(data => {
        console.log('Dashboard data:', data);
    });
</script>
