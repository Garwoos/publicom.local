<?php
    session_start(); // Assure-toi que la session est démarrée
    // Vérifier si l'utilisateur est connecté
    if (empty($_SESSION["user"])) {
        //rediriger vers la page de connexion
        header("Location: /login");
        exit;
    }
    else {
        echo "Bonjour ".$_SESSION["user"]["mailUser"];
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000;
            padding: 10px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Messages</h1>
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
            if (!empty($data) && !empty($_SESSION["user"])) {
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
                        echo "<input type='checkbox' checked disabled>";
                    } else {
                        echo "<input type='checkbox' disabled>";
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
                    xhr.open("POST", "/delete");
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