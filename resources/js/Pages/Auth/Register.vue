<template>
    <Head title="Reģistrācija" />

    <div class="min-h-screen flex flex-col justify-center py-4 sm:px-6 lg:px-8 login-page-background-image">
        <div v-if="imgReady" class="mt-6 sm:mx-auto bg-white sm:w-full sm:max-w-md shadow">

            <div class="sm:mx-auto mt-8 sm:w-full sm:max-w-md">
                <!--                <img class="mx-auto h-20 w-auto" src="/storage/images/logo.svg" alt="" />-->
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                    <!--                    Registration-->
                    Reģistrācija
                </h2>
            </div>

            <div class="bg-white py-8 px-4 sm:rounded-lg sm:px-10">
                <jet-validation-errors class="mb-4" />

                <form class="space-y-6" @submit.prevent="submit">

                    <div>
                        <jet-label for="name" value="Vārds" />
                        <jet-input name="name" id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus autocomplete="name" />
                    </div>

                    <div class="mt-4">
                        <jet-label for="email" value="E-pasts" />
                        <jet-input name="email" class="bg-gray-100 mt-1 block w-full" disabled id="email" type="email" :model-value="invitation.email" required />
                    </div>

                    <div class="mt-4">
                        <jet-label for="roles" value="Lomas" />
                        {{ invitation.roles?.map(role => role.name).join(', ') }}
                    </div>

                    <div class="mt-4">
                        <jet-label for="password" value="Parole" />
                        <jet-input name="password" id="password" type="password" class="mt-1 block w-full" v-model="form.password" required autocomplete="new-password" />
                    </div>

                    <div class="mt-4">
                        <jet-label for="password_confirmation" value="Parole atkārtoti" />
                        <jet-input name="password_confirmation" id="password_confirmation" type="password" class="mt-1 block w-full" v-model="form.password_confirmation" required autocomplete="new-password" />
                    </div>

                    <div class="flex items-center justify-end mt-4">

                        <jet-button class="ml-4 register-button" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Reģistrēties
                        </jet-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</template>

<script>
import {defineComponent, onMounted, ref} from 'vue'
import JetAuthenticationCard from '@/Jetstream/AuthenticationCard.vue'
import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo.vue'
import JetButton from '@/Jetstream/Button.vue'
import JetInput from '@/Jetstream/Input.vue'
import JetCheckbox from '@/Jetstream/Checkbox.vue'
import JetLabel from '@/Jetstream/Label.vue'
import JetValidationErrors from '@/Jetstream/ValidationErrors.vue'
import { Head, Link } from '@inertiajs/inertia-vue3';

export default defineComponent({
    components: {
        Head,
        JetAuthenticationCard,
        JetAuthenticationCardLogo,
        JetButton,
        JetInput,
        JetCheckbox,
        JetLabel,
        JetValidationErrors,
        Link,
    },

    props: {
        invitation: Object,
    },

    data() {
        return {
            form: this.$inertia.form({
                name: '',
                password: '',
                password_confirmation: '',
                token: this.invitation.invitation_token
            })
        }
    },

    methods: {
        submit() {
            this.form.post('register', {
                onFinish: () => this.form.reset('password', 'password_confirmation'),
            })
        }
    },

    setup() {
        // preload background image
        const imgReady = ref(false)
        onMounted (() => {
            let img = new Image();

            img.onload = () => {
                imgReady.value = true;
            }

            img.src = '/storage/images/login-page-background.jpg';
        })

        return {
            imgReady
        }
    }
})
</script>

<style>
.login-page-background-image {
    background-image: url("/storage/images/login-page-background.jpg");
    background-repeat: no-repeat;
    background-size: cover;
}
</style>
