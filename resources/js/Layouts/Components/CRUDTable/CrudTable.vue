<template>
    <div>
        <div class="p-2 md:flex items-center">
            <h1 class="text-2xl tracking-tight font-semibold">{{ title ?? crudName }}</h1>
        </div>

        <div v-if="(Object.keys(specialPermissions).length === 0 && !hasAnyPermission([crudName + '_read']))
                    || (typeof specialPermissions['read'] !== 'undefined' && !hasAnyPermission([specialPermissions['read']]))">
            Jums nav piekļuve šai lapai ({{ crudName }}).
        </div>

        <template v-else>
            <DataTable
               ref="dt"
               :value="tableData" :paginator="pagination" :rows="perPage"
               paginatorTemplate="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown"
               :rowsPerPageOptions="[10,25,50,100]"
               currentPageReportTemplate="Rāda {first} - {last} no {totalRecords}"
               :globalFilterFields="searchFields"
               v-model:filters="filters"
               v-model:selection="selectedRows"
               dataKey="id"
               selectionMode="multiple"
               :metaKeySelection="false"
               class="p-datatable-md"
               :resizableColumns="true"

               filterDisplay="menu"

               v-model:expandedRows="expandedRows"
               rowGroupMode="subheader"
               :groupRowsBy="groupRowsBy"
            >
                <template #header>
                    <div class="lg:flex space-y-1 md:space-y-0">
                        <div class="grid grid-cols-1 space-y-1 md:space-y-0 lg:space-x-2 lg:flex ">
                            <Button v-if="hasAnyPermission([crudName + '_create']) && actions.create" icon="pi pi-plus" @click="createNewDialogOpen = true" label="Pievienot" />
    <!--                        <Button icon="pi pi-plus" disabled label="Importēt" />-->
                            <Button v-if="hasAnyPermission([crudName + '_export']) && actions['export']" @click="exportCSV" icon="pi pi-external-link" label="Eksportēt" />
                            <template v-if="typeof routeNames['exportExternal'] !== 'undefined'">
                                <a :href="route(routeNames['exportExternal'])">
                                    <Button icon="pi pi-external-link" label="Eksportēt (ārēji)" />
                                </a>
                            </template>
                            <template v-if="typeof routeNames['importExternal'] !== 'undefined' && hasAnyPermission([crudName + '_import'])">
                                <Link :href="route(routeNames['importExternal'])">
                                    <Button icon="pi pi-plus" label="Importēt (ārēji)" />
                                </Link>
                            </template>
                            <Button v-if="hasAnyPermission([crudName + '_delete']) && actions.massDelete" icon="pi pi-trash" class="p-button-danger" @click="massDelete" :disabled="selectedRows.length < 1" label="Dzēst atzīmētos" />
                        </div>
                        <span class="flex-1"></span>
                        <span class="w-full block lg:w-auto p-input-icon-left" v-if="searchable">
                            <i class="pi pi-search" />
                            <InputText class="w-full block lg:w-auto" v-model="filters['global'].value" placeholder="Meklēt..." />
                        </span>
                    </div>
                </template>

                <Column v-if="expandedRowsEnabled" :expander="true" headerStyle="width: 3rem" />
                <Column selectionMode="multiple" headerStyle="width: 1em"></Column>

                <template v-for="column in columns">
                    <Column
                        v-if="!column.hideInTable"
                        :field="column.name"
                        :header="column.header"
                        :sortable="column.sortable"
                        :style="column.style"
                        :showFilterMatchModes="!(!column.noFilter && column.type === 'dropdown')"
                    >
                            <!-- Filters -->
                            <template v-if="!column.noFilter && column.type === 'text' || column.type === 'textarea'" #filter="{filterModel,filterCallback}">
                                <InputText type="text" v-model="filterModel.value" @keydown.enter="filterCallback()" class="w-full"/>
                            </template>
                            <template v-else-if="!column.noFilter && column.type === 'dropdown'" #filter="{filterModel,filterCallback}">
                                <div class="font-semibold pb-2">
                                    Izvēlies vienu vai vairākus
                                </div>
                                <MultiSelect style="max-width: 20rem;" v-model="filterModel.value" :options="listings[column.listing]" :optionLabel="column.label" :optionValue="column.value">
                                    <template #option="slotProps">
                                        <div>
                                            <span>{{slotProps.option.name}}</span>
                                        </div>
                                    </template>
                                </MultiSelect>
                            </template>

                            <!-- Body -->
                            <template v-if="column.type === 'dropdown'" #body="slotProps">
                                <Dropdown
                                    :modelValue="getSlotPropsVal(slotProps, column.name)"
                                    :disabled="true"
                                    :options="listings[column.listing]"
                                    :optionLabel="column.label"
                                    :optionValue="column.value"
                                    class="w-full"
                                    style="pointer-events: all;"
                                    @click.stop=""
                                />
                            </template>

                            <template v-else-if="column.type === 'date'" #body="slotProps">
        <!--                        slotProps.data[column.name]-->
                                <Calendar style="width:170px;" dateFormat="dd.mm.yy"  :model-value="getSlotPropsVal(slotProps, column.name)" :disabled="true" />
                            </template>

                            <template v-else-if="column.type === 'multiselect'" #body="slotProps">
                                <div class="flex flex-wrap">
                                    <span
                                        v-for="theId in slotProps.data[column.name]"
                                        class="px-2 py-1 m-1 rounded-full text-blue-900 bg-blue-50 text-xs"
                                    >
                                        {{ listings[column.name].find(item => item.id === theId)[column.label] }}
                                    </span>
                                </div>
                            </template>

                            <template v-else #body="slotProps">
                                <span v-if="typeof slotProps.data[column.name] == 'string'" v-tooltip.top="column.showFullTextOnTooltip ? slotProps.data[column.name] : ''">
                                    {{ slotProps.data[column.name].substring(0,40) }}{{ slotProps.data[column.name].length > 40 ? '...' : '' }}
                                </span>
                            </template>

            <!--                <template v-else-if="column.tableColType === 'custom'" #body="slotProps">-->
            <!--                    <slot :name="'custom-col-' + column.name" v-bind:slotProps="slotProps">-->
            <!--                        <span class="accent-red-600">-->
            <!--                            THIS SHOULD NOT APPEAR-->
            <!--                        </span>-->
            <!--                    </slot>-->
            <!--                </template>-->
                    </Column>
                </template>

                <Column :exportable="false" style="min-width:8rem" class="space-x-2">
                    <template #body="slotProps">
                        <template v-if="hasAnyPermission([crudName + '_update']) && actions.update">
                            <i v-if="!routeNames.edit && requireEditPermissionPerRow && slotProps.data.editable" class="pi pi-pencil hover:bg-custom-main-400 rounded-full p-2 hover:bg-opacity-20" style="font-size: 1.2rem;" @click.stop="() => {startEdit(slotProps.data); viewOnly = false}" />
                            <i v-else-if="!routeNames.edit" class="pi pi-eye hover:bg-custom-main-400 rounded-full p-2 hover:bg-opacity-20" style="font-size: 1.2rem;" @click.stop="() => {startEdit(slotProps.data); viewOnly = true}" />
                            <Link v-else :href="route(routeNames.edit, slotProps.data.id)"><i  class="pi pi-pencil hover:bg-custom-main-400 rounded-full p-2 hover:bg-opacity-20" style="font-size: 1.2rem;" /></Link>
                        </template>
                        <i v-if="hasAnyPermission([crudName + '_delete']) && actions.delete" class="pi pi-trash text-red-600 hover:bg-custom-main-400 rounded-full p-2 hover:bg-opacity-20" style="font-size: 1.2rem;" @click.stop="confirmDeleteSingle($event, slotProps.data)" />
                    </template>
                </Column>

                <template v-if="groupRowsBy" #groupheader="slotProps">
                    <span class="image-text">{{slotProps.data.date}}</span>
                </template>

                <template v-if="expandedRowsEnabled" #expansion="slotProps">
                    <slot name="expansionSlot" v-bind:slotProps="slotProps">
                    </slot>
                </template>

            </DataTable>

            <Dialog v-model:visible="createNewDialogOpen" :header="labels?.createHeader ?? 'Create new'" :modal="true" class="p-fluid w-full m-2 md:m-0 md:w-3/5" :dismissableMask="true">
                    <ul class="text-red-500 list-disc mb-4 mx-4">
                        <li v-for="(err, key) in createForm.errors">
                            {{ err }}
                        </li>
                    </ul>

                    <form @submit.prevent="createNew" class="space-y-4" ref="theCreateForm">

                        <slot name="createDialogContent">
                            <div class="field" v-for="column in columns.filter(column => !(column['hideOnCreate']))">
                                <label :for="'create-' + column.name">{{ column.header }}<span v-if="column.required" class="text-red-500">*</span></label>

                                <InputText :name="column.name" v-if="column.type === 'text'" :id="'create-' + column.name" v-model.trim="createForm[column.name]" :required="column.required" autofocus :class="{'p-invalid': createForm.errors[column.name]}" />
                                <Textarea :name="column.name" v-else-if="column.type === 'textarea'" :id="'create-' + column.name" v-model.trim="createForm[column.name]" :required="column.required" autofocus :class="{'p-invalid': createForm.errors[column.name]}" />
                                <Dropdown :name="column.name" v-else-if="column.type === 'dropdown'" :id="'create-' + column.name" v-model="createForm[column.name]" :options="[{[column.label]: '-', [column.value]: null}, ...listings[column.listing]]" :optionLabel="column.label" :optionValue="column.value" />
                                <Calendar :name="column.name" v-else-if="column.type === 'date'" :id="'create-' + column.name" v-model="createForm[column.name]" :class="{'p-invalid': createForm.errors[column.name]}" />
                                <MultiSelect :name="column.name" v-else-if="column.type === 'multiselect'" :id="'create-' + column.name" v-model="createForm[column.name]" :options="listings[column.listing]" :optionLabel="column.label" :optionValue="column.value" :filter="true"/>
                                <div v-else>Unrecognized field.</div>

                                <small class="p-error" v-if="createForm.errors[column.name]">{{ createForm.errors[column.name] }}</small>
                            </div>
                        </slot>

                        <button type="submit" class="hidden"></button>
                    </form>
                <template #footer>
                    <Button label="Atcelt" icon="pi pi-times" class="p-button-text" @click="hideCreateNew"/>
                    <Button label="Saglabāt" icon="pi pi-check" class="p-button-text" @click="$refs.theCreateForm.requestSubmit()"/>
                </template>
            </Dialog>

            <Dialog v-model:visible="editDialogOpen" :header="labels?.editHeader ?? 'Edit'" :modal="true" class="p-fluid w-full m-2 md:m-0 md:w-3/5" :dismissableMask="true">
                <ValidationErrors :errors="updateSingle.errors"></ValidationErrors>

                <form @submit.prevent="updateSingle" class="space-y-4" ref="theEditForm">

                    <div class="field" v-for="column in columns.filter(column => !(column['hideOnEdit']))">
                        <label :for="'edit-' + column.name">{{ column.header }}<span v-if="column.required" class="text-red-500">*</span></label>
                        <InputText :disabled="viewOnly" :name="column.name" v-if="column.type === 'text'" :id="'edit-' + column.name" v-model.trim="editForm[column.name]" :required="column.required" autofocus :class="{'p-invalid': editForm.errors[column.name]}" />
                        <Textarea :disabled="viewOnly" :name="column.name" v-else-if="column.type === 'textarea'" :id="'edit-' + column.name" v-model.trim="editForm[column.name]" :required="column.required" autofocus :class="{'p-invalid': editForm.errors[column.name]}" />
                        <Dropdown :disabled="viewOnly" :name="column.name" v-else-if="column.type === 'dropdown'" :id="'edit-' + column.name" v-model="editForm[column.name]" :options="[{name: '-', id: null}, ...listings[column.listing]]" :optionLabel="column.label" :optionValue="column.value" :class="{'p-invalid': editForm.errors[column.name]}" />
                        <Calendar :disabled="viewOnly" :name="column.name" v-else-if="column.type === 'date'" :id="'edit-' + column.name" v-model="editForm[column.name]" :class="{'p-invalid': editForm.errors[column.name]}" />
                        <MultiSelect :disabled="viewOnly" :name="column.name" v-else-if="column.type === 'multiselect'" :id="'edit-' + column.name" v-model="editForm[column.name]" :options="listings[column.listing]" :optionLabel="column.label" :optionValue="column.value" :filter="true"/>
                        <div v-else>Unrecognized field.</div>

                        <small class="p-error" v-if="editForm.errors[column.name]">{{ editForm.errors[column.name] }}</small>
                    </div>

                    <button type="submit" class="hidden"></button>
                </form>
                <slot name="audits" :auditsProp="auditsForEditForm">
                </slot>
                <template #footer v-if="!viewOnly">
                    <div class="mt-6">
                        <Button label="Atcelt" icon="pi pi-times" class="p-button-text" @click="hideEditDialog"/>
                        <Button label="Saglabāt" icon="pi pi-check" class="p-button-text" @click="$refs.theEditForm.requestSubmit()" />
                    </div>
                </template>
            </Dialog>
        </template>
    </div>
</template>

<script>
import {computed, ref} from 'vue'
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Dialog from 'primevue/dialog';
import Dropdown from 'primevue/dropdown';
import Rating from 'primevue/rating';
import Calendar from 'primevue/calendar';
import InputNumber from 'primevue/inputnumber';
import Toolbar from 'primevue/toolbar';
import FileUpload from 'primevue/fileupload';
import Textarea from 'primevue/textarea';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import RadioButton from 'primevue/radiobutton';
import MultiSelect from 'primevue/multiselect';
import ColumnGroup from 'primevue/columngroup';     //optional for column grouping
import {FilterMatchMode,FilterOperator} from 'primevue/api';
import {useForm, usePage} from '@inertiajs/inertia-vue3'
import { useConfirm } from "primevue/useconfirm";
import { Link } from '@inertiajs/inertia-vue3';
import ValidationErrors from "@/Jetstream/ValidationErrors.vue";

export default {
    props: {
        tableData: Array,
        expansionChildName: String,
        groupRowsBy: {
            type: String,
            default: null
        },
        pagination: {
            type: Boolean,
            default: true
        },
        expandedRowsEnabled: {
            type: Boolean,
            default: false
        },
        header: {
            type: Boolean,
            default: true
        },
        listings: {
            type: Object,
            default: {}
        },
        actions: {
          type: Object,
          default: {
              create: true,
              export: true,
              update: true,
              delete: true,
              massDelete: true
          }
        },
        requireEditPermissionPerRow: {
            type: Boolean,
            default: false,
        },
        title: String,
        columns: Array,
        labels: {
            type: Object,
            default: {}
        },
        routeNames: {
            type: Object,
            default: {}
        },
        crudName: String,
        perPage: {
            type: Number,
            default: 25
        },
        specialPermissions: { // currently only for read implemented
            type: Object,
            default: {}
        },
        searchable: {
            type: Boolean,
            default: false
        },
        itIsGoalsPage: {
            type: Boolean,
            default: false
        }
    },
    components: {
        ValidationErrors,
        DataTable,
        Column,
        ColumnGroup,
        Dialog,
        InputNumber,
        RadioButton,
        Dropdown,
        Rating,
        Toolbar,
        FileUpload,
        Textarea,
        Button,
        InputText,
        MultiSelect,
        Calendar,
        Link,

    },
    name: "CrudTable",
    data() {
        return {
            expandedRows: [],
            filters: {
                "global": {value: null, matchMode: FilterMatchMode.CONTAINS}
            },
            viewOnly: false,
        }
    },
    methods: {
        // this is needed in case there is relational data
        getSlotPropsVal(slotProps, colName) {
            const data = slotProps.data
            const path = colName.split('.')
            let final_value = data;
            path.forEach(p => {
                final_value = final_value[p]
            })
            return final_value
        },
    },
    beforeMount() {
        this.columns.forEach(col => {
            if (!col.noFilter && (col.type === 'text' || col.type === 'textarea')) {
                this.filters[col.name] = {operator: FilterOperator.AND, constraints: [{value: null, matchMode: FilterMatchMode.CONTAINS}]}
            } else if (!col.noFilter && col.type === 'dropdown') {
                this.filters[col.name] = {value: null, matchMode: FilterMatchMode.IN}
            }
        })
    },
    setup (props, context) {
        const dt = ref(null) // automatically references

        const searchFields = computed(() => {
            return props.columns.map(column => {
                if (column.searchable !== undefined && column.searchable === true) {
                    return column.name
                } else {
                    return false;
                }
            }).filter(val => val)
        })

        const emptyFieldsCreate = {}
        const emptyFieldsEdit = {}

        props.columns.forEach(column => {
            if (column.hideOnCreate === undefined || column.hideOnCreate !== true) {
                emptyFieldsCreate[column.name] = ''
            }
            if (column.hideOnEdit === undefined || column.hideOnEdit !== true) {
                emptyFieldsEdit[column.name] = ''
            }
        })

        const selectedRows = ref([]);
        const createForm = useForm(emptyFieldsCreate)
        const editForm = useForm({'id': null, ...emptyFieldsEdit})
        const auditsForEditForm = ref(null)

        const createNewDialogOpen = ref(false)
        const editDialogOpen = ref(false)

        const massDelete = () => {
            if (!window.confirm('Patiešām izdzēst atzīmētos?'))
                return;

            const ids = selectedRows.value.map(row => row.id)

            useForm({ids: ids}).delete(route(props.routeNames.massDestroy), {
                onError: (err) => {alert('error'), console.log(err)},
                onSuccess: () => selectedRows.value = []
            })
        }

        const updateSingle = () => {
            editForm.put(route(props.routeNames.updateSingle, editForm.id),{
                onSuccess: () => hideEditDialog(),
                onError: () => {},
                onFinish: () => {},
            })
        };

        const createNew = () => {
            createForm.post(route(props.routeNames.storeSingle), {
                onSuccess: () => hideCreateNew(),
            })
        }

        const hideCreateNew = () => {
            createNewDialogOpen.value = false
            createForm.reset()
        }

        const hideEditDialog = () => {
            editDialogOpen.value = false
            editForm.reset()
        }

        const startEditByExternalForces = (id) => {
            const goal = props.tableData.find(obj => obj.id === id)
            if (goal) {
                startEdit(goal)
            } else {
                console.log('Could not locate such goal.')
            }
        }

        const startEdit = (newData) => {
            auditsForEditForm.value = newData.audits
            editDialogOpen.value = true
            editForm.id = newData.id
            Object.keys(emptyFieldsEdit).forEach(fieldKey => {
                editForm[fieldKey] = newData[fieldKey]
            })
        }

        const confirmDeleteSingle = (event, data) => {
            if (window.confirm('Patiešām izdzēst?'))
                useForm({}).delete(route(props.routeNames.singleDestroy, data.id), {
                    onError: () => alert('error'),
                    onSuccess: () => {}
                })
        }

        const exportCSV = () => {
            dt.value.exportCSV()
        }

        return {
            createForm,
            editForm,
            startEdit,
            confirmDeleteSingle,
            createNew,
            createNewDialogOpen,
            editDialogOpen,
            hideCreateNew,
            hideEditDialog,
            selectedRows,
            updateSingle,
            massDelete,
            exportCSV,
            dt,
            searchFields,
            auditsForEditForm,
            startEditByExternalForces
        }
    }
}
</script>

<style scoped>

</style>
