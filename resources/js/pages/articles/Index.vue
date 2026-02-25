<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import Button from '@/components/ui/button/Button.vue';
import { ref, reactive } from 'vue';
import { type BreadcrumbItem } from '@/types';

const { articles, flash } = usePage().props;

// Reactive articles array
const articleList = reactive([...articles.data]);

// Breadcrumb
const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Articles', href: '/articles' },
];

// Flash message
const showSuccess = ref(true);

// Delete modal state
const showDeleteModal = ref(false);
const deleteId = ref<number | null>(null);

function openDeleteModal(id: number) {
    deleteId.value = id;
    showDeleteModal.value = true;
}

function confirmDelete() {
    if (!deleteId.value) return;

    router.delete(`/articles/${deleteId.value}`, {
        onSuccess: () => {
            const index = articleList.findIndex(a => a.id === deleteId.value);
            if (index !== -1) articleList.splice(index, 1);
            showDeleteModal.value = false;
        }
    });
}
</script>

<template>
  <Head title="Articles" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="p-4 space-y-4">

      <!-- Create Button -->
      <div class="mb-4">
        <Link href="/articles/create">
          <Button class="cursor-pointer">Create Article</Button>
        </Link>
      </div>

      <!-- Flash -->
      <div v-if="showSuccess && flash.success"
           class="bg-green-100 text-green-700 p-2 rounded mb-4 flex justify-between items-center">
        <span>{{ flash.success }}</span>
        <button @click="showSuccess = false" class="font-bold px-2">×</button>
      </div>

      <!-- Articles Table -->
      <table class="w-full table-auto border">
        <thead>
          <tr class="bg-gray-100 text-center">
            <th class="px-4 py-2 border">ID</th>
            <th class="px-4 py-2 border">Title</th>
            <th class="px-4 py-2 border">Content</th>
            <th class="px-4 py-2 border">Edit</th>
            <th class="px-4 py-2 border">Payment</th>
            <th class="px-4 py-2 border">Delete</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="article in articleList" :key="article.id" class="text-center">
            <td class="px-4 py-2 border">{{ article.id }}</td>
            <td class="px-4 py-2 border">{{ article.title }}</td>
            <td class="px-4 py-2 border">{{ article.content }}</td>

            <td class="px-4 py-2 border">
              <Link :href="`/articles/${article.id}/edit`">
                <Button variant="secondary" size="icon"
                        class="group h-9 w-9 cursor-pointer">Edit</Button>
              </Link>
            </td><td class="px-4 py-2 border">
<Link :href="`/articles/${article.id}/payments`">
    <Button class="w-full h-12 text-md font-bold cursor-pointer">
        Pay with {{ gateway.name }}
    </Button>
</Link>
            </td>
            <td class="px-4 py-2 border">
              <Button variant="destructive" size="lg"
                      class="group h-9 w-9 cursor-pointer"
                      @click="openDeleteModal(article.id)">
                Delete
              </Button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>


    <!-- Delete Modal -->
    <div v-if="showDeleteModal"
         class="fixed inset-0  bg-opacity-50 flex items-center justify-center z-50">
      <div class="bg-white p-6 rounded shadow-xl w-80 space-y-4">
        <h2 class="text-lg font-bold text-red-600">Confirm Delete</h2>
        <p>Are you sure you want to delete this article?</p>
        <div class="flex justify-end gap-3">
          <button class="px-4 py-2 bg-gray-300 rounded cursor-pointer" @click="showDeleteModal = false">
            Cancel
          </button>
          <button class="px-4 py-2 bg-red-600 text-white rounded cursor-pointer" @click="confirmDelete">
            Delete
          </button>
        </div>
      </div>
    </div>

  </AppLayout>
</template>
