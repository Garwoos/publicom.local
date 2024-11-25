<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
    <h2>Historique</h2>
    <table class="table">
        <thead>
            <tr>
                <th>idHistorique</th>
                <th>idMessage</th>
                <th>mailUser</th>
                <th>oldMessage</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $row) : ?>
                <tr>
                    <td><?= $row['idModification'] ?></td>
                    <td><?= $row['IdMessage'] ?></td>
                    <td><?= $row['mailUser'] ?></td>
                    <td><?= $row['oldMessage'] ?></td>
                    <td><?= $row['Date'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?= $this->endSection() ?>
</body>
</html>