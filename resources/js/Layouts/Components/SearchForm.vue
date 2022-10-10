<template>
    <div class="md:mt-0 md:ml-2 relative rounded-md md:-mb-1">
        <input :value="modelValue"
               @input="searchChange" @keyup.esc="clearSearchField" type="text" class="md:text-md placeholder-gray-700 w-full pr-6 focus:ring-sky-500 focus:border-sky-500 block w-full border-gray-300 rounded-md" :class="short ? 'w-20' : ''" :placeholder="placeholder" />
        <div v-if="showX" class="absolute inset-y-0 right-0 pr-3 flex items-center">
            <XIcon @click="clearSearchField" class="h-4 w-4 md:text-sm" :class="modelValue.length > 0 ? 'text-gray-600 cursor-pointer' : 'text-gray-200'" aria-hidden="true" />
        </div>
    </div>
</template>

<script>
import {
    XIcon
} from '@heroicons/vue/solid'
export default {
    name: "SearchForm",
    components: {
        XIcon
    },
    emits: ['update:modelValue'],
    props: {
        modelValue: String,
        placeholder: {
            type: String,
            default: "Meklēt"
        },
        short: {
            type: Boolean,
            default: false
        },
        showX: {
            type: Boolean,
            default: true
        }
    },
    methods: {
        searchChange (e) {
            let val = ''
            if (typeof e === "string")
                val = e
            else
                val = e.target.value
            this.$emit('update:modelValue', val);
        },
        clearSearchField() {
            this.searchChange('');
        }
    }
}
</script>

<style scoped>
</style>
