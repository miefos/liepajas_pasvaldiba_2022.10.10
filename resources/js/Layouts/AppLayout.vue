<template>
    <div>
        <div class="relative h-screen flex overflow-hidden">
            <Head :title="title" />

            <!-- sidebar for mobile -->
            <TransitionRoot as="template" :show="sidebarOpen">
                <Dialog as="div" class="fixed inset-0 flex z-40 lg:hidden" @close="sidebarOpen = false">
                    <TransitionChild as="template" enter="transition-opacity ease-linear duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="transition-opacity ease-linear duration-300" leave-from="opacity-100" leave-to="opacity-0">
                        <DialogOverlay class="fixed inset-0 bg-gray-600 bg-opacity-75" />
                    </TransitionChild>
                    <TransitionChild as="template" enter="transition ease-in-out duration-300 transform" enter-from="-translate-x-full" enter-to="translate-x-0" leave="transition ease-in-out duration-300 transform" leave-from="translate-x-0" leave-to="-translate-x-full">
                        <div class="relative flex-1 flex flex-col max-w-xs w-full pt-5 pb-4 bg-custom-main-700">
                            <TransitionChild as="template" enter="ease-in-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in-out duration-300" leave-from="opacity-100" leave-to="opacity-0">
                                <div class="absolute top-0 right-0 -mr-12 pt-2">
                                    <button type="button" class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" @click="sidebarOpen = false">
                                        <span class="sr-only">Close sidebar</span>
                                        <XIcon class="h-6 w-6 text-white" aria-hidden="true" />
                                    </button>
                                </div>
                            </TransitionChild>
<!--                            <div class="hidden flex-shrink-0 sm:flex items-center px-4">-->
<!--                                <img class="w-max-1/2" src="/storage/images/logo.png" alt="VM logo" />-->
<!--                            </div>-->
                            <nav class="mt-5 flex-shrink-0 h-full divide-y divide-sky-800 overflow-y-auto" aria-label="Sidebar">
                                <div class="px-2 space-y-1">
                                    <sidebar-links :links="navigation" />
                                </div>
                                <div class="mt-6 pt-6">
                                    <div class="px-2 space-y-1">
                                        <sidebar-links :links="secondaryNavigation" />
                                    </div>
                                </div>
                            </nav>
                        </div>
                    </TransitionChild>
                    <div class="flex-shrink-0 w-14" aria-hidden="true">
                        <!-- Dummy element to force sidebar to shrink to fit close icon -->
                    </div>
                </Dialog>
            </TransitionRoot>

            <!-- Static sidebar for desktop -->
            <TransitionRoot as="template" :show="sidebarOpenDesktop">
                    <div class="hidden lg:flex lg:flex-shrink-0">
                        <div class="flex flex-col w-64">
                            <!-- Sidebar component, swap this element with another sidebar if you like -->
                            <div class="flex flex-col flex-grow bg-custom-main-700 overflow-y-auto">
                                <div class="w-full my-6">
                                    <div class="text-xl font-bold text-cyan-50 text-center tracking-wider">
                                        {{ $page.props?.app?.name ?? 'Company' }}
                                    </div>
        <!--                            <img class="mx-auto w-1/2" src="/storage/images/logo.png" alt="logo" />-->
                                </div>
                                <nav class="flex-1 flex flex-col divide-y divide-sky-900 overflow-y-auto" aria-label="Sidebar">
                                    <div class="px-3 space-y-1">
                                        <sidebar-links :links="navigation" />
                                    </div>
                                    <div class="mt-6 pt-6">
                                        <div class="px-3 space-y-1">
                                            <sidebar-links :links="secondaryNavigation" />
                                        </div>
                                    </div>
                                </nav>
                            </div>
                        </div>
                    </div>
            </TransitionRoot>

            <!-- topbar -->
            <div class="flex-1 overflow-auto focus:outline-none">
                <div class="relative z-10 flex-shrink-0 flex h-20 bg-gray-200">

                    <button type="button" class="px-4 border-r border-gray-300 text-gray-400 focus:outline-none focus:ring-0 focus:ring-inset focus:ring-sky-500"
                        @click="sidebarOpen = true; sidebarOpenDesktop = !sidebarOpenDesktop;">
                        <span class="sr-only">Open sidebar</span>
                        <MenuAlt1Icon class="h-6 w-6" aria-hidden="true" />
                    </button>

                    <div class="flex-1 px-4 flex">
                        <img class="" :src="logoUrl" @error="logoUrl = alternativeLogoUrl" alt="logo" />
                    </div>

                    <div class="flex-1 px-4 flex justify-between sm:px-6 w-full lg:mx-auto lg:px-8">

                        <!-- Search bar -->
                        <!--                    <search-form></search-form>-->
                        <div class="flex-1"></div>

                        <!-- Profile dropdown, notifications -->
                        <profile-dropdown></profile-dropdown>

                    </div>
                </div>

                <main class="flex-1 relative pb-8 z-0 overflow-y-auto min-h-[80%]">
                    <div>
                        <!--                    <validation-errors></validation-errors>-->
                        <div class="px-4 pt-5 sm:px-6">
                            <div class="text-xl">
                                <slot name="header"></slot>
                            </div>
                        </div>
                        <div class="px-4 py-5 sm:p-6">
                            <slot></slot>
                        </div>
                    </div>
                </main>
            </div>
        </div>

        <the-toast-notification></the-toast-notification>

    </div>
</template>

<script>
import {computed, ref, watch} from 'vue'
import {
    Dialog,
    DialogOverlay,
    TransitionChild,
    TransitionRoot,
} from '@headlessui/vue'
import {
    CogIcon,
    ViewListIcon,
    ShoppingCartIcon,
    HomeIcon,
    MenuAlt1Icon,
    CollectionIcon,
    UserGroupIcon,
    QrcodeIcon,
    XIcon,
    CameraIcon,
    QuestionMarkCircleIcon,
} from '@heroicons/vue/outline'
import {
    CheckCircleIcon,
    OfficeBuildingIcon,
} from '@heroicons/vue/solid'
import SidebarLinks from "./Components/SidebarLinks.vue";
import SearchForm from "./Components/SearchForm.vue";
import ProfileDropdown from "./Components/ProfileDropdown.vue";
import {Head, usePage} from "@inertiajs/inertia-vue3"
import ValidationErrors from "../Jetstream/ValidationErrors.vue";
import TheToastNotification from "@/Layouts/Components/TheToastNotification.vue";
import Dropdown from "primevue/dropdown";
import {mapGetters} from "vuex";

const navigation = [
    // { name: 'Sākums', routeName: 'home', icon: HomeIcon},
    {name: 'Mērķi', routeName: 'goals.index', icon: CollectionIcon, can: ['goal_read']},
]
const secondaryNavigation = [
    {name: 'Struktūrvienības', routeName: 'entities.index', icon: CollectionIcon, can: ['entity_read']},
    {name: 'Struktūrvienību līmeņi', routeName: 'entity_levels.index', icon: CollectionIcon, can: ['entity_level_read']},
    {name: 'Pabeigtības līmeņi', routeName: 'complete_levels.index', icon: CollectionIcon, can: ['complete_level_read']},
    { name: 'Lietotāji un lomas', routeName: '#', icon: UserGroupIcon,
        children: [
            {name: 'Lietotāji', routeName: 'users.index', icon: UserGroupIcon, can: ["user_read"],},
            { name: 'Lomas', routeName: 'roles.index', icon: UserGroupIcon, can: ["role_read"]},
            { name: 'Atļaujas', routeName: 'permissions.index', icon: UserGroupIcon, can: ["permission_read"]},
        ]
    },
    // { name: 'Iestatījumi', routeName: '#', icon: CogIcon },
    // { name: 'Palīdzība', routeName: '#', icon: QuestionMarkCircleIcon },
    // { name: 'Logs', href: '/log-viewer', icon: CogIcon, can: ["view logs"], notInertiaLink: true},
]
export default {
    components: {
        TheToastNotification,
        ValidationErrors,
        ProfileDropdown,
        SearchForm,
        SidebarLinks,
        Dialog,
        DialogOverlay,
        TransitionChild,
        TransitionRoot,
        CheckCircleIcon,
        MenuAlt1Icon,
        OfficeBuildingIcon,
        CollectionIcon,
        XIcon,
        QrcodeIcon,
        Head,
        Dropdown
    },
    props: {
        title: String,
    },
    data() {
      return {
          selectedEntityVModel: null,
          logoUrl: '/storage/images/logo.png',
          alternativeLogoUrl: '/storage/app/public/images/logo.png'
      }
    },
    computed: {
      ...mapGetters({
          // selectedEntity: 'selectedEntity',
          // errorNoEntityAvailable: 'errorNoEntityAvailable'
      })
    },
    created() {
        // const entities = this.$page.props.app.entities;
        // this.$store.dispatch('updateListOfAvailableEntities', entities).then(r => {
        //   this.$store.dispatch('getFirstAvailableEntity').then(r =>
        //     this.selectedEntityVModel = this.selectedEntity
        //   )
        // })
    },
    methods: {
        // updateSelectedEntity(entity) {
        //     this.$store.dispatch('selectEntity', entity.value)
        // }
    },
    setup() {
        const sidebarOpen = ref(false) // for mobile view
        const sidebarOpenDesktop = ref(false)

        return {
            navigation,
            secondaryNavigation,
            sidebarOpen,
            sidebarOpenDesktop,
        }
    },
}
</script>
