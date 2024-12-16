<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
    <link rel="stylesheet" href="<?php echo base_url('css/style.css'); ?>">
    <h2>Historique</h2>
    <table class="table">
        <thead>
            <tr>
                <th>idHistorique</th>
                <th>idMessage</th>
                <th>Mail</th>
                <th>Anciens messages</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php $data = array_reverse($data); ?>
            <?php foreach ($data as $row) : ?>
                <tr>
                    <td class="centrer"><?= $row['idModification'] ?></td>
                    <td class="centrer"><?= $row['IdMessage'] ?></td>
                    <td class="centrer"><?= $row['mailUser'] ?></td>
                    <td class="centrer"><?= $row['oldMessage'] ?></td>
                    <td class="centrer"><?= $row['Date'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?= $this->endSection() ?>
</body>
</html>