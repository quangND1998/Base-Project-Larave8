import './bootstrap';
import '../css/main.css';
// import Vue from 'vue'
import { createPinia } from 'pinia'
import { useDarkModeStore } from '@/stores/darkMode.js'

import { darkModeKey } from '@/config'
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
const pinia = createPinia()
const appName =
    import.meta.env.VITE_APP_NAME || 'Laravel';
import { helper } from '@/helper'
import base from '@/base';
import PrimeVue from 'primevue/config';
import Tooltip from 'primevue/tooltip';
import "primevue/resources/themes/lara-light-indigo/theme.css";


// import VueLazyload from 'vue-lazyload'




// import 'vue3-carousel/dist/carousel.css'
createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`,
        import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(pinia)
            .use(ZiggyVue)
            .use(PrimeVue)
            // .use(VueLazyload)
            .use(VueSweetalert2)
            .directive('tooltip', Tooltip)
            .mixin(helper, base)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});

const darkModeStore = useDarkModeStore(pinia)

document.documentElement.classList.forEach((token) => {
        if (token.indexOf('style') === 0) {
            document.documentElement.classList.replace(token, `style-basic`)
        }
        document.documentElement.classList.replace(token, `style-basic`)
    })
    /* Dark mode */
if (
    (!localStorage[darkModeKey] && window.matchMedia('(prefers-color-scheme: dark)').matches) ||
    localStorage[darkModeKey] === '1'
) {
    darkModeStore.set(true)
}