<?php
$title = 'Messages - KIB Admin';
$pageTitle = 'Messages de contact';
$active = 'messages';
ob_start();
?>

<div class="table">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Téléphone</th>
                <th>Date</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="messagesList">
            <tr>
                <td colspan="7" style="text-align: center; padding: 2rem;">
                    Chargement des messages...
                </td>
            </tr>
        </tbody>
    </table>
</div>

<script>
fetch(window.APP_BASE_PATH + '/api/admin/messages')
    .then(r => r.json())
    .then(data => {
        const tbody = document.getElementById('messagesList');
        if (data.length === 0) {
            tbody.innerHTML = '<tr><td colspan="7" style="text-align: center;">Aucun message</td></tr>';
            return;
        }
        
        tbody.innerHTML = data.map(msg => `
            <tr>
                <td>${msg.id}</td>
                <td>${msg.name}</td>
                <td>${msg.email}</td>
                <td>${msg.phone || '-'}</td>
                <td>${new Date(msg.created_at).toLocaleDateString()}</td>
                <td>${msg.status === 'new' ? '🆕 Nouveau' : 'Lu'}</td>
                <td>
                    <button onclick="viewMessage(${msg.id})" class="btn btn-success btn-sm" title="Voir">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button onclick="deleteMessage(${msg.id})" class="btn btn-danger btn-sm" title="Supprimer">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        `).join('');
    });
</script>
