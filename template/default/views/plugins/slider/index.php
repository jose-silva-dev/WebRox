<?php if ($sliders): ?>
    <div class="slider swiper">
        <div class="swiper-wrapper">
            <?php foreach ($sliders as $slider): ?>
                <div class="swiper-slide">
                    <?php if ($slider->title): ?>
                        <div class="title"><?= $slider->title ?></div>
                    <?php endif; ?>
                    <img src="<?= public_path("images/slider/{$slider->image}") ?>" alt="Sliders">
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php else: ?>
    <p class="warning">Nenhum slider encontrado</p>
<?php endif; ?>