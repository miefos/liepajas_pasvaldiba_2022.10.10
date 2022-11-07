<template>
    <app-layout title="Users">
        <CrudTable
            :tableData="users"
            :columns="columns"
            :labels="labels"
            crud-name="user"
            title="Lietotāji"
            :route-names="routesName"
            :listings="listings"
        >
        </CrudTable>
    </app-layout>
</template>

<script>
import CrudTable from "@/Layouts/Components/CRUDTable/CrudTable.vue";

export default {
    name: "index",
    components: {CrudTable},
    props: {
        users: Array,
        listings: Object,
    },
    setup () {
        const labels = {
            createHeader: 'Izveidot lietotāju',
            editHeader: 'Atjaunot lietotāju'
        }

        const routesName = {
            massDestroy: 'users.massDestroy',
            updateSingle: 'users.update',
            storeSingle: 'users.invite', // send invite
            singleDestroy: 'users.destroy'
        }

        const columns = [
            {type: 'text', hideOnCreate: true, name: 'name', header: 'Vārds', sortable: true, searchable: true, required: true},
            {type: 'text', name: 'email', header: 'E-pasts', sortable: true, searchable: true, required: true},
            {type: 'multiselect', name: 'roles', label: 'name', listing: 'roles', value: 'id', header: 'Lomas'},
            {type: 'dropdown', name: 'entity_id', label: 'name',  listing: 'entities', value: 'id', header: 'Piederība', sortable: true},
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
