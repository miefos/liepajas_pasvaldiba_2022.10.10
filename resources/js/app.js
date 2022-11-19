import "../css/app.css";

import {createApp, h} from 'vue';
import {createInertiaApp} from '@inertiajs/inertia-vue3';
import {InertiaProgress} from '@inertiajs/progress';
import VueLazyLoad from 'vue3-lazyload'

// dayjs
import dayjs from 'dayjs'
import relativeTime from 'dayjs/plugin/relativeTime'
import 'dayjs/locale/lv'
import PrimeVue from "primevue/config"
import "primevue/resources/themes/saga-blue/theme.css" //theme
import "primevue/resources/primevue.min.css" //core css
import "primeicons/primeicons.css" //icons
import Tooltip from 'primevue/tooltip';
import ConfirmationService from "primevue/confirmationservice";
import store from './store'

import ToastService from 'primevue/toastservice';
import AppLayout from "@/Layouts/AppLayout.vue"
import "./bootstrap";

dayjs.extend(relativeTime)
dayjs.locale('lv')

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

let asyncViews = () => {
    return import.meta.glob("./Pages/**/*.vue");
};

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: async (name) => {
            let pages = asyncViews();
            const importPage = pages[`./Pages/${name}.vue`];
            return importPage().then((module) => module.default);
    },
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .use(VueLazyLoad)
            .use(store)
            .use(PrimeVue, {
                locale: {
                    startsWith: 'Sākas ar',
                    contains: 'Satur',
                    notContains: 'Nesatur',
                    endsWith: 'Beidzas ar',
                    equals: 'Sakrīt',
                    notEquals: 'Nesakrīt',
                    noFilter: 'Nav filtru',
                    lt: 'Mazāks par',
                    lte: 'Mazāks par vai vienāds',
                    gt: 'Lielāks par',
                    gte: 'Lielāks par vai vienāds',
                    dateIs: 'Datums ir',
                    dateIsNot: 'Datums nav',
                    dateBefore: 'Datums ir pirms',
                    dateAfter: 'Datums ir pēc',
                    clear: 'Notīrīt',
                    apply: 'Pielietot',
                    matchAll: 'Atbilst visi',
                    matchAny: 'Atbilst kāds',
                    addRule: 'Pievienot noteikumu',
                    removeRule: 'Noņemt noteikumu',
                    accept: 'Jā',
                    reject: 'Nē',
                    choose: 'Izvēlies',
                    upload: 'Augšupielādēt',
                    cancel: 'Atcelt',
                    dayNames: ["Svētdiena", "Pirmdiena", "Otrdiena", "Trešdiena", "Ceturtdiena", "Piektdiena", "Sestdiena"],
                    dayNamesShort: ["Sv", "Pr", "O", "T", "C", "Pk", "S"],
                    dayNamesMin: ["Sv", "Pr", "O", "T", "C", "Pk", "S"],
                    monthNames: ["Janvāris","Februāris","Marts","Aprīlis","Maijs","Jūnijs","Jūlijs","Augusts","Septembris","Oktobris","Novembris","Decembris"],
                    monthNamesShort: ["Jan", "Feb", "Mar", "Apr", "Mai", "Jūn","Jūl", "Aug", "Sep", "Okt", "Nov", "Dec"],
                    today: 'Šodien',
                    weekHeader: 'Ned',
                    firstDayOfWeek: 1,
                    dateFormat: 'dd/mm/yy',
                    weak: 'Vājš',
                    medium: 'Vidējs',
                    strong: 'Stiprs',
                    passwordPrompt: 'Ievadi parolii',
                    emptyFilterMessage: 'Nekas netika atrasts',
                    emptyMessage: 'Nav pieejamu opciju'
                }
            })
            .use(ToastService)
            .use(ConfirmationService)
            .directive('tooltip', Tooltip)
            .mixin({ components: { AppLayout } })
            .mixin({ methods: {
                route,

                dayjs: dayjs,

                /* permissions should be array */
                hasAnyPermission: function (permissions) {
                    let usersPermission = this.$page.props.user.can;

                    const n = permissions.length
                    for (let i = 0; i < n; i++) {
                        if (usersPermission.includes(permissions[i]))
                            return true;
                    }

                    return false;
                },
            } })
            .mount(el);
    },
});

import './bootstrap';
InertiaProgress.init({ color: '#4B5563' });
