<template>
    <div v-if="hasErrors">
        <div class="font-medium text-red-600">Kaut kas nogāja greizi.</div>

        <ul class="mt-3 list-disc list-inside text-sm text-red-600">
            <li v-for="(error, key) in errors" :key="key">{{ error }}</li>
        </ul>
    </div>
</template>

<script>
    import { defineComponent } from 'vue'

    export default defineComponent({
        props: {
            onlyComponentProps: {
                type: Boolean,
                default: false,
            },
            errorsFromProps: {
                type: Object,
                default: {}
            }
        },
        computed: {
            errors() {
                if (this.onlyComponentProps)
                    return this.errorsFromProps

                return this.$page.props.errors ?? this.errorsFromProps
            },

            hasErrors() {
                return Object.keys(this.errors).length > 0;
            },
        }
    })
</script>
