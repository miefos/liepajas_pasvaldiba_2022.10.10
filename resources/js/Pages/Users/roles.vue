<template>
    <app-layout title="Dashboard">
        <crud-table
            :tableData="roles"
            :columns="columns"
            crud-name="role"
            title="Lomas"
            :labels="labels"
            :route-names="routesName"
            :listings="listings"
            :per-page="50"
        >
        </crud-table>
    </app-layout>
</template>

<script>
import CrudTable from "@/Layouts/Components/CRUDTable/CrudTable.vue";
import Chip from "primevue/chip"

export default {
    name: "index",
    components: {CrudTable, Chip},
    props: {
        roles: Array,
        listings: Object,
    },
    setup () {
        const labels = {
            createHeader: 'Izveidot lomu',
            editHeader: 'Atjaunot lomu'
        }

        const routesName = {
            massDestroy: 'roles.massDestroy',
            updateSingle: 'roles.update',
            storeSingle: 'roles.store',
            singleDestroy: 'roles.destroy'
        }

        const columns = [
            {type: 'text', name: 'name', header: 'Nosaukums', sortable: true, searchable: true, required: true},
            {type: 'multiselect', name: 'permissions', label: 'name', listing: 'permissions', value: 'id', header: 'Atļaujas'},
        ]

        return {
            columns,
            labels,
            routesName
        }
    }
}
</script>

<style scoped>

</style>
