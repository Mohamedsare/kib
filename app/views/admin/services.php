<?php
$title = 'Gestion des Services - KIB Admin';
$pageTitle = 'Gestion des Services';
$active = 'services';
ob_start();
?>

<div class="page-header">
    <h2>Services</h2>
    <button class="btn btn-primary" onclick="showAddServiceModal()">
        <i class="fas fa-plus"></i> Nouveau service
    </button>
</div>

<div class="table">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Titre</th>
                <th>Catégorie</th>
                <th>Prix</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="servicesList">
            <tr>
                <td colspan="6" style="text-align: center; padding: 2rem;">
                    Chargement des services...
                </td>
            </tr>
        </tbody>
    </table>
</div>

<!-- Modal pour ajouter/modifier un service -->
<div id="serviceModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background: white; padding: 2rem; border-radius: 8px; max-width: 600px; width: 90%; max-height: 80vh; overflow-y: auto;">
        <h3 id="modalTitle">Nouveau service</h3>
        <form id="serviceForm">
            <input type="hidden" id="serviceId" name="id">
            
            <div style="margin-bottom: 1rem;">
                <label>Titre *</label>
                <input type="text" id="serviceTitle" name="title" required style="width: 100%; padding: 0.5rem; border: 1px solid #e2e8f0; border-radius: 6px;">
            </div>
            
            <div style="margin-bottom: 1rem;">
                <label>Description</label>
                <textarea id="serviceDescription" name="description" rows="4" style="width: 100%; padding: 0.5rem; border: 1px solid #e2e8f0; border-radius: 6px;"></textarea>
            </div>
            
            <div style="margin-bottom: 1rem;">
                <label>Prix de base (FCFA)</label>
                <input type="number" id="servicePrice" name="price_base" step="0.01" style="width: 100%; padding: 0.5rem; border: 1px solid #e2e8f0; border-radius: 6px;">
            </div>
            
            <div style="display: flex; gap: 1rem;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Enregistrer
                </button>
                <button type="button" class="btn" onclick="closeModal()">
                    <i class="fas fa-times"></i> Annuler
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Charger les services
fetch(window.APP_BASE_PATH + '/api/admin/services')
    .then(r => r.json())
    .then(data => {
        const tbody = document.getElementById('servicesList');
        if (data.length === 0) {
            tbody.innerHTML = '<tr><td colspan="6" style="text-align: center;">Aucun service trouvé</td></tr>';
            return;
        }
        
        tbody.innerHTML = data.map(service => `
            <tr>
                <td>${service.id}</td>
                <td>${service.title}</td>
                <td>${service.category_name || '-'}</td>
                <td>${service.price_base} FCFA</td>
                <td>${service.active ? '✅ Actif' : '❌ Inactif'}</td>
                <td>
                    <button onclick="editService(${service.id})" class="btn btn-success btn-sm" title="Modifier">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button onclick="deleteService(${service.id})" class="btn btn-danger btn-sm" title="Supprimer">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        `).join('');
    });

function showAddServiceModal() {
    document.getElementById('modalTitle').textContent = 'Nouveau service';
    document.getElementById('serviceForm').reset();
    document.getElementById('serviceModal').style.display = 'flex';
}

function editService(id) {
    fetch(window.APP_BASE_PATH + `/api/admin/services`)
        .then(r => r.json())
        .then(services => {
            const service = services.find(s => s.id === id);
            if (service) {
                document.getElementById('modalTitle').textContent = 'Modifier le service';
                document.getElementById('serviceId').value = service.id;
                document.getElementById('serviceTitle').value = service.title;
                document.getElementById('serviceDescription').value = service.description || '';
                document.getElementById('servicePrice').value = service.price_base;
                document.getElementById('serviceModal').style.display = 'flex';
            }
        });
}

function deleteService(id) {
    if (!confirm('Êtes-vous sûr de vouloir supprimer ce service ?')) return;
    
    fetch(window.APP_BASE_PATH + `/api/admin/services/${id}`, { method: 'DELETE' })
        .then(() => location.reload());
}

function closeModal() {
    document.getElementById('serviceModal').style.display = 'none';
}

document.getElementById('serviceForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const data = Object.fromEntries(formData);
    const id = document.getElementById('serviceId').value;
    
    const method = id ? 'PUT' : 'POST';
    const url = id ? window.APP_BASE_PATH + `/api/admin/services/${id}` : window.APP_BASE_PATH + '/api/admin/services';
    
    fetch(url, {
        method,
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    })
    .then(() => location.reload());
});
</script>
