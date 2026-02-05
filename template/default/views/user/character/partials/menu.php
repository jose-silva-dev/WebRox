<ul class="menu">
    <li><a href="<?= route("user/character/{$character->name}/nick") ?>"><?= __("char.menu_nick") ?></a></li>
    <li><a href="<?= route("user/character/{$character->name}/avatar") ?>"><?= __("char.menu_avatar") ?></a></li>
    <li><a href="<?= route("user/character/{$character->name}/map") ?>"><?= __("char.menu_map") ?></a></li>
    <li><a href="<?= route("user/character/{$character->name}/classe") ?>"><?= __("char.menu_class") ?></a></li>
</ul>