<script setup>
import { ref } from 'vue';
import axios from 'axios';  // Importando o Axios

const { users } = defineProps({
    users: {
        type: Array,
        required: true,
    },
});

const form = ref({
    title: '',
    description: '',
    due_date: '',
    users: [],
});

const emit = defineEmits();

const showModal = ref(false);

const handleSubmit = async () => {
    try {
        const response = await axios.post('/tasks', {
            title: form.value.title,
            description: form.value.description,
            due_date: form.value.due_date,
            users: form.value.users,
        });

        form.value = { title: '', description: '', due_date: '', users: [] };
        showModal.value = false;
        emit('task-created');

        console.log('Task created successfully!', response.data);
    } catch (error) {
        console.error('Error creating task:', error);
    }
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
        <h3 class="text-xl font-semibold">Create Task</h3>

        <form @submit.prevent="handleSubmit">
            <div>
                <label for="title" class="block text-sm font-medium">Title</label>
                <input type="text" v-model="form.title" id="title" class="mt-1 p-2 border" required />
            </div>

            <div>
                <label for="description" class="block text-sm font-medium">Description</label>
                <textarea v-model="form.description" id="description" class="mt-1 p-2 border" rows="4"></textarea>
            </div>

            <div>
                <label for="due_date" class="block text-sm font-medium">Due Date</label>
                <input type="datetime-local" v-model="form.due_date" id="due_date" class="mt-1 p-2 border" />
            </div>

            <div>
                <label for="users" class="block text-sm font-medium">Assign Users</label>
                <select v-model="form.users" multiple class="mt-1 p-2 border">
                    <option v-for="user in users" :key="user.id" :value="user.id">{{ user.name }}</option>
                </select>
            </div>

            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded" :disabled="form.processing">
                Criar
            </button>
        </form>
    </div>
</template>
