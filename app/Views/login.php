<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo base_url('../public/css/styleConnexion.css'); ?>">
    <title>Connexion</title>
</head>
<body>
    <h1>Publicom</h1>
    <ul class="menu">
        <li><a href="<?php echo site_url(relativePath: '/'); ?>">Accueil</a></li>
        <li><a href="<?php echo site_url('visualisation'); ?>">Visualisation</a></li>
        <li><a href="<?php echo site_url('create'); ?>">Création</a></li>
        <li><a href="<?php echo site_url('login'); ?>">Connexion</a></li>
    </ul>  
    <h2>Connexion</h2>
    <div class="formulaire">
        <form method="post" id="loginForm">
            <label for="email">Adresse Mail :</label><br>
            <input type="email" id="email" name="email" required><br><br>
            <label for="password">Mot de passe :</label><br>
            <input type="password" id="password" name="password" required><br><br>
            <button type="submit">Se Connecter</button>
        </form>
    </div>
    <p id="error-message" style="color: red;"></p> <!-- Ajout pour les messages d'erreur -->
</body>

<script>
    const form = document.querySelector('#loginForm');
    const errorMessage = document.getElementById('error-message');
    
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        
        try {
            const response = await fetch('/loginUser', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ email, password })
            });
            
            const data = await response.json();
            
            if (response.ok) {
                // Rediriger vers une page après connexion réussie
                window.location.href = '/';
            } else {
                // Afficher le message d'erreur
                errorMessage.textContent = data.message || 'Connexion échouée. Vérifiez vos informations.';
            }
        } catch (error) {
            errorMessage.textContent = 'Erreur lors de la connexion. Veuillez réessayer plus tard.';
        }
    });
</script>
</html>
