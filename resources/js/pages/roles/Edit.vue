<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import Spinner from '@/components/ui/spinner/Spinner.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps<{
    role: {
        id: number;
        name: string;
        permissions: Array<{ id: number; name: string }>;
    };
    permissions: Array<{ id: number; name: string }>;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Roles', href: '/roles' },
    { title: 'Edit Role', href: `/roles/${props.role.id}/edit` },
];

// Use Inertia useForm
const form = useForm({
    name: props.role.name,
    permissions: props.role.permissions.map((p) => p.id), // array of IDs
});
</script>

<template>
    <Head title="Edit Role" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex min-h-screen items-center justify-center bg-gray-100 p-4"
        >
            <div class="w-full max-w-md rounded-xl bg-white p-6 shadow-md">
                <form
                    @submit.prevent="form.put(`/roles/${props.role.id}`)"
                    class="space-y-6"
                >
                    <!-- Role Name -->
                    <div class="grid gap-2">
                        <Label for="name">Role Name</Label>
                        <Input
                            id="name"
                            v-model="form.name"
                            type="text"
                            required
                        />
                        <InputError :message="form.errors.name" />
                    </div>

                    <!-- Permissions -->
                    <div class="space-y-2">
                        <Label>Permissions</Label>
                        <div class="grid grid-cols-2 gap-2">
                            <div
                                v-for="perm in props.permissions"
                                :key="perm.id"
                                class="flex items-center gap-2"
                            >
                                <input
                                    type="checkbox"
                                    :value="perm.id"
                                    v-model="form.permissions"
                                    class="h-4 w-4 cursor-pointer"
                                />
                                <Label class="cursor-pointer">{{
                                    perm.name
                                }}</Label>
                            </div>
                        </div>
                        <InputError :message="form.errors.permissions" />
                    </div>

                    <!-- Submit -->
                    <div class="flex items-center">
                        <Button
                            variant="secondary"
                            size="lg"
                            class="cursor-pointer"
                            :disabled="form.processing"
                        >
                            <Spinner v-if="form.processing" />
                            <span v-else>Update Role</span>
                        </Button>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
