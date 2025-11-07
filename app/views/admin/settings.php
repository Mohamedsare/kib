<?php
$title = 'Paramètres - KIB Admin';
$pageTitle = 'Paramètres du site';
$active = 'settings';
ob_start();
?>

<div style="max-width: 800px;">
    <h2>Configuration du site</h2>
    
    <form id="settingsForm" style="background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Numéro WhatsApp</label>
            <input type="text" id="whatsapp" name="whatsapp_number" style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 6px;">
        </div>
        
        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Numéro de téléphone</label>
            <input type="text" id="phone" name="phone_number" style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 6px;">
        </div>
        
        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Email de contact</label>
            <input type="email" id="email" name="email" style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 6px;">
        </div>
        
        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Adresse</label>
            <input type="text" id="address" name="address" style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 6px;">
        </div>
        
        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">URL Facebook</label>
            <input type="url" id="facebook" name="facebook_url" style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 6px;">
        </div>
        
        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">URL Instagram</label>
            <input type="url" id="instagram" name="instagram_url" style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 6px;">
        </div>
        
        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>
</div>

<script>
// Charger les paramètres
fetch(window.APP_BASE_PATH + '/api/admin/settings')
    .then(r => r.json())
    .then(data => {
        document.getElementById('whatsapp').value = data.whatsapp_number || '';
        document.getElementById('phone').value = data.phone_number || '';
        document.getElementById('email').value = data.email || '';
        document.getElementById('address').value = data.address || '';
        document.getElementById('facebook').value = data.facebook_url || '';
        document.getElementById('instagram').value = data.instagram_url || '';
    });

document.getElementById('settingsForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const data = Object.fromEntries(formData);
    
    fetch(window.APP_BASE_PATH + '/api/admin/settings', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    })
    .then(() => {
        alert('Paramètres enregistrés avec succès !');
        location.reload();
    });
});
</script>
