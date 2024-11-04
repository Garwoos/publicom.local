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
    <h2>Modification de l'évènement</h2>

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
            <button onclick="modifyMessage()">Modifier</button>
        </div>
    </div>
    <?= $this->endSection() ?>
</body>
</html>