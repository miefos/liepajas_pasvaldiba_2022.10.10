<template>
    <app-layout>
        <crud-table
            :tableData="tasks"
            :listings="listings"
            :columns="columns"
            :labels="labels"
            title=""
            crud-name="task"
            :route-names="routesName"
        ></crud-table>
    </app-layout>
</template>

<script>
import CrudTable from "@/Layouts/Components/CRUDTable/CrudTable.vue";
import AppLayout from "@/Layouts/AppLayout.vue";

export default {
    props: {
        tasks: Array,
        listings: Object,
    },
    components: {
        CrudTable,
        AppLayout
    },
    setup() {
        const labels = {
            createHeader: 'Izveidot',
            editHeader: 'Atjaunot'
        }

        const routesName = {
            massDestroy: 'tasks.massDestroy',
            updateSingle: 'tasks.update',
            storeSingle: 'tasks.store',
            singleDestroy: 'tasks.destroy'
        }

        const columns = [
            {type: 'date', name: 'date', header: 'Datums', sortable: true, searchable: true, required: true},
            {type: 'text', name: 'name', header: 'Nosaukums', sortable: true, searchable: true, required: true},
            {type: 'textarea', name: 'description', header: 'Apraksts', searchable: true},
            {type: 'dropdown', name: 'goal_id', label: 'name',  listing: 'goals', value: 'id', header: 'Mērķis', sortable: true},
        ]

        return {
            columns,
            labels,
            routesName
        }
    }
}
</script>
