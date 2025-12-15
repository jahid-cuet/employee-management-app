<script setup lang="ts">
import { Head, Form, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import Input from '@/components/ui/input/Input.vue';
import Button from '@/components/ui/button/Button.vue';
import InputError from '@/components/InputError.vue';
import Spinner from '@/components/ui/spinner/Spinner.vue';
import { type BreadcrumbItem } from '@/types';


interface PageProps {
  employee: {
    id: number;
    employee_id: string;
    name: string;
    email: string;
    designation: string;
    salary: number;
  };
}

// Get page props
const page = usePage<PageProps>();
const employee = ref({ ...page.props.employee });

// Breadcrumbs
const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Employees', href: '/employees' },
  { title: 'Edit Employee', href: `/employees/${employee.value.id}/edit` },
];

</script>

<template>

  <Head title="Edit Employee" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="p-4 max-w-md space-y-4 bg-white rounded-xl shadow">
      <!-- Edit Form -->
      <Form :action="`/employees/${employee.id}`" method="put" class="space-y-4" v-slot="{ errors, processing }">
        <div>
          <Input type="text" name="employee_id" v-model="employee.employee_id" placeholder="Employee ID"
            class="w-full" />
          <InputError :message="errors.employee_id" />
        </div>

        <div>
          <Input type="text" name="name" v-model="employee.name" placeholder="Name" class="w-full" />
          <InputError :message="errors.name" />
        </div>

        <div>
          <Input type="email" name="email" v-model="employee.email" placeholder="Email" class="w-full" />
          <InputError :message="errors.email" />
        </div>

        <div>
          <Input type="text" name="designation" v-model="employee.designation" placeholder="Designation"
            class="w-full" />
          <InputError :message="errors.designation" />
        </div>

        <div>
          <Input type="number" name="salary" v-model="employee.salary" placeholder="Salary" class="w-full" />
          <InputError :message="errors.salary" />
        </div>

        <Button type="submit" variant="secondary" size="lg" class="cursor-pointer" :disabled="processing">
          <Spinner v-if="processing" />
          <span v-else>Update Employee</span>
        </Button>
      </Form>
    </div>
  </AppLayout>
</template>
