<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Form, Head } from '@inertiajs/vue3';
import Input from '@/components/ui/input/Input.vue';
import InputError from '@/components/InputError.vue';
import Label from '@/components/ui/label/Label.vue';
import Button from '@/components/ui/button/Button.vue';
import Spinner from '@/components/ui/spinner/Spinner.vue';
import { ref } from 'vue';
import { type BreadcrumbItem } from '@/types';

// Props from controller
const props = defineProps<{
  user: { id: number; name: string; email: string; roles: Array<{id:number,name:string}> };
  roles: Array<{ id: number; name: string }>;
  flash: { success?: string; error?: string };
}>();

// Reactive state
const name = ref(props.user.name);
const email = ref(props.user.email);
const selectedRoles = ref<number[]>(props.user.roles.map(r => r.id));

// Breadcrumbs
const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Users', href: '/users' },
  { title: 'Edit User', href: `/users/${props.user.id}/edit` },
];

// Flash visibility
const showSuccess = ref(true);
</script>

<template>
  <Head title="Edit User" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="space-y-4 p-4">

      <!-- Flash message -->
      <div v-if="showSuccess && props.flash.success" class="mb-4 flex items-center justify-between rounded bg-green-100 p-2 text-green-700">
        <span>{{ props.flash.success }}</span>
        <button @click="showSuccess = false" class="px-2 font-bold">×</button>
      </div>

      <div class="flex min-h-screen items-center justify-center bg-gray-100 p-4">
        <div class="w-full max-w-md rounded-xl bg-white p-6 shadow-md">

          <!-- Edit User Form -->
          <Form
            :action="`/users/${props.user.id}`"
            method="put"
            :data="{ name: name.value, email: email.value, roles: selectedRoles.value }"
            v-slot="{ errors, processing }"
          >
            <div class="space-y-4">

              <!-- Name -->
              <div class="grid gap-2">
                <Label htmlFor="name">Name</Label>
                <Input id="name" type="text" name="name" v-model="name" required />
                <InputError :message="errors.name" />
              </div>

              <!-- Email -->
              <div class="grid gap-2">
                <Label htmlFor="email">Email</Label>
                <Input id="email" type="email" name="email" v-model="email" required />
                <InputError :message="errors.email" />
              </div>

              <!-- Roles -->
              <div class="space-y-2">
                <Label>Roles</Label>
                <div class="flex flex-wrap gap-4">
                  <div v-for="role in props.roles" :key="role.id" class="flex items-center gap-2">
                    <input
                      type="checkbox"
                      :value="role.id"
                      v-model="selectedRoles"
                      name="roles[]"
                      class="h-4 w-4 cursor-pointer"
                    />
                    <Label class="cursor-pointer">{{ role.name }}</Label>
                  </div>
                </div>
                <InputError :message="errors.roles" />
              </div>

              <!-- Submit -->
              <div class="flex items-center">
                <Button variant="secondary" size="lg" :disabled="processing">
                  <Spinner v-if="processing" />
                  <span v-else>Update User</span>
                </Button>
              </div>

            </div>
          </Form>

        </div>
      </div>
    </div>
  </AppLayout>
</template>
