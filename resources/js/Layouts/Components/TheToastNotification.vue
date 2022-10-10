<template>
    <div aria-live="assertive" class="z-10 fixed inset-0 flex items-end px-4 py-6 pointer-events-none sm:p-6 sm:items-start">
        <div class="w-full flex flex-col items-center space-y-4 sm:items-end">
            <transition-group
                name="notifications"
            >
                <div
                    v-for="notification in notifications.filter(n => n.type !== 'persistent')"
                    :key="notification.id"
                    class="max-w-sm w-full bg-white shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5 overflow-hidden">
                    <div class="p-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <!-- Heroicon name: outline/check-circle -->
                                <svg v-if="notification.type == 'success'" class="h-6 w-6 text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <svg v-else class="h-6 w-6 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" xmlns="http://www.w3.org/2000/svg" >
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-3 w-0 flex-1 pt-0.5">
                                <p class="text-sm font-medium text-gray-900">{{ notification.text }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </transition-group>
        </div>
    </div>
    <Dialog v-model:visible="persistentDialogVisible" :modal="true" @hide="persistentData = null" :dismissableMask="true">
        <div v-for="(message_type, key) in persistentData.text" :key="key">
            <template v-if="message_type.length > 0">
                <div v-if="key === 'errors'" class="text-red-500 mt-2 text-lg font-medium">
                    Neizdevās
                </div>
                <div v-else-if="key === 'success'" class="text-green-500 mt-2 text-lg font-medium">
                    Izdevās
                </div>
                <div v-for="(message, index) in message_type" :key="message+index">
                    {{ message }}
                </div>
            </template>
        </div>
    </Dialog>
</template>

<script>
import {computed, ref, watch} from "vue";
import {usePage} from "@inertiajs/inertia-vue3";
import Dialog from 'primevue/dialog'

export default {
    components: {Dialog},
    setup() {
        const openTime = 3000 // ms

        const notifications = ref([])
        const persistentData = ref(null)

        // used for identifier of the notification
        const lastId = ref(0)

        const persistentDialogVisible = ref(false)

        // watch(() => persistentData, () => {
        //     if (typeof persistentData.value !== "undefined" && persistentData.value)
        //         persistentDialogVisible.value = true
        // }, {deep: true})

        watch(() => usePage().props.value.flash.message, (newVal, oldVal) => {
            if (typeof newVal === "undefined" || newVal === null)
                return;

            // push new notification
            const notification = {'id': lastId.value, ...newVal}
            if (notification.type === 'persistent') {
                persistentData.value = newVal
                persistentDialogVisible.value = true
            }
            notifications.value.push(notification)

            // remove after openTime ms
            setTimeout(() => {
                const index = notifications.value.indexOf(notification)
                if (index !== -1) notifications.value.splice(index, 1)
            }, openTime)

            // increment id
            lastId.value++;
        })

        return {
            persistentData,
            notifications,
            persistentDialogVisible
        }
    },
}
</script>

<style scoped>
.notifications-move, /* apply transition to moving elements */
.notifications-enter-active,
.notifications-leave-active {
    transition: all 0.5s ease;
}

.notifications-enter-from,
.notifications-leave-to {
    opacity: 0;
    transform: translateX(30px);
}

/* ensure leaving items are taken out of layout flow so that moving
   animations can be calculated correctly. */
.notifications-leave-active {
    position: absolute;
}
</style>
