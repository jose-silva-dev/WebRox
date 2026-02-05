<?= $this->layout('components/layouts/web') ?>

<div class="web-title">
    <?= __("error.oops") ?>
</div>

<div class="error">
    <?php if ($data['error'] == 404): ?>
        <h1><?= __("error.404") ?></h1>
        <p><?= __("error.404_text") ?></p>
    <?php elseif ($data['error'] == 500): ?>
        <h1><?= __("error.500") ?></h1>
        <p><?= __("error.500_text") ?></p>
    <?php elseif ($data['error'] == 403): ?>
        <h1><?= __("error.403") ?></h1>
        <p><?= __("error.403_text") ?></p>
    <?php elseif ($data['error'] == 305): ?>
        <h1><?= __("error.305") ?></h1>
        <p><?= __("error.305_text") ?></p>
    <?php else: ?>
        <h1><?= __("error.unknown") ?></h1>
        <p><?php echo $data['error']; ?></p>
    <?php endif; ?>
</div>