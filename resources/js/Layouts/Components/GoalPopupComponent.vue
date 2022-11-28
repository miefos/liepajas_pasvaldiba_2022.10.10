<template>
    <div class="p-0 lg:p-2 mt-12">
        <div class="space-y-8">
            <!-- First section -->
            <div>
                <div class="">
                    <div class="flex items-start space-x-3">
                        <div class="pt-3">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-custom-main-700">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.59 14.37a6 6 0 01-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 006.16-12.12A14.98 14.98 0 009.631 8.41m5.96 5.96a14.926 14.926 0 01-5.841 2.58m-.119-8.54a6 6 0 00-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 00-2.58 5.84m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 01-2.448-2.448 14.9 14.9 0 01.06-.312m-2.24 2.39a4.493 4.493 0 00-1.757 4.306 4.493 4.493 0 004.306-1.758M16.5 9a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                            </svg>
                        </div>
                        <div class="flex-1 space-y-2">
                            <input
                                v-model.trim="formData.name"
                                type="text"
                                name="name"
                                id="name"
                                class="-ml-1 block w-full bg-gray-50 border-b border-transparent focus:border-custom-main-600 font-semibold focus:ring-custom-main-600 focus:bg-white text-xl p-2 rounded-md"
                                placeholder="Mērķa nosaukums"
                                :class="{'p-invalid': formData.errors?.name, 'border-gray-600': !formData.name?.length}"
                            />
                            <small class="p-error" v-if="formData.errors?.name">{{ formData.errors?.name }}</small>
                            <div class="flex items-center space-x-2">
                                <Dropdown
                                          @change="updateOwner"
                                          v-model="owner" :options="listings.entitiesAndUsersGrouped" optionLabel="name" id="owner" name="owner"
                                          class="text-xs"
                                          optionGroupLabel="label"
                                          optionGroupChildren="items"
                                          :class="{'p-invalid': formData.errors?.entity_id || formData.errors.user_id}"
                                          placeholder="Izvēlies īpašnieku..."
                                >
                                    <template #optiongroup="slotProps">
                                        <div class="flex align-items-center bg-custom-main-100 p-4 m-0">
                                            <div>{{ slotProps.option.label }}</div>
                                        </div>
                                    </template>
                                    <template #option="slotProps">
                                        {{ slotProps.option.name }}
                                    </template>
                                </Dropdown>
                                <span> ir šī mērķa īpašnieks/-ce</span>
                            </div>
                            <div class="flex items-center space-x-2" v-if="owner?.id">
                                <Dropdown v-model="formData.parent_goal_id" :options="listings.availableGoals" optionLabel="name" optionValue="id" id="parent_goal_id" name="parent_goal_id"
                                          class="text-xs"
                                          placeholder="Izvēlies virsmērķi..."
                                >
                                    <template #option="slotProps">
                                        {{ slotProps.option.name }} <div class="text-xs text-gray-500">{{ slotProps.option.entity.name }}</div>
                                    </template>
                                </Dropdown>
                                <span> ir šī mērķa virsmērķis</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Second section -->
            <div>
                <div class="">
                    <div class="flex items-start space-x-3">
                        <div class="pt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-custom-main-700">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.59 14.37a6 6 0 01-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 006.16-12.12A14.98 14.98 0 009.631 8.41m5.96 5.96a14.926 14.926 0 01-5.841 2.58m-.119-8.54a6 6 0 00-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 00-2.58 5.84m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 01-2.448-2.448 14.9 14.9 0 01.06-.312m-2.24 2.39a4.493 4.493 0 00-1.757 4.306 4.493 4.493 0 004.306-1.758M16.5 9a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                            </svg>
                        </div>

                        <div class="flex-1 space-y-2">
                            <h3 class="text-lg">
                                Apraksts
                            </h3>
                            <div class="flex items-start space-x-3">
                                <textarea
                                    v-model.trim="formData.description"
                                    name="description"
                                    class="block w-full bg-gray-50 border-b focus:border-custom-main-600 focus:ring-custom-main-600 focus:bg-white p-2 rounded-md"
                                    :class="{'p-invalid': formData.errors?.description, 'border-gray-600': !formData.description?.length}"
                                />
                            </div>
                            <small class="p-error" v-if="formData.errors?.description">{{ formData.errors?.description }}</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Third section -->
            <div>
                <div class="">
                    <div class="flex items-start space-x-3">
                        <div class="pt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-custom-main-700">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                            </svg>
                        </div>

                        <div class="flex-1 space-y-2">
                            <h3 class="text-lg">
                                Izpildes līmenis
                            </h3>
                            <div class="flex items-center space-x-3">
                                <SelectButton v-model="formData.complete_level_id" :options="listings.completeLevels" optionLabel="name" optionValue="id">
                                </SelectButton>
                            </div>
                            <small class="p-error" v-if="formData.errors?.complete_level_id">{{ formData.errors?.complete_level_id }}</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Fourth section -->
            <div>
                <div class="">
                    <div class="flex items-start space-x-3">
                        <div class="pt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-custom-main-700">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0z" />
                            </svg>
                        </div>

                        <div class="flex-1 space-y-2">
                            <h3 class="text-lg">
                                Komentārs
                            </h3>
                            <textarea
                                v-model.trim="formData.comment"
                                name="comment"
                                class="block w-full bg-gray-50 border-b focus:border-custom-main-600 focus:ring-custom-main-600 focus:bg-white p-2 rounded-md"
                                :class="{'p-invalid': formData.errors?.comment, 'border-gray-600': !formData.comment?.length}"
                            />
                        </div>
                        <small class="p-error" v-if="formData.errors?.comment">{{ formData.errors?.comment }}</small>
                        </div>
                </div>
            </div>

            <!-- Fifth section -->
            <div>
                <div class="">
                    <div class="flex items-start space-x-3">
                        <div class="pt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-custom-main-700">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                            </svg>
                        </div>

                        <div class="flex-1 space-y-2">
                            <h3 class="text-lg">
                                Izpildes līmeņa nomaiņas vēsture
                            </h3>

                            <!-- audits -->
                            <div class="" v-if="auditsProp">
                                <div class="flow-root">
                                    <ul role="list" class="-mb-8">
                                        <li v-for="(completeLevelChange, completeLevelChangeIdx) in auditsProp" :key="completeLevelChange.id">
                                            <div class="relative pb-8">
                                                <span v-if="completeLevelChangeIdx !== auditsProp.length - 1" class="absolute top-3 left-3 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true" />
                                                <div class="relative flex space-x-3">
                                                    <div>
                                              <span class="h-6 w-6 rounded-full flex items-center justify-center bg-custom-main-500">
                                                  <svg color="white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                                                      <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                                                  </svg>
                                              </span>
                                                    </div>
                                                    <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1">
                                                        <div>
                                                            <p class="text-sm text-gray-500">
                                                                Tika nomainīts izpildes līmenis no
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { PaperClipIcon } from '@heroicons/vue/solid'

import InputText from 'primevue/inputtext';
import MultiSelect from 'primevue/multiselect';
import Textarea from 'primevue/textarea';
import Calendar from 'primevue/calendar';
import Dropdown from 'primevue/dropdown';
import SelectButton from 'primevue/selectbutton';

export default {
    name: "GoalPopupComponent",
    props: {columns: {type: Array}, auditsProp: {type: Array}, formData: {type: Object}, listings: {type: Object}, popupType: {type: String}},
    components: {
        PaperClipIcon,
        InputText,
        MultiSelect,
        Textarea,
        Dropdown,
        Calendar,
        SelectButton
    },
    data() {
       return {
           owner: null
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
        updateOwner(data) {
            console.log("Owner changed.")
            if (data.value.entity_type === 'user') {
                this.formData.user_id = data.value.id
                this.formData.entity_id = null
            } else if (data.value.entity_type === 'entity') {
                this.formData.user_id = null
                this.formData.entity_id = data.value.id
            } else {
                this.formData.user_id = null
                this.formData.entity_id = null
                console.log('ERR 5999') // this should not happen
                return
            }

            this.getAvailableGoals(data.value.entity_type, data.value.id)
        },
        getAvailableGoals (entity_type, id) {
            axios.get('getAvailableGoals/' + entity_type + '/' + id, {
            }).then(resp => {
                if (resp.data.status === 'OK') {
                    this.listings.availableGoals = resp.data.data
                } else {
                    alert('Notika kļūda 38823!')
                }
            })
        }
    },
    created() {
        if (!this.formData.complete_level_id) {
            this.formData.complete_level_id = this.listings.completeLevels[0].id
        }
        if (this.formData.user_id) {
            this.owner = this.listings.entitiesAndUsersGrouped?.find(group => group.label === 'Darbinieki')?.items.find(u => u.id === Number.parseInt(this.formData.user_id) && u.entity_type === 'user')
            this.getAvailableGoals('user', this.owner.id)
        } else if (this.formData.entity_id) {
            this.owner = this.listings.entitiesAndUsersGrouped?.find(group => group.label === 'Struktūrvienības')?.items.find(u => u.id === Number.parseInt(this.formData.entity_id) && u.entity_type === 'entity')
            this.getAvailableGoals('entity', this.owner.id)
        }
    }
}
</script>

<style scoped>
.p-dropdown {
    background-color: theme('colors.gray.50');
    border-color: theme("colors.custom-main-600");
    border-width: 0 0 1px 0;
    border-radius: 0;
    min-width: 200px;
}
.p-dropdown:hover {
    border-color: theme("colors.custom-main-800");
    transition: all 0.5s;
}
.p-dropdown:not(.p-disabled).p-focus {
    box-shadow: 0 1px 2px -2px theme("colors.custom-main-600");
    border-color: theme("colors.custom-main-600");
}
</style>
