<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
    <link rel="stylesheet" href="<?php echo base_url('css/styleConnexion.css'); ?>">
    <h2>Connexion</h2>
    <div class="formulaire">
        <form method="post" id="loginForm">
            <label for="email">Adresse Mail :</label><br>
            <input type="email" id="email" name="email" required  placeholder="Adresse mail ici"><br><br>
            <label for="password ">Mot de passe :</label><br>
            <input type="password" id="password" name="password" required placeholder="Mot de passe ici"><br><br>
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
<?= $this->endSection() ?>
</html>
