<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
    <h2>Historique</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Message</th>
                <th>Date</th>
            </tr>
        </thead>
            <?php 
            foreach ($historiques as $historique): ?>
                <tr>
                    <td><?= $historique['id'] ?></td>
                    <td><?= $historique['message'] ?></td> 
                    <td><?= $historique['created_at'] ?></td> 
                </tr>
            <?php endforeach; ?>
    </table>
<?= $this->endSection() ?>
</body>
</html>

// Modifie toutes les informations ici gros caca