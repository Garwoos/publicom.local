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
    <link rel="stylesheet" href="<?php echo base_url('css/styleVisu.css'); ?>">
    <h2>Visualisation de l'évènement</h2>

    <div class="container-wrapper">

        <div class="containerUn">
            <div class="form-group">
                <p id="titre" ><?= htmlspecialchars(string: $message['Title']) ?></p>
            </div>

            <div class="form-group">
                <p id="description"><?= htmlspecialchars(string: $message['Text']) ?></p>
            </div>
        </div>

    </div>
<?= $this->endSection() ?>
</body>
</html>