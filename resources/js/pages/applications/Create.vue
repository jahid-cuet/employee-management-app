<script setup lang="ts">
import { Head, Form, usePage } from '@inertiajs/vue3';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import Button from '@/components/ui/button/Button.vue';
import InputError from '@/components/InputError.vue';
import { ref, watch } from 'vue';

// Reactive flash message
const page = usePage();
const showSuccess = ref(true);
const flashMessage = ref(page.props.flash.success || '');

// Watch for flash updates after submission
watch(
  () => page.props.flash.success,
  (newVal) => {
    flashMessage.value = newVal;
    showSuccess.value = true;
  }
);
</script>

<template>
  <Head title="Apply" />
  <div class="p-4 max-w-md mx-auto space-y-4">

    <h1 class="text-xl font-bold">Application Form</h1>

    <!-- Flash message like permissions page -->
    <div v-if="showSuccess && flashMessage" 
         class="bg-green-100 text-green-700 p-2 rounded mb-4 flex justify-between items-center">
      <span>{{ flashMessage }}</span>
      <button @click="showSuccess = false" class="font-bold px-2">×</button>
    </div>

    <Form method="post" action="/apply" enctype="multipart/form-data" v-slot="{ errors, processing }">
      <div class="space-y-2">
        <Label>Name</Label>
        <Input name="name" />
        <InputError :message="errors.name" />

        <Label>Email</Label>
        <Input name="email" type="email" />
        <InputError :message="errors.email" />

        <Label>Phone</Label>
        <Input name="phone" />
        <InputError :message="errors.phone" />

        <Label>CV (PDF/DOC)</Label>
        <Input name="cv" type="file" />
        <InputError :message="errors.cv" />
      </div>

      <Button type="submit" variant="secondary" size="lg"
                                        class="cursor-pointer" :disabled="processing">Submit</Button>
    </Form>
  </div>
</template>
