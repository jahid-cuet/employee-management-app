<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import Button from '@/components/ui/button/Button.vue';
import { reactive, ref } from 'vue';
import { type BreadcrumbItem } from '@/types';

// Page props
const { employees } = usePage().props as any;

// Reactive employee list
const employeeList = reactive([...employees.data]);

// Flash message (make reactive)
const { flash } = defineProps<{ flash: { success?: string; error?: string } }>();
const showSuccess = ref(true);

// Breadcrumbs (optional)
const breadcrumbs: BreadcrumbItem[] = [{ title: 'Employees', href: '/employees' }];

// Delete modal state
const showDeleteModal = ref(false);
const deleteId = ref<number | null>(null);

// Open delete modal
function openDeleteModal(id: number) {
    deleteId.value = id;
    showDeleteModal.value = true;
}

// Confirm delete
function confirmDelete() {
    if (!deleteId.value) return;

    router.delete(`/employees/${deleteId.value}`, {
        onSuccess: () => {
            // Remove from reactive list
            const index = employeeList.findIndex((e: any) => e.id === deleteId.value);
            if (index !== -1) employeeList.splice(index, 1);

            // Update flash message
            flash.success = 'Employee deleted successfully!';
            showSuccess.value = true;

            // Close modal
            deleteId.value = null;
            showDeleteModal.value = false;
        },
    });
}
</script>

<template>
    <Head title="Employees" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-4 p-4">

            <!-- Flash Message -->
            <div
                v-if="showSuccess && flash?.success"
                class="flex items-center justify-between rounded bg-green-100 p-2 text-green-700"
            >
                <span>{{ flash.success }}</span>
                <button class="px-2 font-bold" @click="showSuccess = false">×</button>
            </div>

            <!-- Create Employee -->
            <Link href="/employees/create">
                <Button size="sm" variant="secondary" class="cursor-pointer">Create Employee</Button>
            </Link>

            <!-- Employee Table -->
            <table class="mt-4 w-full border">
                <thead>
                    <tr class="bg-gray-100 text-center">
                        <th class="border p-2">Employee ID</th>
                        <th class="border p-2">Name</th>
                        <th class="border p-2">Email</th>
                        <th class="border p-2">Designation</th>
                        <th class="border p-2">Salary</th>
                        <th class="border p-2">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="employee in employeeList" :key="employee.id" class="text-center">
                        <td class="border p-2">{{ employee.employee_id }}</td>
                        <td class="border p-2">{{ employee.name }}</td>
                        <td class="border p-2">{{ employee.email }}</td>
                        <td class="border p-2">{{ employee.designation }}</td>
                        <td class="border p-2">{{ employee.salary }}</td>
                        <td class="border p-2 space-x-2">
                            <Link :href="`/employees/${employee.id}/edit`">
                                <Button size="sm" variant="secondary" class="cursor-pointer">Edit</Button>
                            </Link>
                            <Button size="sm" variant="destructive" class="cursor-pointer"
                                    @click="openDeleteModal(employee.id)">
                                Delete
                            </Button>
                        </td>
                    </tr>

                    <tr v-if="employeeList.length === 0">
                        <td colspan="6" class="p-4 text-center text-gray-500">No employees found</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Delete Confirmation Modal -->
        <div v-if="showDeleteModal" class="fixed inset-0 z-50 flex items-center justify-center bg-opacity-30">
            <div class="w-80 space-y-4 rounded bg-white p-6 shadow-xl">
                <h2 class="text-lg font-bold text-red-600">Confirm Delete</h2>
                <p>Are you sure you want to delete this employee?</p>
                <div class="flex justify-end gap-3">
                    <button class="rounded bg-gray-300 px-4 py-2 cursor-pointer" @click="showDeleteModal = false">Cancel</button>
                    <button class="rounded bg-red-600 px-4 py-2 text-white cursor-pointer" @click="confirmDelete">Delete</button>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
