<template>
    <Head title="Ienākt" />
    <div class="min-h-screen flex flex-col justify-center py-4 px-2 sm:px-6 lg:px-8 login-page-background-image">
        <div v-if="imgReady" class="mt-6 sm:mx-auto bg-white sm:w-full sm:max-w-md rounded-md shadow">

            <div class="sm:mx-auto mt-8 sm:w-full sm:max-w-md">
<!--                <img class="mx-auto h-20 w-auto" src="/storage/images/logo.svg" alt="" />-->
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                    Ienākt
                </h2>
            </div>

            <div class="bg-white py-8 px-4 sm:rounded-lg sm:px-10">
                <jet-validation-errors class="mb-4" />
                <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                    {{ status }}
                </div>

                <form class="space-y-6" @submit.prevent="submit">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">
                            E-pasta adrese
                        </label>
                        <div class="mt-1">
                            <input id="email" name="email" type="email" autocomplete="email" v-model="form.email" required="" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-0 focus:border-sky-500 sm:text-sm" />
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">
                            Parole
                        </label>
                        <div class="mt-1">
                            <input id="password" name="password" v-model="form.password" type="password" autocomplete="current-password" required="" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-0 focus:border-sky-500 sm:text-sm" />
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember-me" name="remember-me" type="checkbox" v-model="form.remember" class="h-4 w-4 text-sky-600 focus:ring-0 border-gray-300 rounded" />
                            <label for="remember-me" class="ml-2 block text-sm text-gray-900">
                                Atcerēties mani
                            </label>
                        </div>

                        <div class="text-sm">
                            <a v-if="canResetPassword" href="/forgot-password" class="font-medium text-sky-600 hover:text-sky-500">
                                Aizmirsi paroli?
                            </a>
                        </div>
                    </div>

                    <div>
                        <button type="submit" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-sky-600 hover:bg-sky-700 focus:outline-none focus:ring-0">
                            Ienākt
                        </button>
                    </div>
<!--                    <div class="">-->
<!--                        <a href="/forgot-password">Aizmirsi paroli?</a>-->
<!--                    </div>-->
                </form>

<!--                <div class="text-sm mt-2">-->
<!--                    <Link :href="route('register')" class="font-medium text-sky-600 hover:text-sky-500">-->
<!--                        Not yet registered?-->
<!--                    </Link>-->
<!--                </div>-->
            </div>
        </div>
    </div>
</template>

<script>
    import { Head, Link } from '@inertiajs/inertia-vue3';
    import JetValidationErrors from "@/Jetstream/ValidationErrors.vue"
    import {onMounted, ref} from "vue";

    export default {
        components: {
            Head,
            Link,
            JetValidationErrors
        },

        props: {
            canResetPassword: Boolean,
            status: String,
            app: {
                type: Object,
                default: {name: ''}
            }
        },

        data() {
            return {
                form: this.$inertia.form({
                    email: '',
                    password: '',
                    remember: true
                })
            }
        },

        methods: {
            submit() {
                this.form
                    .transform(data => ({
                        ... data,
                        remember: this.form.remember ? 'on' : ''
                    }))
                    .post('/login', {
                        onSuccess: () => {
                            location.reload() // must reload to load ziggy's routes
                        },
                        onFinish: () => {
                            this.form.reset('password');
                        },
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

                setTimeout(() => imgReady.value = true, 2000);
            })

            return {
                imgReady
            }
        }
    }
</script>

<style>
.login-page-background-image {
    background-image: url("/storage/images/login-page-background.jpg");
    background-repeat: no-repeat;
    background-size: cover;
}
</style>
