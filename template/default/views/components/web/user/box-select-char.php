<?php
// Buscar informações da classe real do personagem (igual ao profile)
$classInfo = resolve('Geral')->getClass($character->class);
$className = $classInfo->name ?? __("user.class_unknown");
?>

<div class="character-card">
    <a href="<?= route("user.character.{$character->name}") ?>" class="character-link">
        <div class="character-avatar">
            <img src="<?= resolve('Geral')->getAvatar($character->avatar) ?>" alt="<?= $character->name ?>">
        </div>
        <div class="character-info">
            <div class="character-name"><?= $character->name ?></div>
            <div class="character-class"><?= $className ?></div>
        </div>
        <div class="character-arrow">
            <i class="ph ph-caret-right" aria-hidden="true"></i>
        </div>
    </a>
</div>