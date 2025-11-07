<?php
$title = 'Analytics - KIB Admin';
$pageTitle = 'Statistiques et Analytics';
$active = 'analytics';
ob_start();
?>

<div class="stats-grid">
    <div class="stat-card">
        <h3>Utilisateurs en ligne</h3>
        <div class="stat-value" id="onlineUsers">-</div>
    </div>
    
    <div class="stat-card">
        <h3>Pages vues aujourd'hui</h3>
        <div class="stat-value" id="todayViews">-</div>
    </div>
    
    <div class="stat-card">
        <h3>Top page</h3>
        <div class="stat-value" id="topPage">-</div>
    </div>
</div>

<h2 style="margin-top: 2rem;">Dernières pages visitées</h2>
<div class="table">
    <table>
        <thead>
            <tr>
                <th>Page</th>
                <th>Pays</th>
                <th>Ville</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody id="recentViews">
            <tr>
                <td colspan="4" style="text-align: center;">Chargement...</td>
            </tr>
        </tbody>
    </table>
</div>

<script>
fetch(window.APP_BASE_PATH + '/api/admin/analytics')
    .then(r => r.json())
    .then(data => {
        document.getElementById('onlineUsers').textContent = data.online || 0;
        
        if (data.recent_views && data.recent_views.length > 0) {
            const tbody = document.getElementById('recentViews');
            tbody.innerHTML = data.recent_views.map(view => `
                <tr>
                    <td>${view.path}</td>
                    <td>${view.country || '-'}</td>
                    <td>${view.city || '-'}</td>
                    <td>${new Date(view.created_at).toLocaleString()}</td>
                </tr>
            `).join('');
        }
    });
</script>
