<template>
    <app-layout>
        <crud-table
            :tableData="entityLevels"
            :listings="listings"
            :columns="columns"
            :labels="labels"
            title=""
            crud-name="entity_level"
            :route-names="routesName"
        ></crud-table>
    </app-layout>
</template>

<script>
import CrudTable from "@/Layouts/Components/CRUDTable/CrudTable.vue";
import AppLayout from "@/Layouts/AppLayout.vue";

export default {
    props: {
        entityLevels: Array,
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
            massDestroy: 'entity_levels.massDestroy',
            updateSingle: 'entity_levels.update',
            storeSingle: 'entity_levels.store',
            singleDestroy: 'entity_levels.destroy'
        }

        const columns = [
            {type: 'text', name: 'name', header: 'Nosaukums', sortable: true, searchable: true, required: true},
            {type: 'dropdown', name: 'parent_entity_level_id', label: 'name',  listing: 'entityLevels', value: 'id', header: 'Virstruktūras līmenis', sortable: true},
        ]

        return {
            columns,
            labels,
            routesName
        }
    }
}
</script>
