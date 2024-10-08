<?php
    $session = session();

    if (!$session->has('user')) {
        header("Location: /login");
        exit();
    } else {
        $user = $session->get('user');
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil</title>
    <meta name="description" content="The small framework with powerful features">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo base_url('css/style.css'); ?>">
</head>
<body>
    <h1>Publicom</h1>
    <ul class="menu">
        <li><a href="<?php echo site_url(relativePath: '/'); ?>">Accueil</a></li>
        <li><a href="<?php echo site_url('visualisation'); ?>">Visualisation</a></li>
        <li><a href="<?php echo site_url('create'); ?>">Création</a></li>
        <li><a href="<?php echo site_url('login'); ?>">Connexion</a></li>
    </ul>  
    <h2>Accueil</h2>  
    <table>
        <tr>
            <th>ID</th>
            <th>Titre</th>
            <th>Texte</th>
            <th>Lien</th>
            <th>Mail du créateur</th>
            <th>Online</th>
            <th>Modifier</th>
            <th>supprimer</th>
            </tr>
            <?php
            if (!empty($data)) {
                // Afficher les données de chaque ligne
                foreach ($data as $row) {
                    echo "<tr>
                    <td>" . $row["idMessage"]. "</td>
                    <td>" . $row["Title"]. "</td>
                    <td>" . $row["Text"]. "</td>
                    <td>example</td>
                    <td>" .$row["mailUser"]. "</td> <td>";
                    
                    // Afficher une checkbox pour le champ Online
                    if ($row["Online"]) {
                        echo "<input type='checkbox' checked >";
                    } else {
                        echo "<input type='checkbox'";
                    }
                    
                    // Ajouter les boutons Modifier et Supprimer
                    echo "</td><td><a href='modifier.php?id=" . $row["idMessage"] . "'>Modifier</a></td>";
                    echo "<td><a href='#' onclick='confirmDelete(" . $row["idMessage"] . ")'>Supprimer</a></td></tr>";
                }
            } else {
                echo "<tr><td colspan='8'>Aucun message trouvé</td></tr>";
            }
            ?>
            </table>
            <script>
            function confirmDelete(id) {
                if (confirm("Êtes-vous sûr de vouloir supprimer ce message ?")) {
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "/deleteMessage", true);
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    xhr.onreadystatechange = function () {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            // Rafraîchir la page pour refléter les changements
                            location.reload();
                        }
                    };
                    xhr.send("id=" + id);
                }
            }
            </script> 
</body>
</html>