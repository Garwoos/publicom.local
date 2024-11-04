<?php
$session = session();

if (!$session->has('user')) {
    header("Location: /login");
    exit();
} else {
    $user = $session->get('user');
}
?>

<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
    <link rel="stylesheet" href="<?php echo base_url('css/styleCreate.css'); ?>">
    <h2>Visualisation de l'évènement</h2>

    <div class="container">
        <div class="form-group">
            <label for="titre">Titre</label>
            <input type="text" id="titre" value="<?= $message['Title'] ?>" readonly>
        </div>

        <div class="form-group">
            <label for="description" class="move-up">Description évènement</label>
            <textarea id="description" readonly><?= $message['Text'] ?></textarea>
        </div>
    </div>
<?= $this->endSection() ?>
</body>
</html>