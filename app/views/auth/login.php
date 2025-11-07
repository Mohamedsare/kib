<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - KIB Admin</title>
    <link rel="stylesheet" href="<?= AssetHelper::asset('css/admin.css') ?>">
</head>
<body class="auth-page">
    <div class="login-container">
        <div class="login-box">
            <div class="login-header">
                <h1>KIB Admin</h1>
                <p>Connexion à l'espace d'administration</p>
            </div>
            
            <?php if (Session::has('error')): ?>
                <div class="alert alert-error">
                    <?= Session::get('error') ?>
                </div>
                <?php Session::remove('error'); ?>
            <?php endif; ?>
            
            <form method="POST" action="<?= AssetHelper::getBasePath() ?>/login" class="login-form">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required autofocus>
                </div>
                
                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" id="password" name="password" required>
                </div>
                
                <button type="submit" class="btn btn-primary btn-block">Se connecter</button>
            </form>
        </div>
    </div>
</body>
</html>
