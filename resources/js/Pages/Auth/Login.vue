<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import Auth from '@/Layout/Auth.vue';
import Input from '@/Components/Input.vue';
import PasswordInput from '@/Components/PasswordInput.vue';

const form = useForm({
    email: null,
    password: null,
})

function submit(): void {
    form.post(route('login'), { replace: true })
}
</script>

<template>
    <Auth>
        <form @submit.prevent="submit"
            class="shadow-[rgba(17,_17,_26,_0.1)_0px_0px_16px] sm:rounded-xl w-full sm:w-[30rem] flex flex-col gap-8 p-5">
            <div class="text-center">
                <h1 class="text-2xl font-bold">
                    Login
                </h1>
                <p class="text-sm text-dark/50">
                    fill in your credentials to access your account
                </p>
            </div>

            <div>
                <Input v-model="form.email" :error="form.errors?.email" label="Email Address" id="email" />
                <PasswordInput v-model="form.password" :error="form.errors?.password" label="Password" id="password" />
            </div>

            <button class="btn">
                Login
            </button>
            <p class="text-sm text-center text-dark/50">
                you don't have an account? <A class="text-dark hover:underline" :href="route('register')">create one</A>
            </p>

        </form>
    </Auth>
</template>
