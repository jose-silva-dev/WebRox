<div>
    <a href="<?= route("user.character.{$character->name}") ?>">
        <img src="<?= resolve('Geral')->getAvatar($character->avatar) ?>" alt="Avatar" class="avatar">
        <p><?= $character->name ?></p>
    </a>
</div>