<template>
    <div class="ml-4 flex align-middle items-center">
        <!-- Notifications -->
        <!--        <button type="button"-->
        <!--                class="relative flex-shrink-0 text-gray-500 p-2 rounded-full transition hover:bg-gray-100 focus:outline-none">-->
        <!--            <span class="sr-only">View notifications</span>-->
        <!--            <BellIcon class="h-6 w-6" aria-hidden="true"/>-->
        <!--            <span-->
        <!--                class="absolute top-0 right-0 inline-flex items-center justify-center px-1 py-1 text-sm font-bold leading-none text-white bg-red-500 rounded-full">-->
        <!--                3-->
        <!--            </span>-->
        <!--        </button>-->
        <!-- Profile dropdown -->
        <Menu as="div" class="ml-3 relative">
            <div>
                <MenuButton
                    class="max-w-xs rounded-full flex items-center text-sm lg:p-2 transition lg:rounded-md lg:hover:bg-gray-100">
                    <img class="h-11 w-11 rounded-full" :src="$page.props.user.profile_photo_url"
                         alt=""/>
                    <span class="sr-only">Open user menu for </span>
                    <span class="hidden ml-3 lg:block">
                        <div class="font-semibold">{{ $page.props.user.name }}</div>
                        <div><span class="sr-only">Role</span>{{ getRoles }}</div>
                    </span>
                    <ChevronDownIcon class="hidden flex-shrink-0 ml-1 h-5 w-5 text-gray-400 lg:block"
                                     aria-hidden="true"/>
                </MenuButton>
            </div>
            <transition enter-active-class="transition ease-out duration-100"
                        enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100"
                        leave-active-class="transition ease-in duration-75"
                        leave-from-class="transform opacity-100 scale-100"
                        leave-to-class="transform opacity-0 scale-95">
                <MenuItems
                    class="origin-top-right absolute bg-white right-0 mt-2 w-64 rounded-md shadow-lg py-1 ring-1 ring-black ring-opacity-5 focus:outline-none">
                    <div class="px-4 py-3">
                        <p class="text-sm">
                            Ienācis kā
                        </p>
                        <p class="text-sm font-medium text-gray-900 truncate">
                            {{ $page.props.user.email }}
                        </p>
                    </div>
                    <MenuItem v-slot="{ active }">
                        <Link :href="route('profile.show')"
                              :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block w-full text-left px-4 py-2 text-sm transition']">
                            Mans konts
                        </Link>
                    </MenuItem>
                    <MenuItem v-slot="{ active }">
                        <button @click="logout"
                                :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block w-full text-left px-4 py-2 text-sm transition']">
                            Iziet
                        </button>
                    </MenuItem>
                </MenuItems>
            </transition>
        </Menu>
    </div>
</template>

<script>
import {
    BellIcon,
    ShoppingCartIcon
} from '@heroicons/vue/outline'
import {
    ChevronDownIcon,
} from '@heroicons/vue/solid'
import {Link} from '@inertiajs/inertia-vue3';
import {
    MenuButton,
    MenuItem,
    Menu as Menu,
    MenuItems,
} from '@headlessui/vue'
export default {
    name: "ProfileDropdown",
    components: {
        BellIcon,
        ShoppingCartIcon,
        ChevronDownIcon,
        MenuButton,
        MenuItem,
        MenuItems,
        Menu,
        Link
    },
    computed: {
        getRoles() {
            const roles = this.$page.props.user.roles;
            return roles.map(role => role.name).join(", ")
        }
    },
    methods: {
        logout() {
            this.$inertia.post(route('logout'), {}, {showProgress: true});
        }
    }
}
</script>

<style scoped>
</style>
