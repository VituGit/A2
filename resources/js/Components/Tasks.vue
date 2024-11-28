<script setup>
defineProps({
    tasks: {
        type: Array,
        default: () => [],
    },
});

// Controla qual tarefa está expandida (se houver interatividade)
import { ref } from 'vue';
const activeIndex = ref(null);

const toggleTask = (index) => {
    activeIndex.value = activeIndex.value === index ? null : index;
};
</script>

<template>
    <section id="tasks">
        <div v-for="(task, index) in tasks" :key="task.id" class="border-b border-gray-300">
            <!-- Status com bolinha colorida -->
            <div class="flex items-center space-x-2 mt-2">
                <span :class="{
                    'bg-blue-500': task.status === 'pending',
                    'bg-yellow-500': task.status === 'in-progress',
                    'bg-green-500': task.status === 'completed'
                }" class="w-3.5 h-3.5 rounded-full"></span>
            </div>
            <div @click="toggleTask(index)" class="py-4 flex justify-between items-center cursor-pointer">
                <h3 class="text-lg font-semibold flex items-center" :class="{
                    'text-blue-500': activeIndex === index,
                    'text-black': activeIndex !== index,
                }">
                    {{ task.title }}
                </h3>
                <span class="text-2xl text-blue-500">
                    <template v-if="activeIndex === index">−</template>
                    <template v-else>+</template>
                </span>
            </div>

            <transition name="fade">
                <div v-if="activeIndex === index" class="overflow-hidden pb-4">
                    <p class="text-gray-700 text-left">
                        {{ task.description }}
                    </p>
                </div>
            </transition>
        </div>
    </section>
</template>
