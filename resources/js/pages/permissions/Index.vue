<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link, router,usePage } from '@inertiajs/vue3';
import Button from '@/components/ui/button/Button.vue';
import { type BreadcrumbItem } from '@/types';
import { ref,reactive } from 'vue';

// Reactive permissions array
const permissions = reactive([...usePage().props.permissions]);

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Permissions', href: '/permissions' },
];

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

    router.delete(`/permissions/${deleteId.value}`, {
        onSuccess: () => {
            const index = permissions.findIndex(p => p.id === deleteId.value);
            if (index !== -1) permissions.splice(index, 1);
            showDeleteModal.value = false;
        }
    });
}
</script>

<template>
    <Head title="permissions" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4 space-y-4">
            <!-- Create Button -->
            <div class="mb-4">
                <Link href="/permissions/create">
                    <Button class="cursor-pointer">Create Permission</Button>
                </Link>
            </div>

            <!-- Flash -->
            <div v-if="showSuccess && flash.success"
                 class="bg-green-100 text-green-700 p-2 rounded mb-4 flex justify-between items-center">
                <span>{{ flash.success }}</span>
                <button @click="showSuccess = false" class="font-bold px-2">×</button>
            </div>

            <!-- permissions Table -->
            <table class="w-full table-auto border">
                <thead>
                    <tr class="bg-gray-100 text-center">
                        <th class="px-4 py-2 border">ID</th>
                        <th class="px-4 py-2 border">Title</th>
                        
                        <th class="px-4 py-2 border">Edit</th>
                        <th class="px-4 py-2 border">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="permission in permissions" :key="permission.id" class="text-center">
                        <td class="px-4 py-2 border">{{ permission.id }}</td>
                        <td class="px-4 py-2 border">{{ permission.name }}</td>

                        <td class="px-4 py-2 border">
                            <Link :href="`/permissions/${permission.id}/edit`">
                                <Button variant="secondary" size="lg"
                                        class="group h-9 w-9 cursor-pointer">Edit</Button>
                            </Link>
                        </td>
                        <td class="px-4 py-2 border">
                            <Button variant="destructive" size="lg"
                                    class="group h-9 w-9 cursor-pointer"
                                    @click="openDeleteModal(permission.id)">
                                Delete
                            </Button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Delete Modal -->
        <div v-if="showDeleteModal"
             class="fixed inset-0bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded shadow-xl w-80 space-y-4">
                <h2 class="text-lg font-bold text-red-600">Confirm Delete</h2>
                <p>Are you sure you want to delete this permission?</p>
                <div class="flex justify-end gap-3">
                    <button class="px-4 py-2 bg-gray-300 rounded cursor-pointer"
                            @click="showDeleteModal = false">
                        Cancel
                    </button>
                    <button class="px-4 py-2 bg-red-600 text-white rounded cursor-pointer"
                            @click="confirmDelete">
                        Delete
                    </button>
                </div>
            </div>
        </div>

    </AppLayout>
</template>
