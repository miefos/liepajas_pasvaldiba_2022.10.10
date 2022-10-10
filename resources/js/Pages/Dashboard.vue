<template>
    <app-layout title="Sākums">
        <div class="flex items-center">
            <h1 class="text-2xl flex-1 my-4">Paziņojumi</h1>
            <button @click="toggleRead('all')" class="bg-sky-700 rounded-md px-4 py-2 text-white hover:bg-sky-800">
                Izlasīt visus
            </button>
        </div>
        <div class="bg-white shadow overflow-hidden sm:rounded-md w-full">
            <ul role="list" class="divide-y divide-gray-200">
                <li v-for="notification in notifications" :key="notification.id">
                    <div class="block hover:bg-sky-100"  :class="notification.read_at ? 'bg-gray-50' : 'bg-sky-50'">
                        <div class="flex items-center px-4 py-4 sm:px-6">
                            <div class="min-w-0 flex-1 flex items-center">
                                <div class="flex-shrink-0">
                                    <img class="h-12 w-12 rounded-full" :class="{'border-2 border-sky-600': !notification.read_at}" :src="notification.data.user.profile_photo_url" alt="" />
                                </div>
                                <div class="min-w-0 flex-1 px-4 md:grid md:grid-cols-2 md:gap-4">
                                    <div>
                                        <Link
                                            :href="route('orders.index',
                                                    {
                                                        order_id: notification.data.order.id,
                                                        show: notification.data.order.user_id === $page.props.user.id ? 'my' : 'all'
                                                    })"
                                            class="font-medium text-sky-600 truncate"
                                            :class="notification.read_at ? '' : 'font-bold'"
                                        >
                                            {{ notification.data.order.name }}
                                        </Link>
                                        <div class="text-xs text-gray-500 italic">
                                            {{ dayjs(notification.data.order.start_date).format('DD-MM-YYYY') }} - {{ dayjs(notification.data.order.end_date).format('DD-MM-YYYY') }}
                                        </div>
                                        <p class="mt-2 flex items-center text-sm text-gray-500">
                                            <CheckCircleIcon class="flex-shrink-0 mr-1.5 h-5 w-5 text-green-400" aria-hidden="true" />
                                            {{ notification.data.order.status.name }}
                                        </p>
                                        <p class="mt-2 flex items-center text-sm text-gray-500">
                                            <MailIcon class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" aria-hidden="true" />
                                            <span class="truncate">{{ notification.data.user.email }}</span>
                                        </p>
                                    </div>
                                    <div class="hidden md:block">
                                        <div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <p class="text-sm text-gray-900 mb-4">
                                    <time :datetime="notification.date">{{ dayjs(notification.created_at).format('D. MMMM hh:mm, YYYY') }}</time>
                                </p>
                                <button @click="toggleRead(notification.id)" >
                                    {{ notification.read_at ? 'Atzīmēt kā neizlasītu' : 'Atzīmēt kā izlasītu' }}
                                </button>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import { CheckCircleIcon, MailIcon } from '@heroicons/vue/solid'
import {useForm} from "@inertiajs/inertia-vue3";
import {Link} from "@inertiajs/inertia-vue3"

export default {
    name: "Dashboard",
    components: {
        AppLayout,
        CheckCircleIcon,
        MailIcon,
        Link
    },
    props: {
        notifications: Array
    },
    setup() {
        const toggleRead = (id) => {
            useForm({}).post(route('notifications.read', id))
        }

        return {
            toggleRead
        }
    }
}
</script>

<style scoped>

</style>
