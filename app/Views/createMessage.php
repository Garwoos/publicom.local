<?php
$session = session();

if (!$session->has('user')) {
    header("Location: /login");
    exit();
} else {
    $user = $session->get('user');
}

// Récupération de l'email utilisateur
$user_email = $session->get('user')['mailUser'];
?>

<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
    <link rel="stylesheet" href="<?php echo base_url('css/styleCreate.css'); ?>">
    <h2>Création de l'évènement</h2>

    <div class="container">
        
        <div class="form-group">"é"
            <label for="titre">Titre</label>
            <input type="text" id="titre" placeholder="Rentrez le titre ici">
        </div>

        <div class="form-group">
            <label for="description" class="move-up">Description évènement</label>
            <textarea id="description" placeholder="Description de l'évènement ici"></textarea>
        </div>

        <div class="button-container">
            <!-- Bouton déclenchant la fonction createMessage() -->
            <button onclick="createMessage()">Créer</button>
        </div>
    </div>

    <script>
        const userEmail = '<?php echo $user_email; ?>';

        function createMessage() {
            const titre = document.getElementById('titre').value;
            const description = document.getElementById('description').value;

            if (!titre || !description) {
                alert('Veuillez remplir tous les champs.');
                return;
            }

            fetch('/createMessage', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                title : titre,        
                text : description,   
                mailUser : userEmail
            })
            })
            .then(response => response.json())
            .then(data => {
                if (data.message) {
                    alert(data.message);
                    window.location.href = '/';
                }
            })
            .catch(error => {
                alert('Erreur lors de la création de l\'évènement. Veuillez réessayer plus tard.');
            });
            
        }
    </script>
<?= $this->endSection() ?>
</body>
</html>