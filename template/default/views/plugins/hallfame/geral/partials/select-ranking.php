<div style="text-align: center; margin-bottom: 2rem;">
    <h2 class="web-title" style="margin-bottom: 1rem;">Ranking</h2>
    <p style="color: var(--neutral-50); font-size: 16px; line-height: 1.6; max-width: 800px; margin: 0 auto;">
        Você é bom o bastante para estar entre os melhores? Aceite este desafio!
    </p>
</div>

<form action="<?= route('rankings.search'); ?>" method="post" class="form" id="ranking-search-form">
    <?= csrf_field() ?>
    <div class="select-ranking" style="display: flex; gap: 1rem; align-items: flex-start; justify-content: center; flex-wrap: wrap; max-width: 1200px; margin: 0 auto;">
        <div style="flex: 1; min-width: 150px;">
            <label for="quantity" style="display: block; margin-bottom: 0.5rem; color: var(--white); font-weight: 600; font-size: 14px; text-transform: uppercase;">Quantidade</label>
            <select name="quantity" id="quantity" style="width: 100%; padding: 0.75rem; background: var(--background-card); border: 2px solid var(--neutral-300); border-radius: 8px; color: var(--white); font-size: 14px; cursor: pointer; transition: all 0.2s ease;">
                <option value="10" <?= (isset($selectedTop) && $selectedTop == 10) ? 'selected' : '' ?>>10</option>
                <option value="20" <?= (isset($selectedTop) && $selectedTop == 20) ? 'selected' : '' ?>>20</option>
                <option value="30" <?= (isset($selectedTop) && $selectedTop == 30) ? 'selected' : '' ?>>30</option>
                <option value="40" <?= (isset($selectedTop) && $selectedTop == 40) ? 'selected' : '' ?>>40</option>
                <option value="50" <?= (isset($selectedTop) && $selectedTop == 50) ? 'selected' : '' ?>>50</option>
                <option value="100" <?= (isset($selectedTop) && $selectedTop == 100) ? 'selected' : '' ?>>100</option>
            </select>
        </div>

        <div style="flex: 1; min-width: 200px;">
            <label for="ranking" style="display: block; margin-bottom: 0.5rem; color: var(--white); font-weight: 600; font-size: 14px; text-transform: uppercase;">Ranking</label>
            <select name="ranking" id="ranking" style="width: 100%; padding: 0.75rem; background: var(--background-card); border: 2px solid var(--neutral-300); border-radius: 8px; color: var(--white); font-size: 14px; cursor: pointer; transition: all 0.2s ease;">
                <?php foreach (resolve('Geral')->getLinkRanking() as $link): ?>
                    <option value="<?php echo $link['slug']; ?>" <?= (isset($selectedSlug) && $selectedSlug == $link['slug']) ? 'selected' : '' ?>>
                        <?php echo $link['name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div style="flex: 1; min-width: 200px;">
            <label for="class" style="display: block; margin-bottom: 0.5rem; color: var(--white); font-weight: 600; font-size: 14px; text-transform: uppercase;">Classe</label>
            <select name="class" id="class" style="width: 100%; padding: 0.75rem; background: var(--background-card); border: 2px solid var(--neutral-300); border-radius: 8px; color: var(--white); font-size: 14px; cursor: pointer; transition: all 0.2s ease;">
                <option value="">Todas as Classes</option>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const quantity = document.getElementById('quantity');
    const ranking = document.getElementById('ranking');
    const classSelect = document.getElementById('class');
    
    let searchTimeout;
    
    function triggerSearch() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(function() {
            const top = quantity.value;
            const slug = ranking.value;
            const classId = classSelect.value;
            
            // Construir URL base - formato: /ranking/{slug}/{top}
            let url = '/ranking/' + slug + '/' + top;
            
            // Adicionar classe se selecionada
            if (classId && classId !== '') {
                url += '?class=' + classId;
            }
            
            // Redirecionar
            window.location.href = url;
        }, 300); // Pequeno delay para evitar múltiplas requisições
    }
    
    quantity.addEventListener('change', triggerSearch);
    ranking.addEventListener('change', triggerSearch);
    classSelect.addEventListener('change', triggerSearch);
});
</script>

<style>
.select-ranking select:hover {
    border-color: var(--red-100);
}

.select-ranking select:focus {
    outline: none;
    border-color: var(--red-100);
    box-shadow: 0 0 0 3px rgba(192, 34, 34, 0.1);
}
</style>