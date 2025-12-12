<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { reactive, ref } from 'vue';

// Roles with permissions from backend
const roles = reactive([...usePage().props.roles]);

const breadcrumbs: BreadcrumbItem[] = [{ title: 'Roles', href: '/roles' }];

// Flash message
const { flash } = defineProps<{
    flash: {
        success?: string;
        error?: string;
    };
}>();
const showSuccess = ref(true);

// Delete modal state
const showDeleteModal = ref(false);
const deleteId = ref<number | null>(null);

// Open modal
function openDeleteModal(id: number) {
    deleteId.value = id;
    showDeleteModal.value = true;
}

// Confirm delete
function confirmDelete() {
    if (!deleteId.value) return;

    router.delete(`/roles/${deleteId.value}`, {
        onSuccess: () => {
            const index = roles.findIndex((r) => r.id === deleteId.value);
            if (index !== -1) roles.splice(index, 1);
            showDeleteModal.value = false;
        },
    });
}
</script>

<template>
    <Head title="Roles" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-4 p-4">
            <!-- Create Button -->
            <div class="mb-4">
                <Link href="/roles/create">
                    <Button class="cursor-pointer">Create Role</Button>
                </Link>
            </div>

            <!-- Flash -->
            <div
                v-if="showSuccess && flash.success"
                class="mb-4 flex items-center justify-between rounded bg-green-100 p-2 text-green-700"
            >
                <span>{{ flash.success }}</span>
                <button @click="showSuccess = false" class="px-2 font-bold">
                    ×
                </button>
            </div>

            <!-- Roles Table -->
            <table class="w-full table-auto border">
                <thead>
                    <tr class="bg-gray-100 text-center">
                        <th class="border px-4 py-2">ID</th>
                        <th class="border px-4 py-2">Role Name</th>
                        <th class="border px-4 py-2">Permissions</th>
                        <th class="border px-4 py-2">Edit</th>
                        <th class="border px-4 py-2">Delete</th>
                    </tr>
                </thead>

                <tbody>
                    <tr
                        v-for="role in roles"
                        :key="role.id"
                        class="text-center"
                    >
                        <td class="border px-4 py-2">
                            {{ role.id }}
                        </td>

                        <td class="border px-4 py-2">
                            {{ role.name }}
                        </td>

                        <td class="border px-4 py-2">
                            <span
                                v-for="perm in role.permissions"
                                :key="perm.id"
                                class="m-1 inline-block rounded bg-gray-200 px-2 py-1 text-xs text-gray-700"
                            >
                                {{ perm.name }}
                            </span>
                        </td>

                        <td class="border px-4 py-2">
                            <Link :href="`/roles/${role.id}/edit`">
                                <Button
                                    variant="secondary"
                                    size="lg"
                                    class="group h-9 w-9 cursor-pointer"
                                >
                                    Edit
                                </Button>
                            </Link>
                        </td>

                        <td class="border px-4 py-2">
                            <Button
                                variant="destructive"
                                size="lg"
                                class="group h-9 w-9 cursor-pointer"
                                @click="openDeleteModal(role.id)"
                            >
                                Delete
                            </Button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Delete Modal -->
        <div
            v-if="showDeleteModal"
            class="bg-opacity-30 fixed inset-0 z-50 flex items-center justify-cente"
        >
            <div class="w-80 space-y-4 rounded bg-white p-6 shadow-xl">
                <h2 class="text-lg font-bold text-red-600">Confirm Delete</h2>
                <p>Are you sure you want to delete this role?</p>

                <div class="flex justify-end gap-3">
                    <button
                        class="cursor-pointer rounded bg-gray-300 px-4 py-2"
                        @click="showDeleteModal = false"
                    >
                        Cancel
                    </button>

                    <button
                        class="cursor-pointer rounded bg-red-600 px-4 py-2 text-white"
                        @click="confirmDelete"
                    >
                        Delete
                    </button>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
