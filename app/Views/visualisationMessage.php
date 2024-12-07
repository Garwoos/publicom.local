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
    <button class="nav-button prev-button" onclick="navigateMessage('prev')"><span class="arrow">&larr;</span></button>
    <div class="containerUn">
        <div class="form-group">
            <p id="titre"><?= htmlspecialchars($message['Title']) ?></p>
        </div>

        <div class="form-group">
            <p id="description"><?= htmlspecialchars($message['Text']) ?></p>
        </div>
    </div>
    <button class="nav-button next-button" onclick="navigateMessage('next')"><span class="arrow">&rarr;</span></button>
    <input type="hidden" id="currentEventId" value="<?= htmlspecialchars($message['idMessage']) ?>">
</div>

<script>
function navigateMessage(direction) {
    const currentEventId = document.getElementById('currentEventId').value;

    fetch(`/navigateEvent?direction=${direction}&currentEventId=${currentEventId}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('titre').innerText = data.Title;
            document.getElementById('description').innerText = data.Text;
            document.getElementById('currentEventId').value = data.idMessage;
        })
        .catch(error => console.error('Error:', error));
}
</script>
<?= $this->endSection() ?>
</body>
</html>