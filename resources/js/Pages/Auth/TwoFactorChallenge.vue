<template>
<!--    <Head title="Two-factor Confirmation" />-->
    <Head title="2-Faktoru autentifikācijas apstiprināšana" />

    <jet-authentication-card>
        <div class="mb-4 text-sm text-gray-600">
            <template v-if="! recovery">
<!--                Please confirm access to your account by entering the authentication code provided by your authenticator application.-->
                Lūdzu, 2-FA ievadiet autentifikatora aplikācijas kodu.
            </template>

            <template v-else>
<!--                Please confirm access to your account by entering one of your emergency recovery codes.-->
                Lūdzu, ievadiet 2-FA atjaunināšanas kodu.
            </template>
        </div>

        <jet-validation-errors class="mb-4" />

        <form @submit.prevent="submit">
            <div v-if="! recovery">
<!--                <jet-label for="code" value="Code" />-->
                <jet-label for="code" value="Kods" />
                <jet-input ref="code" id="code" type="text" inputmode="numeric" class="mt-1 block w-full" v-model="form.code" autofocus autocomplete="one-time-code" />
            </div>

            <div v-else>
<!--                <jet-label for="recovery_code" value="Recovery Code" />-->
                <jet-label for="recovery_code" value="Atjaunināšanas kods" />
                <jet-input ref="recovery_code" id="recovery_code" type="text" class="mt-1 block w-full" v-model="form.recovery_code" autocomplete="one-time-code" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <button type="button" class="text-sm text-gray-600 hover:text-gray-900 underline cursor-pointer" @click.prevent="toggleRecovery">
                    <template v-if="! recovery">
<!--                        Use a recovery code-->
                        Izmantot atjaunināšanas kodu
                    </template>

                    <template v-else>
<!--                        Use an authentication code-->
                        Izmantot autentifikācijas aplikācijas kodu
                    </template>
                </button>

                <jet-button class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
<!--                    Log in-->
                    Ienākt
                </jet-button>
            </div>
        </form>
    </jet-authentication-card>
</template>

<script>
    import { defineComponent } from 'vue';
    import { Head } from '@inertiajs/inertia-vue3';
    import JetAuthenticationCard from '@/Jetstream/AuthenticationCard.vue'
    import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo.vue'
    import JetButton from '@/Jetstream/Button.vue'
    import JetInput from '@/Jetstream/Input.vue'
    import JetLabel from '@/Jetstream/Label.vue'
    import JetValidationErrors from '@/Jetstream/ValidationErrors.vue'

    export default defineComponent({
        components: {
            Head,
            JetAuthenticationCard,
            JetAuthenticationCardLogo,
            JetButton,
            JetInput,
            JetLabel,
            JetValidationErrors,
        },

        data() {
            return {
                recovery: false,
                form: this.$inertia.form({
                    code: '',
                    recovery_code: '',
                })
            }
        },

        methods: {
            toggleRecovery() {
                this.recovery ^= true

                this.$nextTick(() => {
                    if (this.recovery) {
                        this.$refs.recovery_code.focus()
                        this.form.code = '';
                    } else {
                        this.$refs.code.focus()
                        this.form.recovery_code = ''
                    }
                })
            },

            submit() {
                this.form.post('/two-factor-challenge')
            }
        }
    })
</script>
