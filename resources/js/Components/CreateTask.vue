<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';

// Criando o formulário
const form = useForm({
    title: '',
    description: '',
});

// Controle da visibilidade do modal
const showModal = ref(false);

const handleSubmit = () => {
    form.post('/tasks', {
        onSuccess: () => {
            form.reset();
            showModal.value = false;
            emit('task-created');
        },
    });
};

const openModal = () => {
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
};
</script>

<template>
    <div>
        <button @click="openModal" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
            Criar nova tarefa
        </button>
        <div v-if="showModal" class="fixed inset-0 z-50 flex justify-center items-center bg-gray-900 bg-opacity-50">
            <div class="bg-white rounded-lg w-full sm:w-96 p-6 shadow-lg">
                <h4 class="font-semibold text-lg mb-4">Criar Nova Tarefa</h4>
                <form @submit.prevent="handleSubmit">
                    <div class="mb-2">
                        <label for="title" class="block text-sm font-medium">Título</label>
                        <input v-model="form.title" type="text" id="title" class="form-input mt-1 block w-full"
                            required />
                    </div>

                    <div class="mb-2">
                        <label for="description" class="block text-sm font-medium">Descrição</label>
                        <textarea v-model="form.description" id="description"
                            class="form-input mt-1 block w-full"></textarea>
                    </div>

                    <div class="flex justify-end mt-4">
                        <button @click="closeModal" type="button" class="px-4 py-2 bg-gray-300 text-black rounded mr-2">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded"
                            :disabled="form.processing">
                            Create
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
