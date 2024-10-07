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
    <h1>Publicom</h1>
    <ul class="menu">
        <li><a href="<?php echo site_url(relativePath: '/'); ?>">Accueil</a></li>
        <li><a href="<?php echo site_url('visualisation'); ?>">Visualisation</a></li>
        <li><a href="<?php echo site_url('create'); ?>">Création</a></li>
        <li><a href="<?php echo site_url('login'); ?>">Connexion</a></li>
    </ul>  
    <h2>Création de l'évènement</h2>
    <div class="container">
        
        <div class="form-group">
            <label for="titre">Titre</label>
            <input type="text" id="titre" placeholder="Rentrez le titre ici">
        </div>
        
        <div class="form-group">
            <label for="description">Description évènement</label>
            <textarea id="description" placeholder="Description ici"></textarea>
        </div>
        
        <div class="button-container">
            <button>Créer</button>
        </div>
    </div>

<script>
    function createMessage() {
        const titre = document.getElementById('titre').value;
        const description = document.getElementById('description').value;
        

        fetch('/createMessage', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ titre, description })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Evènement créé avec succès');
                window.location.href = '/';
            } else {
                alert('Erreur lors de la création de l\'évènement');
            }
<<<<<<< HEAD

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
        }
    </script>
</body>
=======
        })
        .catch(error => {
            alert('Erreur lors de la création de l\'évènement');
        });
    }
</script>
<body>
>>>>>>> daa619faee41b40dae27636f901ec9eaaab97725
</html>