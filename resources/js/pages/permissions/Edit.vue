<script setup lang="ts">
import { Head, Form, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import Input from '@/components/ui/input/Input.vue';
import Button from '@/components/ui/button/Button.vue';
import { type BreadcrumbItem } from '@/types';

// TypeScript interface for page props

interface PageProps {
  permission: {
    id: number;
    name: string;
  };
}

// Get page props
const page = usePage<PageProps>();
const permission = ref({ ...page.props.permission });

// Breadcrumbs
const breadcrumbs: BreadcrumbItem[] = [
  { title: 'permission', href: '/permissions' },
  { title: 'Edit permission', href: `/permissions/${permission.value.id}/edit` },
];

</script>

<template>

  <Head title="Edit permission" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="p-4 max-w-md space-y-4">

      <!-- Edit Form -->
      <Form :action="`/permissions/${permission.id}`" method="put" class="space-y-4">
        <Input type="text" name="name" v-model="permission.name" placeholder="Permission Title" class="w-full" />

        <Button type="submit" variant="secondary" size="lg" class="cursor-pointer">Update permission</Button>
      </Form>
    </div>
  </AppLayout>
</template>