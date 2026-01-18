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
