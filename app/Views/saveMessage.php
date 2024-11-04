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

// Récupération des données du message si l'ID est fourni
$messageId = isset($_GET['id']) ? $_GET['id'] : '';
$messageTitle = '';
$messageDescription = '';

if ($messageId) {
    // Charger le modèle
    $messageModel = new \App\Models\MessageModel();
    $message = $messageModel->find($messageId);

    if ($message) {
        $messageTitle = $message['Title'];
        $messageDescription = $message['Text'];
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="The small framework with powerful features">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo base_url('css/styleCreate.css'); ?>">
    <title><?php echo $messageId ? 'Modification' : 'Création'; ?> de l'évènement</title>
</head>
<body>
    <h1>Publicom</h1>
    <ul class="menu">
        <li><a href="<?php echo site_url(relativePath: '/'); ?>">Accueil</a></li>
        <li><a href="<?php echo site_url('visualisation'); ?>">Visualisation</a></li>
        <li><a href="<?php echo site_url('create'); ?>">Création</a></li>
        <li><a href="<?php echo site_url('login'); ?>">Connexion</a></li>
    </ul>  
    <h2><?php echo $messageId ? 'Modification' : 'Création'; ?> de l'évènement</h2>

    <div class="container">
        <input type="hidden" id="messageId" value="<?php echo $messageId; ?>">

        <div class="form-group extra-margin">
            <label for="titre">Titre</label>
            <input type="text" id="titre" placeholder="Rentrez le titre ici" value="<?php echo $messageTitle; ?>">
        </div>

        <div class="form-group">
            <label for="description" class="move-up">Description évènement</label>
            <textarea id="description" placeholder="Description de l'évènement ici"><?php echo $messageDescription; ?></textarea>
        </div>

        <div class="button-container">
            <!-- Bouton déclenchant la fonction saveMessage() -->
            <button onclick="saveMessage()"><?php echo $messageId ? 'Modifier' : 'Créer'; ?></button>
        </div>
    </div>

    <script>
        const userEmail = '<?php echo $user_email; ?>';

        function saveMessage() {
            const titre = document.getElementById('titre').value;
            const description = document.getElementById('description').value;
            const messageId = document.getElementById('messageId').value;

            if (!titre || !description) {
                alert('Veuillez remplir tous les champs.');
                return;
            }

            const url = messageId ? '/updateMessage' : '/createMessage';
            const method = messageId ? 'PUT' : 'POST';

            fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    id: messageId,
                    title: titre,
                    text: description,
                    mailUser: userEmail
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
                alert('Erreur lors de la sauvegarde de l\'évènement. Veuillez réessayer plus tard.');
            });
        }
    </script>
</body>
</html>