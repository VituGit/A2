<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import Tasks from '@/Components/Tasks.vue';
import CreateTask from '@/Components/CreateTask.vue';

// Recebendo tarefas via props
defineProps({
    tasks: {
        type: Array,
        default: () => [],
    },
});

// Recarregar tarefas após criar uma nova
const reloadTasks = () => {
    router.reload({ only: ['tasks'] });
};
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Tasks
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <!-- Lista de tarefas -->
                        <Tasks :tasks="tasks" />

                        <!-- Formulário para criar tarefa -->
                         <div class="mt-4">
                             <CreateTask @task-created="reloadTasks" />
                         </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
