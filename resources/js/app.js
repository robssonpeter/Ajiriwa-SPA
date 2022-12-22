require('./bootstrap');
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';
import Vue3Tour from 'vue3-tour';
import 'vue3-tour/dist/vue3-tour.css';
import { initializeApp } from "firebase/app";
import { getAnalytics } from "firebase/analytics";

const firebaseConfig = {
    apiKey: "AIzaSyCc2eq23_efjual1WZ329gMP5bZlOunv9s",
    authDomain: "ajiriwa-push-notifications.firebaseapp.com",
    projectId: "ajiriwa-push-notifications",
    storageBucket: "ajiriwa-push-notifications.appspot.com",
    messagingSenderId: "117362381735",
    appId: "1:117362381735:web:0a00ccfa5024cc70fc9c82",
    measurementId: "G-JW3B32E4S6"
};

// Initialize Firebase
/*const firebaseApp = initializeApp(firebaseConfig);
const analytics = getAnalytics(firebaseApp);
const messaging = firebaseApp.messaging();*/

InertiaProgress.init({ color: '#10b981', showSpinner: true });
createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props, firebaseConfig) })
            .use(Vue3Tour)
            .use(plugin)
            .mixin({ methods: { route } })
            .mount(el);
    },
});


