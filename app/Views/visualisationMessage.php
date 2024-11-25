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
    <button onclick="navigateMessage('prev')">←</button>
    <div class="containerUn">
        <div class="form-group">
            <p id="titre"><?= htmlspecialchars($message['Title']) ?></p>
        </div>

        <div class="form-group">
            <p id="description"><?= htmlspecialchars($message['Text']) ?></p>
        </div>
    </div>
    <button onclick="navigateMessage('next')">→</button>
</div>
<script>
function navigateMessage(direction) {
    const currentId = <?= json_encode($message['idMessage']) ?>;
    if (!currentId) {
        alert('Current message ID is missing.');
        return;
    }
    fetch(`/visualisation/navigate?id=${currentId}&direction=${direction}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = `?id=${data.message.idMessage}`;
            } else {
                alert('No more messages in this direction.');
            }
        })
        .catch(error => console.error('Error:', error));
}
</script>

<?= $this->endSection() ?>
</body>
</html>