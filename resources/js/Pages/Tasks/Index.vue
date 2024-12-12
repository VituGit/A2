<script setup>
import dayjs from 'dayjs';
import utc from 'dayjs/plugin/utc';
import { ref, computed } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
    tasks: {
        type: Array,
        default: () => [],
    },
});

const activeIndex = ref(null);

const isActive = (index) => activeIndex.value === index;

const toggleTask = (index) => {
    activeIndex.value = isActive(index) ? null : index;
};

const deleteTask = (taskId) => {
    if (confirm('Tem certeza que deseja excluir esta tarefa?')) {
        Inertia.visit(`/tasks/${taskId}`, { method: 'delete' });
    }
};

dayjs.extend(utc);

const formatDate = (date) => {
    return dayjs.utc(date).format('DD/MM/YYYY');
};

// Computed properties to separate tasks by status
const pendingTasks = computed(() => props.tasks.filter(task => task.status === 'pending'));
const inProgressTasks = computed(() => props.tasks.filter(task => task.status === 'in-progress'));
const completedTasks = computed(() => props.tasks.filter(task => task.status === 'completed'));
</script>


<template>
    <AuthenticatedLayout>
        <section id="tasks">
            <div class="py-12">
                <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div v-if="pendingTasks.length > 0">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Tarefas Pendentes</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div v-for="(task, index) in pendingTasks" :key="task.id"
                                class="bg-white shadow-md rounded-lg p-6 transition-transform duration-200 ease-in-out transform hover:scale-105">
                                <div class="flex items-center space-x-2 mb-4">
                                    <span :class="{
                                        'bg-blue-500': task.status === 'pending',
                                        'bg-yellow-500': task.status === 'in-progress',
                                        'bg-green-500': task.status === 'completed'
                                    }" class="w-3.5 h-3.5 rounded-full"></span>
                                    <h3 class="text-lg font-semibold text-gray-800 truncate">{{ task.title }}</h3>
                                </div>
                                <p class="text-gray-600 mb-4">Data de vencimento: {{ formatDate(task.due_date) }}</p>

                                <div class="flex space-x-2 mt-auto">
                                    <button @click="Inertia.visit(`/tasks/${task.id}/edit`)"
                                        class="px-4 py-2 bg-white border border-blue-500 text-blue-500 rounded-lg transition hover:bg-blue-700 hover:text-white">
                                        Editar
                                    </button>

                                    <button @click="deleteTask(task.id)"
                                        class="px-4 py-2 bg-white border border-red-500 text-red-500 rounded-lg transition hover:bg-red-700 hover:text-white">
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

                    <div v-if="inProgressTasks.length > 0">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Tarefas em Andamento</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div v-for="(task, index) in inProgressTasks" :key="task.id"
                                class="bg-white shadow-md rounded-lg p-6 transition-transform duration-200 ease-in-out transform hover:scale-105">
                                <div class="flex items-center space-x-2 mb-4">
                                    <span :class="{
                                        'bg-blue-500': task.status === 'pending',
                                        'bg-yellow-500': task.status === 'in-progress',
                                        'bg-green-500': task.status === 'completed'
                                    }" class="w-3.5 h-3.5 rounded-full"></span>
                                    <h3 class="text-lg font-semibold text-gray-800 truncate">{{ task.title }}</h3>
                                </div>
                                <p class="text-gray-600 mb-4">Data de vencimento: {{ formatDate(task.due_date) }}</p>

                                <div class="flex space-x-2 mt-auto">
                                    <button @click="Inertia.visit(`/tasks/${task.id}/edit`)"
                                        class="px-4 py-2 bg-white border border-blue-500 text-blue-500 rounded-lg transition hover:bg-blue-700 hover:text-white">
                                        Editar
                                    </button>

                                    <button @click="deleteTask(task.id)"
                                        class="px-4 py-2 bg-white border border-red-500 text-red-500 rounded-lg transition hover:bg-red-700 hover:text-white">
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

                    <div v-if="completedTasks.length > 0">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Tarefas Concluídas</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div v-for="(task, index) in completedTasks" :key="task.id"
                                class="bg-white shadow-md rounded-lg p-6 transition-transform duration-200 ease-in-out transform hover:scale-105">
                                <div class="flex items-center space-x-2 mb-4">
                                    <span :class="{
                                        'bg-blue-500': task.status === 'pending',
                                        'bg-yellow-500': task.status === 'in-progress',
                                        'bg-green-500': task.status === 'completed'
                                    }" class="w-3.5 h-3.5 rounded-full"></span>
                                    <h3 class="text-lg font-semibold text-gray-800 truncate">{{ task.title }}</h3>
                                </div>
                                <p class="text-gray-600 mb-4">Data de vencimento: {{ formatDate(task.due_date) }}</p>

                                <div class="flex space-x-2 mt-auto">
                                    <button @click="Inertia.visit(`/tasks/${task.id}/edit`)"
                                        class="px-4 py-2 bg-white border border-blue-500 text-blue-500 rounded-lg transition hover:bg-blue-700 hover:text-white">
                                        Editar
                                    </button>

                                    <button @click="deleteTask(task.id)"
                                        class="px-4 py-2 bg-white border border-red-500 text-red-500 rounded-lg transition hover:bg-red-700 hover:text-white">
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
            </div>
        </section>
    </AuthenticatedLayout>
</template>
