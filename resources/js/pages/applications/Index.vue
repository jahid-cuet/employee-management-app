<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, router, usePage } from '@inertiajs/vue3';
import Button from '@/components/ui/button/Button.vue';
import { reactive, ref } from 'vue';

// Props from backend
const { pendingApplications, acceptedApplications, rejectedApplications, flash } = usePage().props as any;

// Reactive lists
const pendingList = reactive([...pendingApplications]);
const acceptedList = reactive([...acceptedApplications]);
const rejectedList = reactive([...rejectedApplications]);

// Flash message
const showSuccess = ref(true);

// Reject modal
const showRejectModal = ref(false);
const rejectId = ref<number | null>(null);
const adminNote = ref('');

// Current tab: 'pending' | 'accepted' | 'rejected'
const currentTab = ref('pending');

// Functions
function openRejectModal(id: number) {
    rejectId.value = id;
    adminNote.value = '';
    showRejectModal.value = true;
}

function acceptApplication(id: number) {
    router.put(`/applications/${id}/status`, { status: 'accepted' }, {
        onSuccess: () => {
            const index = pendingList.findIndex((a: any) => a.id === id);
            if (index !== -1) {
                const app = pendingList.splice(index, 1)[0];
                acceptedList.push(app); // move to accepted tab
            }
        }
    });
}

function confirmReject() {
    if (!rejectId.value) return;

    router.put(`/applications/${rejectId.value}/status`, {
        status: 'rejected',
        admin_note: adminNote.value
    }, {
        onSuccess: () => {
            const index = pendingList.findIndex((a: any) => a.id === rejectId.value);
            if (index !== -1) {
                const app = pendingList.splice(index, 1)[0];
                rejectedList.push(app); 
            }
            showRejectModal.value = false;
            rejectId.value = null;
            adminNote.value = '';
        }
    });
}
</script>

<template>

    <Head title="Applications Review" />

    <AppLayout>
        <div class="space-y-4 p-4">

            <!-- Flash -->
            <div v-if="showSuccess && flash"
                class="flex items-center justify-between rounded bg-green-100 p-2 text-green-700">
                <span>{{ flash }}</span>
                <button class="px-2 font-bold" @click="showSuccess = false">×</button>
            </div>

            <!-- Tabs -->
            <div class="flex gap-4 border-b">
                <button class="cursor-pointer" @click="currentTab = 'pending'"
                    :class="{ 'border-b-2 border-blue-600 font-bold ': currentTab === 'pending' }">Pending</button>
                <button class="cursor-pointer" @click="currentTab = 'accepted'"
                    :class="{ 'border-b-2 border-blue-600 font-bold cursor-pointer': currentTab === 'accepted' }">Accepted</button>
                <button class="cursor-pointer" @click="currentTab = 'rejected'"
                    :class="{ 'border-b-2 border-blue-600 font-bold cursor-pointer': currentTab === 'rejected' }">Rejected</button>
            </div>

            <!-- Table -->
            <table class="w-full border mt-4">
                <thead>
                    <tr class="bg-gray-100 text-center">
                        <th class="border p-2">Name</th>
                        <th class="border p-2">Email</th>
                        <th class="border p-2">Phone</th>
                        <th class="border p-2">CV</th>
                        <th v-if="currentTab === 'pending'" class="border p-2">Accept</th>
                        <th v-if="currentTab === 'pending'" class="border p-2">Reject</th>
                        
        <!-- Accepted / Rejected -->
        <th v-if="currentTab !== 'pending'" class="border p-2">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <template v-if="currentTab === 'pending'">
                        <tr v-for="app in pendingList" :key="app.id" class="text-center">
                            <td class="border p-2">{{ app.name }}</td>
                            <td class="border p-2">{{ app.email }}</td>
                            <td class="border p-2">{{ app.phone }}</td>
                            <td class="border p-2">
                                <a :href="`/storage/${app.cv_path}`" target="_blank"
                                    class="text-blue-600 underline">View CV</a>
                            </td>


                            <td class="border p-2 space-x-2">
                                <Button size="sm" variant="secondary" class="cursor-pointer"
                                    @click="acceptApplication(app.id)">Accept</Button>

                            </td>
                            <td class="border p-2 space-x-2">
                                <Button size="sm" variant="destructive" class="cursor-pointer"
                                    @click="openRejectModal(app.id)">Reject</Button>

                            </td>
                        </tr>
                    </template>

                    <template v-if="currentTab === 'accepted'">
                        <tr v-for="app in acceptedList" :key="app.id" class="text-center">
                            <td class="border p-2">{{ app.name }}</td>
                            <td class="border p-2">{{ app.email }}</td>
                            <td class="border p-2">{{ app.phone }}</td>
                            <td class="border p-2">
                                <a :href="`/storage/${app.cv_path}`" target="_blank"
                                    class="text-blue-600 underline">View CV</a>
                            </td>
                            <td class="border p-2 text-green-600 font-bold">Accepted</td>
                        </tr>
                    </template>

                    <template v-if="currentTab === 'rejected'">
                        <tr v-for="app in rejectedList" :key="app.id" class="text-center">
                            <td class="border p-2">{{ app.name }}</td>
                            <td class="border p-2">{{ app.email }}</td>
                            <td class="border p-2">{{ app.phone }}</td>
                            <td class="border p-2">
                                <a :href="`/storage/${app.cv_path}`" target="_blank"
                                    class="text-blue-600 underline">View CV</a>
                            </td>
                            <td class="border p-2 text-red-600 font-bold">Rejected</td>
                        </tr>
                    </template>

                    <tr v-if="currentTab === 'pending' && pendingList.length === 0">
                        <td colspan="5" class="p-4 text-center text-gray-500">No pending applications</td>
                    </tr>
                    <tr v-if="currentTab === 'accepted' && acceptedList.length === 0">
                        <td colspan="5" class="p-4 text-center text-gray-500">No accepted applications</td>
                    </tr>
                    <tr v-if="currentTab === 'rejected' && rejectedList.length === 0">
                        <td colspan="5" class="p-4 text-center text-gray-500">No rejected applications</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Reject Modal -->
        <div v-if="showRejectModal" class="fixed inset-0 z-50 flex items-center justify-center bg-opacity-30">
            <div class="w-80 space-y-4 rounded bg-white p-6 shadow-xl">
                <h2 class="text-lg font-bold text-red-600">Reject Application</h2>
                <p>Provide reason for rejection:</p>
                <input type="text" v-model="adminNote" class="w-full border p-2 rounded" placeholder="Reason" />
                <div class="flex justify-end gap-3 mt-2">
                    <button class="rounded bg-gray-300 px-4 py-2 cursor-pointer"
                        @click="showRejectModal = false">Cancel</button>
                    <button class="rounded bg-red-600 px-4 py-2 text-white cursor-pointer"
                        @click="confirmReject">Reject</button>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
