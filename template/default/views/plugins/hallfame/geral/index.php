<?= $this->layout('components/layouts/web') ?>

<?php
$selectedClass = $selectedClass ?? null;
$this->insert('plugins/hallfame/geral/partials/select-ranking', [
    'selectedClass' => $selectedClass
]);
?>

<div class="rankings-info-callout">
    <i class="ph ph-info"></i>
    <p><?= __("rankings.info_callout") ?></p>
</div>
