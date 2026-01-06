<?php if ($sliders): ?>
    <div class="slider swiper">
        <div class="swiper-wrapper">
            <?php foreach ($sliders as $slider): ?>
                <div class="swiper-slide">
                    <?php if (!empty($slider->link)): ?>
                        <a href="<?= htmlspecialchars($slider->link) ?>" style="display: block; width: 100%; height: 100%;">
                    <?php endif; ?>
                    <?php if ($slider->title): ?>
                        <div class="title"><?= $slider->title ?></div>
                    <?php endif; ?>
                    <img src="<?= public_path("images/slider/{$slider->image}") ?>" alt="Sliders">
                    <?php if (!empty($slider->link)): ?>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php else: ?>
    <p class="warning">Nenhum slider encontrado</p>
<?php endif; ?>