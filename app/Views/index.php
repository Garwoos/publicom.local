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
    <link rel="stylesheet" href="<?php echo base_url('css/style.css'); ?>">
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
                    <td class= 'centrer'>" . $row["idMessage"]. "</td>
                    <td class= 'centrer'>" . $row["Title"]. "</td>
                    <td >" . $row["Text"]. "</td>
                    <td class= 'centrer'>example</td>
                    <td class= 'centrer'>" .$row["mailUser"]. "</td> <td>";
                    
                    // Afficher une checkbox pour le champ Online
                    if ($row["Online"]) {
                        echo "<input type='checkbox' checked >";
                    } else {
                        echo "<input type='checkbox'";
                    }
                    
                    // Ajouter les boutons Modifier et Supprimer
                    echo "</td><td><button onclick='confirmModify(" . $row["idMessage"] . ")'>Modifier</button></td>";
                    echo "<td><button  onclick='confirmDelete(" . $row["idMessage"] . ")'>Supprimer</button></td></tr>";
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

            function confirmModify(id) {
                window.location.href = "/modify/" + id;
            }
            </script> 
<?= $this->endSection() ?>
</body>
</html>