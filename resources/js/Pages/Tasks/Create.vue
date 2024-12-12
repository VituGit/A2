<script setup>
import { ref } from 'vue';
import axios from 'axios';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const form = ref({
    title: '',
    description: '',
    due_date: '',
    users: [],
    processing: false,
});

const showModal = ref(false);

defineProps({
    users: {
        type: Array,
        default: () => [],
    },
});

const emit = defineEmits();

const handleSubmit = async () => {
    form.value.processing = true;

    try {

        const response = await axios.post('/tasks', {
            title: form.value.title,
            description: form.value.description,
            due_date: form.value.due_date,
            users: form.value.users,
        });


        form.value = { title: '', description: '', due_date: '', users: [], processing: false };
        showModal.value = true;
        emit('task-created');
        console.log('Tarefa criada com sucesso!', response.data);
    } catch (error) {
        console.error('Erro ao criar tarefa:', error);
        form.value.processing = false;
    }
};

// Modal - Abrir e Fechar
const openModal = () => {
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
};
</script>


<template>
    <AuthenticatedLayout>
        <div class="isolate bg-gray-100 px-6 py-24 sm:py-32 lg:px-8">
            <div class="absolute inset-x-0 top-[-10rem] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[-20rem]"
                aria-hidden="true"></div>

            <div class="mx-auto max-w-2xl text-center">
                <h2 class="text-balance text-4xl font-semibold tracking-tight text-gray-900 sm:text-5xl">Criar Tarefa
                </h2>
                <p class="mt-2 text-lg text-gray-600">Preencha os campos para criar uma nova tarefa</p>
            </div>

            <form @submit.prevent="handleSubmit" class="mx-auto mt-16 max-w-xl sm:mt-20">
                <div class="grid grid-cols-1 gap-x-8 gap-y-6 sm:grid-cols-2">

                    <!-- Título -->
                    <div class="sm:col-span-2">
                        <label for="title" class="block text-sm font-semibold text-gray-900">Título</label>
                        <div class="mt-2.5">
                            <input type="text" v-model="form.title" id="title" required
                                class="block w-full rounded-md bg-gray-100 px-3.5 py-2 text-base text-gray-900 outline outline-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:outline-indigo-600" />
                        </div>
                    </div>

                    <!-- Descrição -->
                    <div class="sm:col-span-2">
                        <label for="description" class="block text-sm font-semibold text-gray-900">Descrição</label>
                        <div class="mt-2.5">
                            <textarea v-model="form.description" id="description" rows="4"
                                class="block w-full rounded-md bg-gray-100 px-3.5 py-2 text-base text-gray-900 outline outline-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:outline-indigo-600"></textarea>
                        </div>
                    </div>

                    <!-- Data de Vencimento -->
                    <div class="sm:col-span-2">
                        <label for="due_date" class="block text-sm font-semibold text-gray-900">Data de
                            Vencimento</label>
                        <div class="mt-2.5">
                            <input type="datetime-local" v-model="form.due_date" id="due_date"
                                class="block w-full rounded-md bg-gray-100 px-3.5 py-2 text-base text-gray-900 outline outline-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:outline-indigo-600" />
                        </div>
                    </div>

                    <!-- Seleção de Usuários -->
                    <div class="sm:col-span-2">
                        <label for="users" class="block text-sm font-semibold text-gray-900">Usuários</label>
                        <div class="mt-2.5">
                            <div
                                class="flex rounded-md bg-gray-100 outline-1 outline-offset-1 outline-gray-300 focus-within:outline-2 focus-within:outline-indigo-600">
                                <div class="grid shrink-0 grid-cols-1 focus-within:relative">
                                    <select v-model="form.users" id="users" name="users" multiple
                                        class="w-full appearance-none rounded-md py-2 pl-3.5 pr-7 text-base text-gray-500 placeholder:text-gray-400 focus:outline focus:outline-2 focus:outline-indigo-600 sm:text-sm">
                                        <option v-for="user in users" :key="user.id" :value="user.id">
                                            {{ user.name }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>

                <!-- Botão de Criação -->
                <div class="mt-10">
                    <button type="submit" :disabled="form.processing"
                        class="block w-full rounded-md bg-indigo-600 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        Criar
                    </button>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
