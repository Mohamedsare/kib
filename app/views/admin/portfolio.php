<?php
$title = 'Gestion du Portfolio - KIB Admin';
$pageTitle = 'Portfolio';
$active = 'portfolio';
ob_start();
?>

<div class="page-header">
    <h2>Réalisations</h2>
    <button class="btn btn-primary" onclick="showAddRealizationModal()">+ Nouvelle réalisation</button>
</div>

<div class="table">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Titre</th>
                <th>Catégorie</th>
                <th>Client</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="portfolioList">
            <tr>
                <td colspan="5" style="text-align: center; padding: 2rem;">
                    Chargement...
                </td>
            </tr>
        </tbody>
    </table>
</div>

<!-- Modal pour ajouter/modifier une réalisation -->
<div id="realizationModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background: white; padding: 2rem; border-radius: 8px; max-width: 700px; width: 90%; max-height: 90vh; overflow-y: auto;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h3 id="modalTitle">Nouvelle réalisation</h3>
            <button onclick="closeModal()" style="background: none; border: none; font-size: 1.5rem; cursor: pointer;">&times;</button>
        </div>
        <form id="realizationForm">
            <input type="hidden" id="realizationId" name="id">
            
            <div style="margin-bottom: 1rem;">
                <label>Titre *</label>
                <input type="text" id="realizationTitle" name="title" required style="width: 100%; padding: 0.5rem; border: 1px solid #e2e8f0; border-radius: 6px;">
            </div>
            
            <div style="margin-bottom: 1rem;">
                <label>Description</label>
                <textarea id="realizationDescription" name="description" rows="3" style="width: 100%; padding: 0.5rem; border: 1px solid #e2e8f0; border-radius: 6px;"></textarea>
            </div>
            
            <div style="margin-bottom: 1rem;">
                <label>Client</label>
                <input type="text" id="clientName" name="client_name" style="width: 100%; padding: 0.5rem; border: 1px solid #e2e8f0; border-radius: 6px;">
            </div>
            
            <div style="margin-bottom: 1rem;">
                <label>Images *</label>
                <input type="file" id="realizationImages" name="images[]" multiple accept="image/*" style="width: 100%; padding: 0.5rem; border: 1px solid #e2e8f0; border-radius: 6px;">
                <p style="font-size: 0.75rem; color: #64748b; margin-top: 0.25rem;">Vous pouvez sélectionner plusieurs images</p>
                <div id="imagePreview" style="margin-top: 1rem; display: flex; flex-wrap: wrap; gap: 0.5rem;"></div>
            </div>
            
            <div style="margin-bottom: 1rem;">
                <label>
                    <input type="checkbox" id="featured" name="featured" value="1">
                    Mettre en avant
                </label>
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
let currentRealizationId = null;

// Afficher le modal
function showAddRealizationModal() {
    currentRealizationId = null;
    document.getElementById('realizationId').value = '';
    document.getElementById('realizationTitle').value = '';
    document.getElementById('realizationDescription').value = '';
    document.getElementById('clientName').value = '';
    document.getElementById('featured').checked = false;
    document.getElementById('realizationImages').value = '';
    document.getElementById('imagePreview').innerHTML = '';
    document.getElementById('modalTitle').textContent = 'Nouvelle réalisation';
    document.getElementById('realizationModal').style.display = 'flex';
}

// Afficher les prévisualisations d'images
document.getElementById('realizationImages').addEventListener('change', function(e) {
    const preview = document.getElementById('imagePreview');
    preview.innerHTML = '';
    
    Array.from(e.target.files).forEach(file => {
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(event) {
                const img = document.createElement('img');
                img.src = event.target.result;
                img.style.width = '100px';
                img.style.height = '100px';
                img.style.objectFit = 'cover';
                img.style.borderRadius = '4px';
                preview.appendChild(img);
            };
            reader.readAsDataURL(file);
        }
    });
});

// Envoyer le formulaire
document.getElementById('realizationForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const formData = new FormData();
    formData.append('title', document.getElementById('realizationTitle').value);
    formData.append('description', document.getElementById('realizationDescription').value);
    formData.append('client_name', document.getElementById('clientName').value);
    formData.append('featured', document.getElementById('featured').checked ? '1' : '0');
    
    const files = document.getElementById('realizationImages').files;
    for (let i = 0; i < files.length; i++) {
        formData.append('images[]', files[i]);
    }
    
    try {
        const url = currentRealizationId 
            ? `${window.APP_BASE_PATH}/api/admin/portfolio/${currentRealizationId}`
            : `${window.APP_BASE_PATH}/api/admin/portfolio`;
        
        const response = await fetch(url, {
            method: currentRealizationId ? 'PUT' : 'POST',
            body: formData
        });
        
        if (response.ok) {
            alert('Réalisation enregistrée avec succès !');
            location.reload();
        } else {
            const data = await response.json();
            alert('Erreur : ' + (data.error || 'Une erreur est survenue'));
        }
    } catch (error) {
        alert('Une erreur est survenue');
    }
});

// Fermer le modal
function closeModal() {
    document.getElementById('realizationModal').style.display = 'none';
}

// Éditer une réalisation
function editRealization(id) {
    // Charger les données de la réalisation
    fetch(`${window.APP_BASE_PATH}/api/admin/portfolio`)
        .then(r => r.json())
        .then(data => {
            const item = data.find(r => r.id == id);
            if (item) {
                currentRealizationId = id;
                document.getElementById('realizationId').value = id;
                document.getElementById('realizationTitle').value = item.title || '';
                document.getElementById('realizationDescription').value = item.description || '';
                document.getElementById('clientName').value = item.client_name || '';
                document.getElementById('featured').checked = item.featured == 1;
                document.getElementById('modalTitle').textContent = 'Modifier la réalisation';
                document.getElementById('realizationModal').style.display = 'flex';
            }
        });
}

// Supprimer une réalisation
function deleteRealization(id) {
    if (!confirm('Voulez-vous vraiment supprimer cette réalisation ?')) return;
    
    fetch(`${window.APP_BASE_PATH}/api/admin/portfolio/${id}`, {
        method: 'DELETE',
        headers: { 'Content-Type': 'application/json' }
    })
    .then(() => {
        alert('Réalisation supprimée avec succès !');
        location.reload();
    })
    .catch(error => {
        alert('Erreur lors de la suppression');
    });
}

// Charger les réalisations
fetch(window.APP_BASE_PATH + '/api/admin/portfolio')
    .then(r => r.json())
    .then(data => {
        const tbody = document.getElementById('portfolioList');
        if (data.length === 0) {
            tbody.innerHTML = '<tr><td colspan="5" style="text-align: center;">Aucune réalisation</td></tr>';
            return;
        }
        
        tbody.innerHTML = data.map(item => `
            <tr>
                <td>${item.id}</td>
                <td>${item.title || '-'}</td>
                <td>${item.category_name || '-'}</td>
                <td>${item.client_name || '-'}</td>
                <td>
                    <button onclick="editRealization(${item.id})" class="btn btn-success btn-sm" title="Modifier">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button onclick="deleteRealization(${item.id})" class="btn btn-danger btn-sm" title="Supprimer">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        `).join('');
    });
</script>
