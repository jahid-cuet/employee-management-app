<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import Spinner from '@/components/ui/spinner/Spinner.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Form, Head } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Permission Create',
        href: '/permissions/create',
    },
];

</script>


<template>

    <Head title="Create" />

    <div class="space-y-4 p-4">

        <AppLayout :breadcrumbs="breadcrumbs">

            <div class="w-full max-w-md rounded-xl bg-white p-6">
                <Form action="/permissions/store" method="post" reset-on-success v-slot="{ errors, processing }">
                    <div class="space-y-6">
                        <div class="grid gap-2">
                            <Label htmlFor="permissions">Permission</Label>
                            <Input id="permissions" type="text" name="name" class="mt-1 block w-full" required
                                autocomplete="current-permissions" autofocus />
                            <InputError :message="errors.permissions" />
                        </div>

                        <div class="flex items-center">
                            <Button variant="secondary" size="lg" class="cursor-pointer">
                                <Menu class="h-5 w-5" />
                                <Spinner v-if="processing" />
                                Add Permissions
                            </Button>
                        </div>
                    </div>
                </Form>
            </div>

        </AppLayout>
    </div>
</template>
