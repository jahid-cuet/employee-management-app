<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import Spinner from '@/components/ui/spinner/Spinner.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Form, Head } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps<{
    permissions: Array<{ id: number; name: string }>;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Role Create',
        href: '/roles/create',
    },
];

// Hold selected permissions
const selectedPermissions = ref<number[]>([]);
</script>

<template>

    <Head title="Create Role" />

    <div class="space-y-4 p-4">
        <AppLayout :breadcrumbs="breadcrumbs">

            <div class="flex min-h-screen items-center justify-center bg-gray-100 p-4">
                <div class="w-full max-w-md rounded-xl bg-white p-6 shadow-md">
                    <Form action="/roles" method="post" :data="{ name: '', permissions: selectedPermissions }"
                        reset-on-success v-slot="{ errors, processing }">
                        <div class="space-y-6">
                            <!-- Role Name -->
                            <div class="grid gap-2">
                                <Label htmlFor="name">Role Name</Label>
                                <Input id="name" type="text" name="name" class="mt-1 block w-full" required />
                                <InputError :message="errors.name" />
                            </div>

                            <!-- Permissions checkboxes -->
                            <div class="space-y-2">
                                <Label>Permissions</Label>
                                <div class="grid grid-cols-2 gap-2">
                                    <div v-for="permission in props.permissions" :key="permission.id"
                                        class="flex items-center gap-2">
                                        <input type="checkbox" name="permissions[]" class="h-4 w-4 cursor-pointer"
                                            :value="permission.name" v-model="selectedPermissions" />

                                        <Label class="cursor-pointer">
                                            {{ permission.name }}
                                        </Label>
                                    </div>
                                </div>

                                <InputError :message="errors.permissions" />
                            </div>

                            <!-- Submit Button -->
                            <div class="flex items-center">
                                <Button variant="secondary" size="lg" class="cursor-pointer">
                                    <Spinner v-if="processing" />
                                    <span v-else>Create Role</span>
                                </Button>
                            </div>
                        </div>
                    </Form>
                </div>
            </div>
        </AppLayout>
    </div>
</template>
