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
</div>
<script>
function navigateMessage(direction) {
    const currentId = <?= json_encode($message['idMessage']) ?>;
    if (!currentId) {
        alert('Current message ID is missing.');
        return;
    }

    // Sauvegarder la position de défilement actuelle
    const scrollPosition = window.scrollY || document.documentElement.scrollTop;
    localStorage.setItem('scrollPosition', scrollPosition);

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

// Restaurer la position de défilement après le chargement de la page
window.onload = function() {
    const scrollPosition = localStorage.getItem('scrollPosition');
    if (scrollPosition !== null) {
        window.scrollTo(0, parseInt(scrollPosition, 10));
        localStorage.removeItem('scrollPosition'); // Supprimer la position sauvegardée après restauration
    }
};
</script>

<?= $this->endSection() ?>
</body>
</html>