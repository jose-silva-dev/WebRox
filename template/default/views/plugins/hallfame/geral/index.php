<?= $this->layout('components/layouts/web') ?>

<?php 
$selectedClass = $selectedClass ?? null;
$this->insert('plugins/hallfame/geral/partials/select-ranking', [
    'selectedClass' => $selectedClass
]);
?>

<div class="warning">
    Para visualizar o ranking, você precisa selecionar a quantidade e o ranking, acima e clicar no botão "Buscar".
</div>