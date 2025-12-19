<form action="<?= route('rankings.search'); ?>" method="post" class="form">
    <div class="select-ranking">
        <div>
            <label for="quantity">Quantidade</label>
            <select name="quantity" id="quantity">
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="30">30</option>
                <option value="40">40</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
        </div>

        <div>
            <label for="ranking">Ranking</label>
            <select name="ranking" id="ranking">
                <?php foreach (resolve('Geral')->getLinkRanking() as $link): ?>
                    <option value="<?php echo $link['slug']; ?>"><?php echo $link['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <button type="submit" class="btn btn-primary">Buscar</button>
        </div>

    </div>
</form>