<template>
    <app-layout>
        <div class="w-full">
<!--        <organization-chart :value="goalsHierarchical" class="" :collapsible="true" :collapsedKeys="collapsedKeys">-->
<!--            <template #default="slotProps">-->
<!--                <div class="space-y-4">-->
<!--                    <div>{{ slotProps.node.data.name }}</div>-->
<!--                    <div class="text-xs text-gray-700">{{ slotProps.node.data.description }}</div>-->
<!--                    <div class="text-xs text-gray-700">{{ slotProps.node.data.entity?.name }}</div>-->
<!--                    <div class="text-xs text-gray-700">-->
<!--                        {{ slotProps.node.data.completeLevel }}-->
<!--                    </div>-->
<!--                    <div class="text-xs text-gray-700">-->
<!--                        {{ slotProps.node.data.comment }}-->
<!--                    </div>-->
<!--                    <template v-if="slotProps.node.id > 0">-->
<!--                        <i v-if="slotProps.node.data.editable" class="pi pi-pencil hover:bg-custom-main-400 rounded-full p-2 hover:bg-opacity-20" style="font-size: 1.2rem;" @click.stop="openDialog(slotProps.node.id, false)" />-->
<!--                        <i v-else class="pi pi-eye hover:bg-custom-main-400 rounded-full p-2 hover:bg-opacity-20" style="font-size: 1.2rem;" @click.stop="openDialog(slotProps.node.id, true)" />-->
<!--                    </template>-->

<!--                    &lt;!&ndash;                    <div v-if="slotProps.node.data.editable">&ndash;&gt;-->
<!--&lt;!&ndash;                        <i class="pi pi-pencil hover:bg-custom-main-400 rounded-full p-2 hover:bg-opacity-20" style="font-size: 1.2rem;" @click.stop="alert('edit')" />&ndash;&gt;-->
<!--&lt;!&ndash;                    </div>&ndash;&gt;-->
<!--                </div>-->
<!--            </template>-->
<!--        </organization-chart>-->
        </div>

        <crud-table
            :show-header="false"
            :tableData="goals"
            :listings="listings"
            :columns="columns"
            :labels="labels"
            title=""
            crud-name="goal"
            :route-names="routesName"
            :requireEditPermissionPerRow="true"
            ref="dtgoals"
        >
            <template #createDialogContent="{columns, createForm, listings}">
                <GoalPopupComponent :columns="columns" :formData="createForm" :listings="listings"></GoalPopupComponent>
            </template>
            <template #editDialogContent="{columns, editForm, listings, auditsProp}">
                <GoalPopupComponent popup-type="edit" :columns="columns" :formData="editForm" :listings="listings" :audits-prop="auditsProp"></GoalPopupComponent>
            </template>
        </crud-table>
    </app-layout>
</template>

<script>
import CrudTable from "@/Layouts/Components/CRUDTable/CrudTable.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import OrganizationChart from "primevue/organizationchart";

import InputText from 'primevue/inputtext';
import MultiSelect from 'primevue/multiselect';
import Textarea from 'primevue/textarea';
import Calendar from 'primevue/calendar';
import Dropdown from 'primevue/dropdown';
import GoalPopupComponent from "@/Layouts/Components/GoalPopupComponent.vue";

export default {
    props: {
        goalsHierarchical: Object,
        goals: Array,
        listings: Object,
    },
    components: {
        GoalPopupComponent,
        CrudTable,
        AppLayout,
        OrganizationChart,
        InputText,
        MultiSelect,
        Textarea,
        Dropdown,
        Calendar
    },
    data() {
      return {
          collapsedKeys: []
      }
    },
    methods: {
      openDialog(id, viewOnly) {
          this.$refs.dtgoals.viewOnly = viewOnly
          this.$refs.dtgoals.startEditByExternalForces(id);
      }
    },
    setup() {
        const labels = {
            createHeader: '',
            editHeader: ''
        }

        const routesName = {
            massDestroy: 'goals.massDestroy',
            updateSingle: 'goals.update',
            storeSingle: 'goals.store',
            singleDestroy: 'goals.destroy'
        }

        const columns = [
            {type: 'text', name: 'name', header: 'Nosaukums', sortable: true, searchable: true, required: true},
            {type: 'textarea', name: 'description', header: 'Apraksts', sortable: true, searchable: true, style: "min-width: 10rem; max-width: 20rem", showFullTextOnTooltip: true},
            {type: 'textarea', name: 'comment', header: 'Komentārs', sortable: true, searchable: true, hideInTable: true},
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
