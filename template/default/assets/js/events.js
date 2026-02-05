document.addEventListener('DOMContentLoaded', () => {

    const pad = n => String(n).padStart(2, '0');

const serverClocks = document.querySelectorAll('[id="server-clock"], [id="sidebar-server-clock"]');
    const firstServer = Array.from(serverClocks).find(el => el.dataset.serverSod);
    if (firstServer) {
        let sod = parseInt(firstServer.dataset.serverSod, 10);
        const renderServer = () => {
            sod = (sod + 1) % 86400;
            const t = `${pad(Math.floor(sod / 3600))}:${pad(Math.floor((sod % 3600) / 60))}:${pad(sod % 60)}`;
            serverClocks.forEach(el => { el.textContent = t; });
        };
        setInterval(renderServer, 1000);
    }

const localClocks = document.querySelectorAll('#local-clock, #sidebar-local-clock');
    const updateLocalAll = () => {
        const d = new Date();
        const t = `${pad(d.getHours())}:${pad(d.getMinutes())}:${pad(d.getSeconds())}`;
        localClocks.forEach(el => { el.textContent = t; });
    };
    if (localClocks.length) {
        updateLocalAll();
        setInterval(updateLocalAll, 1000);
    }

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
            if (!el?.dataset?.times) return;
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

    if (rows.length) {
        updateEvents();
        setInterval(updateEvents, 1000);
    }

document.querySelectorAll('#event-category, #sidebar-event-category').forEach(categorySelect => {
        categorySelect.addEventListener('change', e => {
            const prefix = e.target.id === 'sidebar-event-category' ? 'sidebar-' : '';
            const tabId = prefix + e.target.value + '-tab';
            [prefix + 'events-tab', prefix + 'invasions-tab'].forEach(id => {
                const t = document.getElementById(id);
                if (t) t.classList.remove('active');
            });
            const tab = document.getElementById(tabId);
            if (tab) tab.classList.add('active');
        });
    });

});
