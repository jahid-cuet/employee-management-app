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

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Articles', href: '/articles' },
    { title: 'Create', href: '/articles/create' }
];

const showSuccess = ref(true);
</script>

<template>
    <Head title="Create Article" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-4 p-4">
            <!-- Flash Message -->
            <div
                v-if="showSuccess && $page.props.flash.success"
                class="mb-4 flex items-center justify-between rounded bg-green-100 p-2 text-green-700"
            >
                <span>{{ $page.props.flash.success }}</span>
                <button @click="showSuccess = false" class="px-2 font-bold">×</button>
            </div>

            <div class="flex min-h-screen items-center justify-center bg-gray-100 p-4">
                <div class="w-full max-w-md rounded-xl bg-white p-6 shadow-md">
                    <Form
                        action="/articles"
                        method="post"
                        :data="{ title: '', content: '' }"
                        reset-on-success
                        v-slot="{ errors, processing }"
                    >
                        <div class="space-y-6">
                            <!-- Title -->
                            <div class="grid gap-2">
                                <Label htmlFor="title">Title</Label>
                                <Input
                                    id="title"
                                    type="text"
                                    name="title"
                                    class="mt-1 block w-full"
                                    required
                                />
                                <InputError :message="errors.title" />
                            </div>

                            <!-- Content -->
                            <div class="grid gap-2">
                                <Label htmlFor="content">Content</Label>
                                <textarea
                                    id="content"
                                    name="content"
                                    rows="5"
                                    class="mt-1 block w-full border p-2 rounded"
                                    required
                                ></textarea>
                                <InputError :message="errors.content" />
                            </div>

                            <!-- Submit Button -->
                            <div class="flex items-center">
                                <Button variant="secondary" size="lg" class="cursor-pointer">
                                    <Spinner v-if="processing" />
                                    <span v-else>Create Article</span>
                                </Button>
                            </div>
                        </div>
                    </Form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
