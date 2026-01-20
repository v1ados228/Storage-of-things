<template>
    <div
        v-if="notification"
        class="alert alert-primary alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3"
        role="alert"
        style="z-index: 1050; max-width: 640px;"
    >
        <strong>{{ notification.title }}</strong>
        <div class="mt-1">
            <a v-if="notification.link" :href="notification.link" class="alert-link">
                {{ notification.message }}
            </a>
            <span v-else>{{ notification.message }}</span>
        </div>
        <button type="button" class="btn-close" @click="closeAlert" aria-label="Close"></button>
    </div>
</template>

<script>
export default {
    data() {
        return {
            notification: null,
            timer: null,
        };
    },
    created() {
        if (typeof window.Echo === 'undefined') {
            return;
        }

        const showNotification = (payload) => {
            this.notification = payload;
            if (this.timer) {
                clearTimeout(this.timer);
            }
            this.timer = setTimeout(() => {
                this.notification = null;
            }, 10000);
        };

        const thingHandler = (event) => {
            const thing = event?.thing;
            if (!thing) {
                return;
            }
            showNotification({
                title: 'Создана новая вещь',
                message: thing.name,
                link: `/app/things/${thing.id}`,
            });
        };

        const placeHandler = (event) => {
            const place = event?.place;
            if (!place) {
                return;
            }
            showNotification({
                title: 'Создано новое место хранения',
                message: place.name,
                link: `/app/places`,
            });
        };

        window.Echo.channel('things')
            .listen('.things.created', thingHandler)
            .listen('ThingCreated', thingHandler);

        window.Echo.channel('places')
            .listen('.places.created', placeHandler)
            .listen('PlaceCreated', placeHandler);
    },
    beforeUnmount() {
        if (this.timer) {
            clearTimeout(this.timer);
        }
    },
    methods: {
        closeAlert() {
            this.notification = null;
        },
    },
};
</script>
