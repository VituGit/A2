<script setup>
import { ref, onMounted } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

// Definindo props diretamente
const props = defineProps({
    task: {
        type: Object,
        required: true,
    },
});

const title = ref(props.task.title);
const description = ref(props.task.description);
const status = ref(props.task.status);
const due_date = ref(props.task.due_date);

const submitForm = () => {
    Inertia.put(`/tasks/${props.task.id}`, {
        title: title.value,
        description: description.value,
        status: status.value,
        due_date: due_date.value,
    });
};

</script>

<template>
    <AuthenticatedLayout>
        <section id="task-edit" class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h2 class="text-2xl font-semibold mb-4">Editar Tarefa</h2>

                        <!-- Formulário de edição -->
                        <form @submit.prevent="submitForm">
                            <div class="mb-4">
                                <label for="title" class="block text-sm font-medium text-gray-700">Título</label>
                                <input type="text" id="title" v-model="title" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500" required>
                            </div>

                            <div class="mb-4">
                                <label for="description" class="block text-sm font-medium text-gray-700">Descrição</label>
                                <textarea id="description" v-model="description" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500" rows="4" required></textarea>
                            </div>

                            <div class="mb-4">
                                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                <select id="status" v-model="status" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500" required>
                                    <option value="pending">Pendente</option>
                                    <option value="in-progress">Em andamento</option>
                                    <option value="completed">Concluída</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="due_date" class="block text-sm font-medium text-gray-700">Data de Vencimento</label>
                                <input type="datetime-local" id="due_date" v-model="due_date" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                            </div>

                            <div class="flex justify-end">
                                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                    Atualizar Tarefa
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </AuthenticatedLayout>
</template>
