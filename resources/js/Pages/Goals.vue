<template>
    <app-layout>
        <div class="w-full">
        <organization-chart :value="goalsHierarchical" class="" :collapsible="true" :collapsedKeys="collapsedKeys">
            <template #default="slotProps">
                <div class="space-y-4">
                    <div>{{ slotProps.node.data.name }}</div>
                    <div class="text-xs text-gray-700">{{ slotProps.node.data.description }}</div>
                    <div class="text-xs text-gray-700">{{ slotProps.node.data.entity?.name }}</div>
                    <div class="text-xs text-gray-700">
                        {{ slotProps.node.data.completeLevel }}
                    </div>
                    <div class="text-xs text-gray-700">
                        {{ slotProps.node.data.comment }}
                    </div>
<!--                    <div v-if="slotProps.node.data.editable">-->
<!--                        <i class="pi pi-pencil hover:bg-custom-main-400 rounded-full p-2 hover:bg-opacity-20" style="font-size: 1.2rem;" @click.stop="alert('edit')" />-->
<!--                    </div>-->
                </div>
            </template>
        </organization-chart>
        </div>

        <crud-table
            :tableData="goals"
            :listings="listings"
            :columns="columns"
            :labels="labels"
            title=""
            crud-name="goal"
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
        goalsHierarchical: Object,
        goals: Array,
        listings: Object,
    },
    components: {
        CrudTable,
        AppLayout,
        OrganizationChart
    },
    data() {
      return {
          collapsedKeys: []
      }
    },
    setup() {
        const labels = {
            createHeader: 'Izveidot',
            editHeader: 'Atjaunot'
        }

        const routesName = {
            massDestroy: 'goals.massDestroy',
            updateSingle: 'goals.update',
            storeSingle: 'goals.store',
            singleDestroy: 'goals.destroy'
        }

        const columns = [
            {type: 'text', name: 'name', header: 'Nosaukums', sortable: true, searchable: true, required: true},
            {type: 'textarea', name: 'description', header: 'Apraksts', sortable: true, searchable: true},
            {type: 'textarea', name: 'comment', header: 'Komentārs', sortable: true, searchable: true},
            {type: 'dropdown', name: 'parent_goal_id', label: 'name',  listing: 'goals', value: 'id', header: 'Virsmērķis', sortable: true},
            {type: 'dropdown', name: 'complete_level_id', label: 'name',  listing: 'completeLevels', value: 'id', header: 'Izpilde', sortable: true, required: true},
            {type: 'dropdown', name: 'entity_id', label: 'name',  listing: 'entities', value: 'id', header: 'Struktūrvienība', sortable: true},
            {type: 'dropdown', name: 'user_id', label: 'name',  listing: 'users', value: 'id', header: 'Darbinieks', sortable: true},
        ]

        return {
            columns,
            labels,
            routesName
        }
    }
}
</script>
