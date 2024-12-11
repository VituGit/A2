<script setup>
import dayjs from 'dayjs';
import utc from 'dayjs/plugin/utc';
import { ref, watch } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
    tasks: {
        type: Array,
        default: () => [],
    },
    successMessage: {
        type: String,
        default: '',
    },
});

const activeIndex = ref(null);
const successMessage = ref(props.successMessage);

const isActive = (index) => activeIndex.value === index;

const toggleTask = (index) => {
    activeIndex.value = isActive(index) ? null : index;
};

watch(successMessage, (newValue) => {
    if (newValue) {
        setTimeout(() => {
            successMessage.value = '';
        }, 5000);
    }
});

const deleteTask = (taskId) => {
    if (confirm('Tem certeza que deseja excluir esta tarefa?')) {
        Inertia.visit(`/tasks/${taskId}`, { method: 'delete' });
    }
};

dayjs.extend(utc);

const formatDate = (date) => {
    return dayjs.utc(date).format('DD/MM/YYYY');
};
</script>

<template>
    <AuthenticatedLayout>
        <div v-if="successMessage"
            class="p-4 mb-4 text-sm text-green-800 bg-green-100 border border-green-300 rounded-lg shadow-md">
            {{ successMessage }}
        </div>

        <section id="tasks">
            <div class="py-12">
                <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div v-for="(task, index) in tasks" :key="task.id"
                            class="bg-white shadow-md rounded-lg p-6 transition-transform duration-200 ease-in-out transform hover:scale-105">
                            <div class="flex items-center space-x-2 mb-4">
                                <span :class="{
                                    'bg-blue-500': task.status === 'pending',
                                    'bg-yellow-500': task.status === 'in-progress',
                                    'bg-green-500': task.status === 'completed'
                                }" class="w-3.5 h-3.5 rounded-full"></span>
                                <h3 class="text-lg font-semibold text-gray-800 truncate">{{ task.title }}</h3>
                            </div>
                            <p class="text-gray-600 mb-4">Data de criação: {{ formatDate(task.due_date) }}</p>

                            <div class="flex space-x-2 mt-auto">
                                <button @click="Inertia.visit(`/tasks/${task.id}/edit`)"
                                    class="px-4 py-2 bg-blue-500 text-white rounded-lg transition hover:bg-blue-700">
                                    Editar
                                </button>

                                <button @click="deleteTask(task.id)"
                                    class="px-4 py-2 bg-red-500 text-white rounded-lg transition hover:bg-red-700">
                                    Deletar
                                </button>
                            </div>

                            <div @click="toggleTask(index)"
                            class="mt-4 flex justify-between items-center cursor-pointer">
                            <span class="text-sm text-gray-500">Detalhes</span>
                            <span class="text-xl text-blue-500">
                                <template v-if="isActive(index)">−</template>
                                <template v-else>+</template>
                            </span>
                        </div>
                        <p v-if="isActive(index)" class="text-gray-600 mb-4">{{ task.description }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </AuthenticatedLayout>
</template>
