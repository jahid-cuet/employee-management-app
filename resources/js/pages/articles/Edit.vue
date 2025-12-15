<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import Button from '@/components/ui/button/Button.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { type BreadcrumbItem } from '@/types';

const article = usePage().props.article;

const form = useForm({
  title: article.title,
  content: article.content
});

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Articles', href: '/articles' },
  { title: 'Edit', href: `/articles/${article.id}/edit` }
];
</script>

<template>
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
      <Form @submit.prevent="form.put(`/articles/${article.id}`)" class="space-y-6">
        <div class="grid gap-2">
          <label for="title">Title</label>
          <input id="title" type="text" v-model="form.title" class="mt-1 block w-full border p-2 rounded" required />

          <label for="content">Content</label>
          <textarea id="content" v-model="form.content" class="mt-1 block w-full border p-2 rounded"
            required></textarea>
        </div>

        <div class="flex items-center">
          <Button class="w-full cursor-pointer" :disabled="form.processing">
            Update Article
          </Button>
        </div>
      </Form>
    </div>
  </AppLayout>
</template>
