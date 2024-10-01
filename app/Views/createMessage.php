<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: /login');
    exit;
}

$_SESSION['user_email'] = $user_email; // Stocker l'email de l'utilisateur dans la session

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création de l'évènement</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f9f9f9;
        }
        .container {
            width: 60%;
            border: 2px solid #000;
            padding: 20px;
            background-color: #fff;
        }
        h1 {
            text-align: center;
        }
        .form-group {
            display: flex;
            margin-bottom: 20px;
            align-items: center;
        }
        .form-group label {
            width: 200px;
            font-weight: bold;
        }
        .form-group input[type="text"],
        .form-group textarea {
            flex: 1;
            padding: 10px;
            border: 1px solid #000;
        }
        textarea {
            height: 200px;
            resize: none;
        }
        .button-container {
            text-align: right;
            margin-top: 20px;
        }
        .button-container button {
            padding: 10px 20px;
            font-size: 16px;
            border: 2px solid #000;
            background-color: #e0e0e0;
            cursor: pointer;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Création de l'évènement</h1>
        

        <?php
            session_start();
            $user_email = isset($_SESSION['user_email']) ? $_SESSION['user_email'] : '';
        ?>
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
    const userEmail = '<?php echo $user_email; ?>';
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
        })
        .catch(error => {
            alert('Erreur lors de la création de l\'évènement');
        });
    }
</script>
<body>
</html>