<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';

defineProps({
    users
});

// Configurando o formulário
const form = useForm({
    title: '',
    description: '',
    users: [],
});

const showModal = ref(false);

const handleSubmit = () => {
    form.post('/tasks', {
        onSuccess: () => {
            form.reset();
            showModal.value = false;
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
        <!-- Botão para abrir o modal -->
        <button @click="openModal" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
            Criar nova tarefa
        </button>

        <!-- Modal -->
        <div v-if="showModal" class="fixed inset-0 z-50 flex justify-center items-center bg-gray-900 bg-opacity-50">
            <div class="bg-white rounded-lg w-full sm:w-96 p-6 shadow-lg">
                <h4 class="font-semibold text-lg mb-4">Criar Nova Tarefa</h4>
                <form @submit.prevent="handleSubmit">
                    <!-- Campo de título -->
                    <div class="mb-2">
                        <label for="title" class="block text-sm font-medium">Título</label>
                        <input v-model="form.title" type="text" id="title" class="form-input mt-1 block w-full"
                            required />
                    </div>

                    <!-- Campo de descrição -->
                    <div class="mb-2">
                        <label for="description" class="block text-sm font-medium">Descrição</label>
                        <textarea v-model="form.description" id="description"
                            class="form-input mt-1 block w-full"></textarea>
                    </div>

                    <!-- Campo de seleção de usuários -->
                    <div class="mb-2">
                        <label for="users" class="block text-sm font-medium">Usuários</label>
                        <select v-model="form.users" id="users" class="form-input mt-1 block w-full" multiple>
                            <option v-for="user in users" :key="user.id" :value="user.id">
                                {{ user.name }}
                            </option>
                        </select>
                    </div>

                    <!-- Botões de ação -->
                    <div class="flex justify-end mt-4">
                        <button @click="closeModal" type="button" class="px-4 py-2 bg-gray-300 text-black rounded mr-2">
                            Cancelar
                        </button>
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded"
                            :disabled="form.processing">
                            Criar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
