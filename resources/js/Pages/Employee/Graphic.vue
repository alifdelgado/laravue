<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { ref } from "vue";
import { Bar, Bubble, Line, Pie } from "vue-chartjs";
import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale,
    ArcElement,
    LineElement,
    PointElement,
} from "chart.js";

ChartJS.register(
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale,
    ArcElement,
    LineElement,
    PointElement
);

const props = defineProps({
    data: { type: Object },
});

const departments = ref([]);
const employees = ref([]);
const chartData = ref([]);
const chartOptions = ref([]);
const colors = ref([]);

const random = () => {
    return Math.floor(Math.random() * 256);
};

props.data.map(
    (row) => (
        departments.value.push(row.name),
        employees.value.push(row.employees_count),
        colors.value.push(`rgb(${random()},${random()},${random()})`)
    )
);
chartOptions.value = { responsive: true };
chartData.value = {
    labels: departments.value,
    datasets: [
        {
            label: "Employees",
            data: employees.value,
            backgroundColor: colors.value,
        },
    ],
};
</script>

<template>
    <Head title="Graphic" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-300">
                Graphic
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 flex gap-4 flex-col">
                        <Bar :data="chartData" :options="chartOptions" />
                        <Pie :data="chartData" :options="chartOptions" />
                        <Line :data="chartData" :options="chartOptions" />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
