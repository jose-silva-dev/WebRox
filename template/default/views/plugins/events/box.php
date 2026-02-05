<?php use Source\Services\EventService; ?>
<?php $events = EventService::getEvents(); ?>

<div class="events-box">
    <h3><?= __("events.title") ?></h3>

    <?php foreach ($events as $category => $list): ?>
        <div class="events-category">
            <span><?= $category ?></span>
        </div>

        <?php foreach ($list as $event): ?>
            <div class="event-line">
                <span><?= $event['name'] ?></span>
                <span class="event-time <?= $event['seconds'] <= 600 ? 'soon' : '' ?>">
                    <?= $event['time'] ?>
                </span>
            </div>
        <?php endforeach; ?>
    <?php endforeach; ?>
</div>
