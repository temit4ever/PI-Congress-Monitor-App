<template>
    <Head title="Log in" />
    <app-layout title="Dashboard">
        <template #header>
            <h2>
                Welcome
            </h2>
            <p>
                Omnis dio. Lorectatur? Luptatquibus parum renditi…
            </p>
        </template>
        <jet-authentication-card>

            <jet-validation-errors class="mb-4" />

            <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                {{ status }}
            </div>

            <div class="card card--narrow card--center">
                <div class="card__inner">
                    <img class="profile-image" src="../../../images/placeholder-profile.jpg">
                    <form @submit.prevent="submit" class="form form--max-width">
                        <div class="form__item">
                            <jet-input id="email" placeholder="Email" type="email" v-model="form.email" required autofocus />
                        </div>

                        <div class="form__item">
                            <jet-input id="password" placeholder="Password" :type="[showPassword ? 'text' : 'password']" v-model="form.password" required autocomplete="current-password" />
                            <span class="form__item-show-password" @click="showPassword = !showPassword">
                                Show password
                            </span>
                        </div>

                        <div class="form__item">
                            <label class="flex items-center">
                                <jet-checkbox name="remember" v-model:checked="form.remember" />
                                <span class="ml-2 text-sm text-gray-600">Remember me</span>
                            </label>
                        </div>

                        <div class="form__item">
                            <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Log in
                            </jet-button>
                        </div>
                        <div class="form__item">
                            <Link v-if="canResetPassword" :href="route('password.request')" class="underline text-sm text-gray-600 hover:text-gray-900">
                                Forgot your password?
                            </Link>
                        </div>
                    </form>
                </div>
            </div>
        </jet-authentication-card>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout.vue'
    import JetAuthenticationCard from '@/Jetstream/AuthenticationCard.vue'
    import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo.vue'
    import JetButton from '@/Jetstream/Button.vue'
    import JetInput from '@/Jetstream/Input.vue'
    import JetCheckbox from '@/Jetstream/Checkbox.vue'
    import JetLabel from '@/Jetstream/Label.vue'
    import JetValidationErrors from '@/Jetstream/ValidationErrors.vue'
    import { Head, Link } from '@inertiajs/inertia-vue3';

    export default {
        components: {
            Head,
            AppLayout,
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
            canResetPassword: Boolean,
            status: String
        },

        data() {
            return {
                form: this.$inertia.form({
                    email: '',
                    password: '',
                    remember: false
                }),
                showPassword: false
            }
        },

        methods: {
            submit() {
                this.form
                    .transform(data => ({
                        ... data,
                        remember: this.form.remember ? 'on' : ''
                    }))
                    .post(this.route('login'), {
                        onFinish: () => this.form.reset('password'),
                    })
            }
        }
    }
</script>
