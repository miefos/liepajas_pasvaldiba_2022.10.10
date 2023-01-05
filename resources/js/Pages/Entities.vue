<template>
    <app-layout>
        <organization-chart v-if="entitiesHierarchical" :value="entitiesHierarchical" key="id">
            <template #default="slotProps">
                <div class="space-y-4">
                    <div>{{ slotProps.node.data.name }}</div>
                    <div class="text-xs text-gray-700">{{ slotProps.node.data.supervisor.name }}</div>
<!--                    <div class="text-xs text-gray-700">-->
<!--                        {{ slotProps.node.data.completeLevel }}-->
<!--                    </div>-->
                </div>
            </template>
        </organization-chart>
        <div v-else>
            Nevar parādīt hierarhiju. Iespējams tāpēc, ka nav uzstādīta sākotnējā organizācija.
        </div>
        <crud-table
            :tableData="entities"
            :listings="listings"
            :columns="columns"
            :labels="labels"
            title=""
            crud-name="entity"
            :route-names="routesName"
        ></crud-table>
    </app-layout>
</template>

<script>
import CrudTable from "@/Layouts/Components/CRUDTable/CrudTable.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import OrganizationChart from "primevue/organizationchart";

export default {
    props: {
        entitiesHierarchical: Object,
        entities: Array,
        listings: Object,
    },
    components: {
        CrudTable,
        AppLayout,
        OrganizationChart
    },
    setup() {
        const labels = {
            createHeader: 'Izveidot',
            editHeader: 'Atjaunot'
        }

        const routesName = {
            massDestroy: 'entities.massDestroy',
            updateSingle: 'entities.update',
            storeSingle: 'entities.store',
            singleDestroy: 'entities.destroy'
        }

        const columns = [
            {type: 'text', name: 'name', header: 'Nosaukums', sortable: true, searchable: true, required: true},
            {type: 'dropdown', name: 'parent_entity_id', label: 'name',  listing: 'entities', value: 'id', header: 'Virsvienība', sortable: true},
            {type: 'dropdown', name: 'entity_level_id', label: 'name',  listing: 'entityLevels', value: 'id', header: 'Līmenis', sortable: true},
            {type: 'dropdown', name: 'supervisor_id', label: 'name',  listing: 'users', value: 'id', header: 'Vienības vadītājs', sortable: true},
            {type: 'dropdown', name: 'is_root_node', label: 'name', listing: 'booleanYesNo', value: 'value', header: 'Sākotnējā organizācija'}, // boolean option
        ]

        return {
            columns,
            labels,
            routesName
        }
    }
}
</script>
