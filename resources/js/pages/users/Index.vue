<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import Button from '@/components/ui/button/Button.vue';
import {  reactive } from 'vue';
import { type BreadcrumbItem } from '@/types';

// Props from Controller
const props = defineProps<{
    users: Array<{ id: number; name: string; email: string; roles: Array<{id:number,name:string}> }>;
    flash: string;
}>();

const users = reactive([...props.users]);
const breadcrumbs: BreadcrumbItem[] = [{ title: 'Users', href: '/users' }];
</script>

<template>
  <Head title="Users" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="p-4 space-y-4">

      <!-- Flash -->
     

      <!-- Users Table -->
      <table class="w-full table-auto border">
        <thead>
          <tr class="bg-gray-100 text-center">
            <th class="px-4 py-2 border">ID</th>
            <th class="px-4 py-2 border">Name</th>
            <th class="px-4 py-2 border">Email</th>
            <th class="px-4 py-2 border">Roles</th>
            <th class="px-4 py-2 border">Assign Roles</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="user in users" :key="user.id" class="text-center">
            <td class="px-4 py-2 border">{{ user.id }}</td>
            <td class="px-4 py-2 border">{{ user.name }}</td>
            <td class="px-4 py-2 border">{{ user.email }}</td>

            <!-- Roles badges -->
            <td class="px-4 py-2 border">
              <span v-for="role in user.roles" :key="role.id"
                    class="m-1 inline-block rounded bg-gray-200 px-2 py-1 text-xs text-gray-700">
                {{ role.name }}
              </span>
            </td>

            <!-- Assign Roles button -->
            <td class="px-4 py-2 border">
              <Link :href="`/users/${user.id}/roles`">
                <Button variant="secondary" size="lg" class="cursor-pointer">Assign Roles</Button>
              </Link>
            </td>
          </tr>
        </tbody>
      </table>

    </div>
  </AppLayout>
</template>
