import { createApp } from 'vue/dist/vue.esm-bundler.js';
import { createRulesPlugin } from 'vuetify/labs/rules';
import 'vuetify/styles';
import '@fortawesome/fontawesome-free/css/all.css';
import { createVuetify } from 'vuetify';
import * as components from 'vuetify/components';
import * as directives from 'vuetify/directives';
import { aliases, fa } from 'vuetify/iconsets/fa';
import { importComponents } from '@/js/index.js';

const vuetify = createVuetify({
    icons: {
        defaultSet: 'fa',
        aliases,
        sets: {
            fa,
        },
    },
    components,
    directives,
});

const app = createApp({})
    .use(vuetify)
    .use(createRulesPlugin({}, vuetify.locale));

importComponents(app);

app.mount('#app');
