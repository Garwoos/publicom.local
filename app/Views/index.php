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
                <td class= 'centrer'>" . htmlspecialchars($row["Title"]). "</td>
                <td >" . htmlspecialchars($row["Text"]). "</td>
                <td class='centrer'><a href='/visualisationMessage?id=" . $row["idMessage"] . "'>Voir</a></td>
                <td class= 'centrer'>" .$row["mailUser"]. "</td> <td>";
                
                // Afficher une checkbox pour le champ Online
                if ($row["Online"]) {
                    echo "<input type='checkbox' checked onclick='toggleOnline(" . $row["idMessage"] . ", this.checked)'>";
                } else {
                    echo "<input type='checkbox' onclick='toggleOnline(" . $row["idMessage"] . ", this.checked)'>";
                }
                
                // Ajouter les boutons Modifier et Supprimer
                echo "</td><td><button onclick='confirmModify(" . $row["idMessage"] . ")'>Modifier</button></td>";
                echo "<td><button onclick='confirmDelete(" . $row["idMessage"] . ")'>Supprimer</button></td></tr>";
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

    function toggleOnline(id, isChecked) {
        fetch('/updateOnlineStatus', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                id: id,
                online: isChecked ? 1 : 0
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.message) {
                console.log(data.message);
            }
        })
        .catch(error => {
            console.error('Erreur lors de la mise à jour du statut en ligne:', error);
        });
    }
    </script>
<?= $this->endSection() ?>
</body>
</html>