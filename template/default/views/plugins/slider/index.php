<?php if ($sliders): ?>
    <div class="slider swiper">
        <div class="swiper-wrapper">
            <?php foreach ($sliders as $slider): ?>
                <div class="swiper-slide">
                    <img src="<?= public_path("images/slider/{$slider->image}") ?>" alt="<?= htmlspecialchars($slider->title ?? __("slider.alt")) ?>">
                    <?php if (!empty($slider->link)): ?>
                        <a href="<?= htmlspecialchars($slider->link) ?>" class="slider-link" aria-label="<?= htmlspecialchars($slider->title ?? __("common.see_more")) ?>"></a>
                    <?php endif; ?>
                    <?php if (!empty($slider->title)): ?>
                        <div class="slider-title-overlay"><?= $slider->title ?></div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php else: ?>
    <p class="warning"><?= __("slider.none") ?></p>
<?php endif; ?>