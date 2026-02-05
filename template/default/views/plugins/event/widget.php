<div class="event-widget-ref">
    <h2 class="event-widget-title"><?= __("events.events_tab") ?></h2>

    <div class="event-time-box">
        <div class="event-time-row">
            <span class="event-time-label"><?= __("events.server") ?></span>
            <span id="server-clock" class="event-time-val server" data-server-sod="<?= $serverSod ?>">--:--:--</span>
        </div>
        <div class="event-time-row">
            <span class="event-time-label"><?= __("events.local") ?></span>
            <span id="local-clock" class="event-time-val local">--:--:--</span>
        </div>
    </div>

    <div class="event-category-ref">
        <select id="event-category" class="event-select-ref">
            <option value="events"><?= __("events.events_tab") ?></option>
            <option value="invasions"><?= __("events.invasions") ?></option>
        </select>
        <i class="ph ph-caret-down"></i>
    </div>

    <div id="events-tab" class="event-list-ref tab-content active">
        <?php foreach ($events as $event): ?>
            <div class="event-item-ref event-line">
                <span class="event-item-time event-clock">--:--</span>
                <span class="event-item-name"> - <?= e($event['name']) ?></span>
                <span class="event-countdown" data-times='<?= json_encode($event['times']) ?>'
                    data-duration="<?= $event['duration'] ?>">--:--:--</span>
            </div>
        <?php endforeach; ?>
        <?php if (empty($events)): ?>
            <div class="event-empty-ref"><?= __("events.none") ?></div>
        <?php endif; ?>
    </div>

    <div id="invasions-tab" class="event-list-ref tab-content">
        <?php foreach ($invasions as $invasion): ?>
            <div class="event-item-ref event-line">
                <span class="event-item-time event-clock">--:--</span>
                <span class="event-item-name"> - <?= e($invasion['name']) ?></span>
                <span class="event-countdown" data-times='<?= json_encode($invasion['times']) ?>'
                    data-duration="<?= $invasion['duration'] ?>">--:--:--</span>
            </div>
        <?php endforeach; ?>
        <?php if (empty($invasions)): ?>
            <div class="event-empty-ref"><?= __("events.no_invasions") ?></div>
        <?php endif; ?>
    </div>
</div>