document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');
    if (!calendarEl) return;

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
    const rescheduleUrlTemplate = calendarEl.dataset.rescheduleUrlTemplate;
    const createUrl = calendarEl.dataset.createUrl;

    function rescheduleUrl(id) {
        return rescheduleUrlTemplate.replace('__ID__', id);
    }

    function pad(n) {
        return n.toString().padStart(2, '0');
    }

    function timeStr(date) {
        return `${pad(date.getHours())}:${pad(date.getMinutes())}`;
    }

    function dateStr(date) {
        return `${date.getFullYear()}-${pad(date.getMonth() + 1)}-${pad(date.getDate())}`;
    }

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'timeGridWeek',
        nowIndicator: true,
        editable: true,
        eventResizableFromStart: true,
        selectable: true,
        slotMinTime: '06:00:00',
        slotMaxTime: '20:00:00',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
        },
        height: 'auto',
        events: function (info, successCallback, failureCallback) {
            fetch(`${calendarEl.dataset.eventsUrl}?start=${info.startStr}&end=${info.endStr}`)
                .then(response => response.json())
                .then(data => successCallback(data))
                .catch(error => failureCallback(error));
        },
        select: function (info) {
            const params = new URLSearchParams({
                scheduled_date: dateStr(info.start),
            });
            if (info.view.type !== 'dayGridMonth') {
                params.set('start_time', timeStr(info.start));
                params.set('end_time', timeStr(info.end));
            }
            window.location.href = `${createUrl}?${params.toString()}`;
        },
        eventDrop: function (info) {
            updateSchedule(info.event, info.revert);
        },
        eventResize: function (info) {
            updateSchedule(info.event, info.revert);
        }
    });

    function updateSchedule(event, revert) {
        const payload = {
            scheduled_date: dateStr(event.start),
        };
        if (!event.allDay) {
            payload.start_time = timeStr(event.start);
            payload.end_time = event.end ? timeStr(event.end) : null;
        }

        fetch(rescheduleUrl(event.id), {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body: JSON.stringify(payload),
        })
            .then(response => {
                if (!response.ok) throw new Error('Reschedule failed');
            })
            .catch(() => {
                revert();
                alert('Could not reschedule this job. Please try again.');
            });
    }

    calendar.render();
});
