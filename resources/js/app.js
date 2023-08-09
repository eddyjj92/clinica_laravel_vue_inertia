import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import '../css/app.css';
import ElementPlus from 'element-plus'
import 'element-plus/dist/index.css'
import es from 'element-plus/dist/locale/es.min.mjs'
import * as ElementPlusIconsVue from '@element-plus/icons-vue'

createInertiaApp({
    progress: {
        delay: 250,
        color: '#29d',
        includeCSS: true,
        showSpinner: true,
    },
    resolve: name => {
        const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
        return pages[`./Pages/${name}.vue`]
    },
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) })
        for (const [key, component] of Object.entries(ElementPlusIconsVue)) {
            app.component(key, component)
        }
        app.use(plugin).use(ElementPlus, {locale: es,})
        .mount(el)
    },
})
