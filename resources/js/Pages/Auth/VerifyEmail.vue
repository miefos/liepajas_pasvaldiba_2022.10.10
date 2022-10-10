<template>
    <Head title="E-pasta apstiprināšana" />
<!--    <Head title="Email Verification" />-->

    <jet-authentication-card>
        <div class="mb-4 text-sm text-gray-600">
<!--            Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.-->
            Reģistrācija veiksmīga! Pirms sākt, lūdzu, apstipriniet e-pasta adresi.
        </div>

        <div class="mb-4 font-medium text-sm text-green-600" v-if="verificationLinkSent" >
<!--            A new verification link has been sent to the email address you provided during registration.-->
            Jauna verifikācijas saite tika nosūtīta uz norādīto e-pasta adresi.
        </div>

        <form @submit.prevent="submit">
            <div class="mt-4 flex items-center justify-between">
                <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
<!--                    Resend Verification Email-->
                    Atkārtoti nosūtīt verifikācijas saiti
                </jet-button>

<!--                <Link :href="route('logout')" method="post" as="button" class="underline text-sm text-gray-600 hover:text-gray-900">Log Out</Link>-->
                <Link href="/logout" method="post" as="button" class="underline text-sm text-gray-600 hover:text-gray-900">Iziet</Link>
            </div>
        </form>
    </jet-authentication-card>
</template>

<script>
    import { defineComponent } from 'vue'
    import JetAuthenticationCard from '@/Jetstream/AuthenticationCard.vue'
    import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo.vue'
    import JetButton from '@/Jetstream/Button.vue'
    import { Head, Link } from '@inertiajs/inertia-vue3';

    export default defineComponent({
        components: {
            Head,
            JetAuthenticationCard,
            JetAuthenticationCardLogo,
            JetButton,
            Link,
        },

        props: {
            status: String
        },

        data() {
            return {
                form: this.$inertia.form()
            }
        },

        methods: {
            submit() {
                this.form.post('/email/verification-notification')
            },
        },

        computed: {
            verificationLinkSent() {
                return this.status === 'verification-link-sent';
            }
        }
    })
</script>
