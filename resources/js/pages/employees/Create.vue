<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Form, Head } from '@inertiajs/vue3';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import Button from '@/components/ui/button/Button.vue';
import InputError from '@/components/InputError.vue';
import Spinner from '@/components/ui/spinner/Spinner.vue';
</script>

<template>
    <Head title="Create Employee" />

    <AppLayout>
        <div class="flex min-h-screen items-center justify-center bg-gray-100">
            <div class="w-full max-w-md bg-white p-6 rounded-xl shadow">
                <Form
                    action="/employees"
                    method="post"
                    reset-on-success
                    v-slot="{ errors, processing }"
                >
                    <div class="space-y-4">
                        <div>
                            <Label>Employee ID</Label>
                            <Input name="employee_id" />
                            <InputError :message="errors.employee_id" />
                        </div>

                        <div>
                            <Label>Name</Label>
                            <Input name="name" />
                            <InputError :message="errors.name" />
                        </div>

                        <div>
                            <Label>Email</Label>
                            <Input name="email" />
                            <InputError :message="errors.email" />
                        </div>

                        <div>
                            <Label>Designation</Label>
                            <Input name="designation" />
                            <InputError :message="errors.designation" />
                        </div>

                        <div>
                            <Label>Salary</Label>
                            <Input name="salary" type="number" />
                            <InputError :message="errors.salary" />
                        </div>

                        <Button  size="sm"
                                variant="secondary"
                                class="cursor-pointer">
                            <Spinner v-if="processing" />
                            <span v-else>Create</span>
                        </Button>
                    </div>
                </Form>
            </div>
        </div>
    </AppLayout>
</template>
