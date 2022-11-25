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
                    <template v-if="slotProps.node.id > 0">
                        <i v-if="slotProps.node.data.editable" class="pi pi-pencil hover:bg-custom-main-400 rounded-full p-2 hover:bg-opacity-20" style="font-size: 1.2rem;" @click.stop="openDialog(slotProps.node.id, false)" />
                        <i v-else class="pi pi-eye hover:bg-custom-main-400 rounded-full p-2 hover:bg-opacity-20" style="font-size: 1.2rem;" @click.stop="openDialog(slotProps.node.id, true)" />
                    </template>

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
            :requireEditPermissionPerRow="true"
            ref="dtgoals"
        >
            <template #audits="props">
                <template  v-if="props.auditsProp">
                    <div>
                        <h4 class="h-3 py-4 mb-4 font-semibold">Izpildes izmaiņas</h4>
                    </div>
                    <div class="flow-root">
                        <ul role="list" class="-mb-8">
                            <li v-for="(completeLevelChange, completeLevelChangeIdx) in props.auditsProp" :key="completeLevelChange.id">
                                <div class="relative pb-8">
                                    <span v-if="completeLevelChangeIdx !== props.auditsProp.length - 1" class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true" />
                                    <div class="relative flex space-x-3">
                                        <div>
                                          <span class="h-8 w-8 rounded-full flex items-center justify-center ring-8 ring-white bg-custom-main-500">
                                              <svg color="white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                  <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                                              </svg>
                                          </span>
                                        </div>
                                        <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5">
                                            <div>
                                                <p class="text-sm text-gray-500">
                                                    Tika nomainīts no
                                                    <span class="font-semibold"> {{ findCompleteLevelNameById(completeLevelChange.old_values?.complete_level_id) }} </span>
                                                    uz
                                                    <span class="font-semibold"> {{ findCompleteLevelNameById(completeLevelChange.new_values?.complete_level_id) }} </span>
                                                </p>
                                            </div>
                                            <div class="whitespace-nowrap text-right text-sm text-gray-500">
                                                {{ dayjs(completeLevelChange.updated_at).fromNow() }}, {{ findUserNameById(completeLevelChange.user_id) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </template>
            </template>
        </crud-table>
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
    methods: {
      findCompleteLevelNameById (id) {
          const completeLevel = this.listings.completeLevels.find(level => level.id === id)
          return typeof completeLevel == "undefined" ? "UNDEFINED" : completeLevel.name
      },
      findUserNameById(id) {
          const user = this.listings.users.find(user => user.id === id)
          return typeof user == "undefined" ? "UNDEFINED" : user.name
      },
      openDialog(id, viewOnly) {
          this.$refs.dtgoals.viewOnly = viewOnly
          this.$refs.dtgoals.startEditByExternalForces(id);
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
