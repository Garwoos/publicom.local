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

// Initialisation des variables
$messageId = isset($messageId) ? $messageId : '';
$messageTitle = isset($messageTitle) ? $messageTitle : '';
$messageDescription = isset($messageDescription) ? $messageDescription : '';
$image = isset($image) ? $image : '';
$fontTitle = isset($fontTitle) ? $fontTitle : '';
$sizeTitle = isset($sizeTitle) ? $sizeTitle : '';
$fontText = isset($fontText) ? $fontText : '';
$sizeText = isset($sizeText) ? $sizeText : '';
$alignmentText = isset($alignmentText) ? $alignmentText : '';

// Options pour les polices
$fontOptions = [
    1 => 'Arial',
    2 => 'Times New Roman',
    3 => 'Verdana',
    4 => 'Georgia',
    5 => 'Courier New',
    6 => 'Comic Sans MS'
];

// Options pour l'alignement
$alignmentOptions = [
    0 => 'Gauche',
    1 => 'Centre',
    2 => 'Droite'
];
?>

<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
    <link rel="stylesheet" href="<?php echo base_url('css/styleCreate.css'); ?>">
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

        <div class="form-group">
            <label for="image">Image URL</label>
            <input type="text" id="image" placeholder="URL de l'image" value="<?php echo $image; ?>">
        </div>

        <div class="form-group">
            <label for="fontTitle">Police du titre</label>
            <select id="fontTitle">
                <?php foreach ($fontOptions as $value => $label): ?>
                    <option value="<?php echo $value; ?>" <?php echo ($fontTitle == $value) ? 'selected' : ''; ?>>
                        <?php echo $label; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="sizeTitle">Taille du titre</label>
            <input type="number" id="sizeTitle" value="<?php echo $sizeTitle; ?>">
        </div>

        <div class="form-group">
            <label for="fontText">Police du texte</label>
            <select id="fontText">
                <?php foreach ($fontOptions as $value => $label): ?>
                    <option value="<?php echo $value; ?>" <?php echo ($fontText == $value) ? 'selected' : ''; ?>>
                        <?php echo $label; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="sizeText">Taille du texte</label>
            <input type="number" id="sizeText" value="<?php echo $sizeText; ?>">
        </div>

        <div class="form-group">
            <label for="alignmentText">Alignement du texte</label>
            <select id="alignmentText">
                <?php foreach ($alignmentOptions as $value => $label): ?>
                    <option value="<?php echo $value; ?>" <?php echo ($alignmentText == $value) ? 'selected' : ''; ?>>
                        <?php echo $label; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="button-container">
            <button onclick="saveMessage()"><?php echo $messageId ? 'Modifier' : 'Créer'; ?></button>
        </div>
    </div>

    <script>
        const userEmail = '<?php echo $user_email; ?>';

        function saveMessage() {
            const titre = document.getElementById('titre').value;
            const description = document.getElementById('description').value;
            const messageId = document.getElementById('messageId').value;
            const image = document.getElementById('image').value;
            const fontTitle = document.getElementById('fontTitle').value;
            const sizeTitle = document.getElementById('sizeTitle').value;
            const fontText = document.getElementById('fontText').value;
            const sizeText = document.getElementById('sizeText').value;
            const alignmentText = document.getElementById('alignmentText').value;

            if (!titre || !description) {
                alert('Veuillez remplir tous les champs obligatoires.');
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
                    title: titre,
                    text: description,
                    mailUser: userEmail,
                    id: messageId,
                    image: image,
                    fontTitle: fontTitle,
                    sizeTitle: sizeTitle,
                    fontText: fontText,
                    sizeText: sizeText,
                    alignmentText: alignmentText
                })
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                window.location.href = '/';
            });
        }
    </script>
<?= $this->endSection() ?>
</body>
</html>
