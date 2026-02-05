<section class="rankings-page-header">
    <header class="rankings-header">
        <h1 class="rankings-title"><?= __("rankings.title") ?></h1>
        <div class="accent-line"></div>
        <p class="rankings-subtitle"><?= __("rankings.subtitle") ?></p>
    </header>

    <div class="rankings-filters-card card">
        <form action="<?= route('rankings.search') ?>" method="post" class="rankings-filters" id="ranking-search-form">
            <?= csrf_field() ?>
            <div class="rankings-filters-row">
                <div class="rankings-field">
                    <label for="quantity"><?= __("rankings.quantity") ?></label>
                    <select name="quantity" id="quantity">
                        <option value="10" <?= (isset($selectedTop) && $selectedTop == 10) ? 'selected' : '' ?>>10</option>
                        <option value="20" <?= (isset($selectedTop) && $selectedTop == 20) ? 'selected' : '' ?>>20</option>
                        <option value="30" <?= (isset($selectedTop) && $selectedTop == 30) ? 'selected' : '' ?>>30</option>
                        <option value="40" <?= (isset($selectedTop) && $selectedTop == 40) ? 'selected' : '' ?>>40</option>
                        <option value="50" <?= (isset($selectedTop) && $selectedTop == 50) ? 'selected' : '' ?>>50</option>
                        <option value="100" <?= (isset($selectedTop) && $selectedTop == 100) ? 'selected' : '' ?>>100</option>
                    </select>
                </div>
                <div class="rankings-field">
                    <label for="ranking"><?= __("rankings.ranking") ?></label>
                    <select name="ranking" id="ranking">
                        <?php foreach (resolve('Geral')->getLinkRanking() as $link): ?>
                            <option value="<?= htmlspecialchars($link['slug']) ?>" <?= (isset($selectedSlug) && $selectedSlug == $link['slug']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($link['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="rankings-field">
                    <label for="class"><?= __("rankings.class") ?></label>
                    <select name="class" id="class">
                        <option value=""><?= __("rankings.all_classes") ?></option>
                        <?php
                        $classes = resolve('Geral')->getClasses();
                        foreach ($classes as $classId => $class):
                        ?>
                            <option value="<?= $classId ?>" <?= (isset($selectedClass) && $selectedClass !== null && $selectedClass == $classId) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($class['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </form>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const quantity = document.getElementById('quantity');
    const ranking = document.getElementById('ranking');
    const classSelect = document.getElementById('class');

    let searchTimeout;
    function triggerSearch() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(function () {
            const top = quantity.value;
            const slug = ranking.value;
            const classId = classSelect.value;
            let url = '<?= route("ranking") ?>/' + slug + '/' + top;
            if (classId && classId !== '') url += '?class=' + classId;
            window.location.href = url;
        }, 300);
    }

    if (quantity) quantity.addEventListener('change', triggerSearch);
    if (ranking) ranking.addEventListener('change', triggerSearch);
    if (classSelect) classSelect.addEventListener('change', triggerSearch);
});
</script>
