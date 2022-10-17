<template>
    <app-layout>

    </app-layout>
</template>

<script>
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
