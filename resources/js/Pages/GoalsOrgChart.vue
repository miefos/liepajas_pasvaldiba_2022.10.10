<template>
    <app-layout>
        <organization-chart :value="goals" key="id">
            <template #default="slotProps">
                <div>{{ slotProps.node.data.name }}</div>
                <div class="text-xs text-gray-700">{{ slotProps.node.data.description }}</div>
                <div class="text-xs text-gray-700">
                    {{ slotProps.node.data.completeLevel }}
                </div>
            </template>
        </organization-chart>
    </app-layout>
</template>

<script>
import OrganizationChart from "primevue/organizationchart";
import AppLayout from "@/Layouts/AppLayout.vue";

export default {
    props: {
        goals: Object,
        listings: Object,
    },
    components: {
        OrganizationChart,
        AppLayout,
    },
}
</script>
