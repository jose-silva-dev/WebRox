document.addEventListener('DOMContentLoaded', () => {

    const pad = n => String(n).padStart(2, '0');

    /* ===== HORÁRIO DO SERVIDOR (FIXO) ===== */
    const serverClock = document.getElementById('server-clock');

    if (serverClock) {
        let sod = parseInt(serverClock.dataset.serverSod, 10);

        const renderServer = () => {
            sod = (sod + 1) % 86400;

            const h = pad(Math.floor(sod / 3600));
            const m = pad(Math.floor((sod % 3600) / 60));
            const s = pad(sod % 60);

            serverClock.textContent = `${h}:${m}:${s}`;
        };

        setInterval(renderServer, 1000);
    }

    /* ===== HORÁRIO LOCAL ===== */
    const localClock = document.getElementById('local-clock');

    if (localClock) {
        const updateLocal = () => {
            const d = new Date();
            localClock.textContent =
                `${pad(d.getHours())}:${pad(d.getMinutes())}:${pad(d.getSeconds())}`;
        };

        updateLocal();
        setInterval(updateLocal, 1000);
    }

    /* ===== EVENTOS + INVASÕES ===== */
    const rows = document.querySelectorAll('.event-countdown');

    const formatHMS = sec => {
        sec = Math.max(0, sec);
        const h = Math.floor(sec / 3600);
        const m = Math.floor((sec % 3600) / 60);
        const s = sec % 60;
        return `${pad(h)}:${pad(m)}:${pad(s)}`;
    };

    const formatHM = ts => {
    const d = new Date(ts * 1000);

    const parts = new Intl.DateTimeFormat('en-US', {
        hour: '2-digit',
        minute: '2-digit',
        hour12: false,
        timeZone: window.SITE_TIMEZONE
    }).formatToParts(d);

    const h = parts.find(p => p.type === 'hour').value;
    const m = parts.find(p => p.type === 'minute').value;

    return `${h}:${m}`;
};

    function updateEvents() {
        const now = Math.floor(Date.now() / 1000);

        rows.forEach(el => {
            const times = JSON.parse(el.dataset.times);
            const duration = parseInt(el.dataset.duration, 10);

            let start = null;

            for (let t of times) {
                if (now < t + duration) {
                    start = t;
                    break;
                }
            }

            if (!start) {
                start = times[0] + 86400;
            }

            const end = start + duration;

            const clock = el.closest('.event-line')
                ?.querySelector('.event-clock');

            if (clock) {
                clock.textContent = formatHM(start);
            }

            if (now < start) {
                el.textContent = formatHMS(start - now);
                el.style.color = '#c9a14a';
                return;
            }

            if (now >= start && now < end) {
                el.textContent = formatHMS(end - now);
                el.style.color = '#00ff66';
            }
        });
    }

    updateEvents();
    setInterval(updateEvents, 1000);

    /* ===== TROCA EVENTOS / INVASÕES ===== */
    const categorySelect = document.getElementById('event-category');

    if (categorySelect) {
        categorySelect.addEventListener('change', e => {
            document
                .querySelectorAll('.tab-content')
                .forEach(tab => tab.classList.remove('active'));

            document
                .getElementById(`${e.target.value}-tab`)
                ?.classList.add('active');
        });
    }

});
