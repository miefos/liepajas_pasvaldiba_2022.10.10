<template>
    <app-layout title="Permissions">
        <crud-table
            :tableData="permissions"
            :columns="columns"
            :fields="fields"
            :route-names="routesName"
            title="Atļaujas"
            crud-name="permission"
            :per-page="50"
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
        const labels = {
            createHeader: 'Izveidot atļauju',
            editHeader: 'Atjaunot atļauju'
        }

        const routesName = {
            massDestroy: 'permissions.massDestroy',
            updateSingle: 'permissions.update',
            storeSingle: 'permissions.store',
            singleDestroy: 'permissions.destroy'
        }

        const columns = [
            {type: 'text', name: 'name', header: 'Name', sortable: true, searchable: true, required: true},
        ]

        const fields = [
            {name: 'name'},
        ]



        return {
            columns,
            fields,
            labels,
            routesName,
        }
    }
}
</script>

<style scoped>

</style>
