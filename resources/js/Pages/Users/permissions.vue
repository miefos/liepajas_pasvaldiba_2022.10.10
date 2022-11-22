<template>
    <app-layout title="Permissions">
        <crud-table
            :tableData="permissions"
            :columns="columns"
            :route-names="[]"
            title="Atļaujas"
            crud-name="permission"
            :actions="{create: false,export: true,update: false,delete: false,massDelete: false}"
            :per-page="100"
        ></crud-table>
    </app-layout>
</template>

<script>
import CrudTable from "@/Layouts/Components/CRUDTable/CrudTable.vue";

export default {
    props: {
        permissions: Array,
        listings: Object,
    },
    components: {CrudTable},
    setup() {

        const columns = [
            {type: 'text', name: 'name', header: 'Name', sortable: true, searchable: true, required: true},
        ]

        return {
            columns,
        }
    }
}
</script>

<style scoped>

</style>
