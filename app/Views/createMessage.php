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

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="The small framework with powerful features">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo base_url('css/styleCreate.css'); ?>">
    <title>Création de l'évènement</title>
</head>
<body>
<<<<<<< HEAD

    <div class="container">
        <h1>Création de l'évènement</h1>
        
        <div class="form-group">
=======
    <h1>Publicom</h1>
    <ul class="menu">
        <li><a href="<?php echo site_url(relativePath: '/'); ?>">Accueil</a></li>
        <li><a href="<?php echo site_url('visualisation'); ?>">Visualisation</a></li>
        <li><a href="<?php echo site_url('create'); ?>">Création</a></li>
        <li><a href="<?php echo site_url('login'); ?>">Connexion</a></li>
    </ul>  
    <h2>Création de l'évènement</h2>

    <div class="container">
        

        <div class="form-group extra-margin">
>>>>>>> 229602120ce864d4516f8222dc59a72ff46c1560
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
                title : titre,        // Change 'titre' to 'title'
                text : description,   // Change 'description' to 'text'
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
<<<<<<< HEAD
            
=======

>>>>>>> 229602120ce864d4516f8222dc59a72ff46c1560
        }
    </script>
</body>
</html>