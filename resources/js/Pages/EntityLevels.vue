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
            {type: 'text', name: 'name', header: 'Nosaukums', searchable: true, required: true},
            {type: 'dropdown', name: 'parent_entity_level_id', label: 'name',  listing: 'entityLevels', value: 'id', header: 'Virstruktūras līmenis'},
            {type: 'dropdown', name: 'show_to_all', label: 'name', listing: 'booleanShowAll', value: 'value', header: 'Rādīt šī līmeņa mērķus visiem'}, // boolean option
            {type: 'dropdown', name: 'employee_level', label: 'name', listing: 'booleanEmployeeLevel', value: 'value', header: 'Darbinieka līmenis (tieši vienam no visiem jābūt atzīmētam)'}, // boolean option
            {type: 'dropdown', name: 'show_to_descendants', label: 'name', listing: 'booleanShowAll', value: 'value', header: 'Rādīt jebkuram līmenim zemāk visus šī līmeņa mērķus'}, // boolean option
            {type: 'dropdown', name: 'show_to_direct_descendant', label: 'name', listing: 'booleanShowAll', value: 'value', header: 'Rādīt tiešajam līmenim zemāk visus šī līmeņa mērķus'}, // boolean option
        ]

        return {
            columns,
            labels,
            routesName
        }
    }
}
</script>
