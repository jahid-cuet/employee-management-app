<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { type BreadcrumbItem } from '@/types';
import Button from '@/components/ui/button/Button.vue';

// Types define kora (Tomar AppConstant structure onujayi)
interface Gateway {
    key: string;
    name: string;
    description: string;
    url: string;
}

interface Article {
    id: number;
    title: string;
    price?: number | string;
}

// Props receive kora
const { article, gateways } = usePage().props as unknown as { 
    article: Article; 
    gateways: Record<string, Gateway> 
};

// Breadcrumb set kora
const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Articles', href: '/articles' },
    { title: 'Payment Gateways', href: '#' },
];
</script>

<template>
    <Head title="Select Gateway" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-6 max-w-5xl mx-auto space-y-6">
            
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 flex justify-between items-center">
                <div>
                    <h2 class="text-sm font-medium text-gray-500 uppercase tracking-wider">You are paying for</h2>
                    <p class="text-xl font-bold text-gray-900 dark:text-white">{{ article.title }}</p>
                </div>
                <div class="text-right">
                    <h2 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Amount</h2>
                    <p class="text-3xl font-black text-indigo-600 dark:text-indigo-400">৳1000</p>
                </div>
            </div>

            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 px-1">Choose a Payment Method</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div 
                        v-for="(gateway, key) in gateways" 
                        :key="key"
                        class="bg-white dark:bg-gray-800 border dark:border-gray-700 rounded-2xl p-5 shadow-sm hover:shadow-md transition-all duration-300 group flex flex-col"
                    >
                        <div class="flex items-start gap-5 mb-6">
                            <div class="h-20 w-20 flex-shrink-0 bg-gray-50 dark:bg-gray-900 rounded-xl p-3 border dark:border-gray-700 group-hover:bg-indigo-50 dark:group-hover:bg-indigo-900/20 transition-colors">
                                <img :src="gateway.url" :alt="gateway.name" class="h-full w-full object-contain" />
                            </div>
                            
                            <div class="space-y-1">
                                <h4 class="text-xl font-bold text-gray-900 dark:text-white">{{ gateway.name }}</h4>
                                <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-2 leading-relaxed">
                                    {{ gateway.description }}
                                </p>
                            </div>
                        </div>

                        <div class="mt-auto">
                            <!-- <Link :href="route('gateways.payment-accounts', { article: article.id, gateway: key })">
                                <Button class="w-full h-12 text-md font-bold cursor-pointer transition-transform active:scale-95">
                                    Pay with {{ gateway.name }}
                                </Button>
                            </Link> -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center pt-4">
                <!-- <Link href="/articles" class="text-sm text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors">
                    Cancel and return to articles
                </Link> -->
            </div>
        </div>
    </AppLayout>
</template>