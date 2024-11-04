<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil</title>
    <meta name="description" content="The small framework with powerful features">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo base_url('css/styleLayout.css'); ?>">
</head>
<body>
    <h1>Publicom</h1>
    <ul class="menu">
        <li><a href="<?php echo site_url(relativePath: '/'); ?>">Accueil</a></li>
        <li><a href="<?php echo site_url('create'); ?>">Création</a></li>
        <li><a href="<?php echo site_url('login'); ?>">Connexion</a></li>
    </ul>
    <?= $this->renderSection('content') ?>
</body>
</html> 