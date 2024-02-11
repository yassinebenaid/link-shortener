<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import Auth from '../Layout/Auth.vue';
import Input from '@/Components/Input.vue';
import PasswordInput from '@/Components/PasswordInput.vue';

const form = useForm({
    name: null,
    email: null,
    password: null,
    password_confirmation: null,
})

function submit(): void {
    form.post(route('register'), { replace: true })
}
</script>

<template>
    <Auth>
        <form @submit.prevent="submit"
            class="shadow-[rgba(17,_17,_26,_0.1)_0px_0px_16px] sm:rounded-xl w-full sm:w-[30rem] flex flex-col gap-8 p-5">
            <div class="text-center">
                <h1 class="text-2xl font-bold">
                    Register
                </h1>
                <p class="text-sm text-dark/50">
                    fill in your credentials to create your account
                </p>
            </div>

            <div>
                <Input v-model="form.name" :error="form.errors?.name" label="Name" id="name" />
                <Input v-model="form.email" :error="form.errors?.email" label="Email Address" id="email" />
                <PasswordInput v-model="form.password" :error="form.errors?.password" label="Password" id="password" />
                <PasswordInput v-model="form.password_confirmation" :error="form.errors?.password_confirmation"
                    label="Password" id="password_confirmation" />
            </div>

            <button class="btn">
                Login
            </button>
            <p class="text-sm text-center text-dark/50">
                Alreay have an account? <A class="text-dark hover:underline" :href="route('login')">login</A>
            </p>

        </form>
    </Auth>
</template>
