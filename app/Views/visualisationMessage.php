<?php
$session = session();

if (!$session->has('user')) {
    header("Location: /login");
    exit();
} else {
    $user = $session->get('user');
}

$fontFamilies = [
    1 => 'Arial',
    2 => 'Times New Roman',
    3 => 'Verdana',
    4 => 'Georgia',
    5 => 'Courier New',
    6 => 'Comic Sans MS',
    
];

$alignmentClasses = [
    0 => 'text-left',
    1 => 'text-center',
    2 => 'text-right',
];

// Get the font family names based on the IDs
$fontTitle = $fontFamilies[$message['fontTitle']] ?? 'default-font';
$fontText = $fontFamilies[$message['fontText']] ?? 'default-font';
$alignmentTextClass = $alignmentClasses[$message['alignmentText']] ?? 'text-center';
$imageUrl = htmlspecialchars($message['image']);


?>

<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
    <link rel="stylesheet" href="<?php echo base_url('css/styleVisu.css'); ?>">
    <h2>Visualisation de l'évènement</h2>

<div class="container-wrapper">
    <button class="nav-button prev-button" onclick="navigateMessage('prev')"><span class="arrow">&larr;</span></button>
    <div class="containerUn" style="<?= $imageUrl ? "background-image: url('$imageUrl');" : '' ?>">
        <div class="form-group">
            <p id="titre" style="font-family: <?= htmlspecialchars($fontTitle) ?>; font-size: <?= htmlspecialchars($message['sizeTitle']) ?>px;">
            <?= htmlspecialchars($message['Title']) ?>
            </p>
        </div>

        <div class="form-group">
            <p id="description" class="<?= htmlspecialchars($alignmentTextClass) ?>" style="font-family: <?= htmlspecialchars($fontText) ?>; font-size: <?= htmlspecialchars($message['sizeText']) ?>px;">
            <?= htmlspecialchars($message['Text']) ?>
            </p>
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
            if (data.error) {
                alert(data.error);
            } else {
                document.getElementById('titre').innerText = data.Title;
                document.getElementById('titre').style.fontFamily = data.fontTitle;
                document.getElementById('titre').style.fontSize = data.sizeTitle + 'px';

                document.getElementById('description').innerText = data.Text;
                document.getElementById('description').style.fontFamily = data.fontText;
                document.getElementById('description').style.fontSize = data.sizeText + 'px';
                document.getElementById('description').className = data.alignmentText;

                document.querySelector('.containerUn').style.backgroundImage = data.image ? `url('${data.image}')` : '';
                document.getElementById('currentEventId').value = data.idMessage;
            }
        })
        .catch(error => {
            console.error('Error:', error);
        }); 
}
</script>
<?= $this->endSection() ?>
</body>
</html>