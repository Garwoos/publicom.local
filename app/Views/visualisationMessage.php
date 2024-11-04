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
                <input type="text" id="titre" value="<?= $message['Title'] ?>" readonly>
            </div>

            <div class="form-group">
                <textarea id="description" readonly><?= $message['Text'] ?></textarea>
            </div>
        </div>
        <div class="containerDeux">
            <div class="form-group">
                <input type="text" id="titre" value="<?= $message['Title'] ?>" readonly>
            </div>

            <div class="form-group">
                <textarea id="description" readonly><?= $message['Text'] ?></textarea>
            </div>
        </div>

    </div>
<?= $this->endSection() ?>
</body>
</html>