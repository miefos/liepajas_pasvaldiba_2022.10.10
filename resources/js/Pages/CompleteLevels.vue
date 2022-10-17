<template>
    <app-layout>
        <crud-table
            :tableData="completeLevels"
            :listings="listings"
            :columns="columns"
            :labels="labels"
            title=""
            crud-name="complete_level"
            :route-names="routesName"
        ></crud-table>
    </app-layout>
</template>

<script>
import CrudTable from "@/Layouts/Components/CRUDTable/CrudTable.vue";
import AppLayout from "@/Layouts/AppLayout.vue";

export default {
    props: {
        completeLevels: Array,
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
            massDestroy: 'complete_levels.massDestroy',
            updateSingle: 'complete_levels.update',
            storeSingle: 'complete_levels.store',
            singleDestroy: 'complete_levels.destroy'
        }

        const columns = [
            {type: 'text', name: 'name', header: 'Nosaukums', sortable: true, searchable: true, required: true},
            {type: 'text', name: 'value', header: 'Izpildes vērtība (skaitlis)', sortable: true, required: true},
        ]

        return {
            columns,
            labels,
            routesName
        }
    }
}
</script>
