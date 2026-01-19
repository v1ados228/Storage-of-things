import './bootstrap';

if (window.Echo) {
    window.Echo.channel('things').listen('.things.created', (event) => {
        alert(`New thing created: ${event.thing.name}`);
    });

    window.Echo.channel('places').listen('.places.created', (event) => {
        alert(`New place created: ${event.place.name}`);
    });
}

document.addEventListener('click', (event) => {
    const card = event.target.closest('.card-clickable');
    if (!card) {
        return;
    }

    if (event.target.closest('a,button,form,input,select,textarea,label,summary')) {
        return;
    }

    const href = card.dataset.href;
    if (href) {
        window.location.href = href;
    }
});

const notificationsUrl = document.body.dataset.notificationsUrl;
if (notificationsUrl) {
    const updateNotifications = () => {
        fetch(notificationsUrl)
            .then((response) => response.json())
            .then((data) => {
                const countEl = document.getElementById('notificationsCount');
                const listEl = document.getElementById('notificationsList');

                if (countEl) {
                    countEl.textContent = data.count;
                }

                if (!listEl) {
                    return;
                }

                listEl.innerHTML = '';
                if (data.notifications.length === 0) {
                    const empty = document.createElement('div');
                    empty.textContent = 'Нет уведомлений';
                    listEl.appendChild(empty);
                    return;
                }

                data.notifications.forEach((notification) => {
                    const wrapper = document.createElement('div');
                    const link = document.createElement('a');
                    link.href = `/api/app/notifications/${notification.id}`;
                    link.textContent = `${notification.title} — ${notification.message}`;
                    wrapper.appendChild(link);
                    listEl.appendChild(wrapper);
                });
            })
            .catch(() => {});
    };

    updateNotifications();
    setInterval(updateNotifications, 30000);
}
