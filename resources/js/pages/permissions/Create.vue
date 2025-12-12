<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import Button from '@/components/ui/button/Button.vue';
import Label from '@/components/ui/label/Label.vue';
import Spinner from '@/components/ui/spinner/Spinner.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Form, Head } from '@inertiajs/vue3';
import { ref } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Permission Create',
        href: '/permissions/create',
    },
];
// Flash message
const { flash } = defineProps<{
    flash: {
        success?: string;
        error?: string;
    };
}>();
const showSuccess = ref(true);
</script>

<template>
    <Head title="Create" />

    <div class="space-y-4 p-4">
        <!-- Flash Message -->

        <AppLayout :breadcrumbs="breadcrumbs">
            <div
                v-if="showSuccess && flash.success"
                class="mb-4 flex items-center justify-between rounded bg-green-100 p-2 text-green-700"
            >
                <span>{{ flash.success }}</span>
                <button @click="showSuccess = false" class="px-2 font-bold">
                    ×
                </button>
            </div>
            <div
                class="flex min-h-screen items-center justify-center bg-gray-100 p-4"
            >
                <div class="w-full max-w-md rounded-xl bg-white p-6">
                    <Form
                        action="/permissions/store"
                        method="post"
                        reset-on-success
                        v-slot="{ errors, processing }"
                    >
                        <div class="space-y-6">
                            <div class="grid gap-2">
                                <Label htmlFor="permissions">Permission</Label>
                                <Input
                                    id="permissions"
                                    type="text"
                                    name="name"
                                    class="mt-1 block w-full"
                                    required
                                    autocomplete="current-permissions"
                                    autofocus
                                />
                                <InputError :message="errors.permissions" />
                            </div>

                            <div class="flex items-center">
                                <Button
                                    variant="secondary"
                                    size="lg"
                                    class="cursor-pointer"
                                >
                                    <Menu class="h-5 w-5" />
                                    <Spinner v-if="processing" />
                                    Add Permissions
                                </Button>
                            </div>
                        </div>
                    </Form>
                </div>
            </div>
        </AppLayout>
    </div>
</template>
