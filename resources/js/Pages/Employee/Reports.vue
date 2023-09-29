<script setup>
import InputLabel from "@/Components/InputLabel.vue";
import SelectInput from "@/Components/SelectInput.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {
    DocumentChartBarIcon,
    DocumentDuplicateIcon,
    DocumentIcon,
    PrinterIcon,
} from "@heroicons/vue/24/outline";
import { Head } from "@inertiajs/vue3";
import { ref } from "vue";
import ButtonsHtml5 from "datatables.net-buttons/js/buttons.html5";
import DataTable from "datatables.net-vue3";
import "datatables.net-dt/css/jquery.dataTables.min.css";
import "datatables.net-buttons/js/buttons.print";
import "datatables.net-responsive-dt";
import "datatables.net-responsive-dt/css/responsive.dataTables.min.css";
import JsZip from "jszip";
import pdfmake from "pdfmake/build/pdfmake";
import * as pdfFonts from "pdfmake/build/vfs_fonts";
pdfmake.vfs = pdfFonts.pdfMake ? pdfFonts.pdfMake.vfs : pdfmake.vfs;
window.JSZip = JsZip;
DataTable.use(ButtonsHtml5);

const props = defineProps({
    employees: { type: Object },
    departments: { type: Object },
});

const columns1 = ref([]);
const columns2 = ref([]);
const buttons1 = ref([]);
const buttons2 = ref([]);
const report = ref("1");
const types = ref([
    { id: "1", name: "Employees" },
    { id: "2", name: "Departments" },
]);

columns1.value = [
    {
        data: null,
        render: function (data, type, row, meta) {
            return meta.row + 1;
        },
    },
    { data: "name" },
    { data: "email" },
    { data: "phone" },
    { data: "department" },
];

columns2.value = [
    {
        data: null,
        render: function (data, type, row, meta) {
            return meta.row + 1;
        },
    },
    { data: "name" },
];

buttons1.value = [
    {
        title: "Employees",
        extend: "excelHtml5",
        text: `<DocumentChartBarIcon /> Excel`,
        className:
            "flex items-center px-4 py-2 bg-green-500 border rounded text-white uppercase hover:bg-green-700",
    },
    {
        title: "Employees",
        extend: "pdfHtml5",
        text: `<DocumentIcon /> PDF`,
        className:
            "flex items-center px-4 py-2 bg-red-500 border rounded text-white uppercase hover:bg-red-700",
    },
    {
        title: "Employees",
        extend: "pdfHtml5",
        text: `<PrinterIcon /> Print`,
        className:
            "flex items-center px-4 py-2 bg-blue-500 border rounded text-white uppercase hover:bg-blue-700",
    },
    {
        title: "Employees",
        extend: "pdfHtml5",
        text: `<DocumentDuplicateIcon /> Copy`,
        className:
            "flex items-center px-4 py-2 bg-cyan-500 border rounded text-white uppercase hover:bg-cyan-700",
    },
];

buttons2.value = [
    {
        title: "Departments",
        extend: "excelHtml5",
        text: `<DocumentChartBarIcon /> Excel`,
        className:
            "flex items-center px-4 py-2 bg-green-500 border rounded text-white uppercase hover:bg-green-700",
    },
    {
        title: "Departments",
        extend: "pdfHtml5",
        text: `<DocumentIcon /> PDF`,
        className:
            "flex items-center px-4 py-2 bg-red-500 border rounded text-white uppercase hover:bg-red-700",
    },
    {
        title: "Departments",
        extend: "pdfHtml5",
        text: `<PrinterIcon /> Print`,
        className:
            "flex items-center px-4 py-2 bg-blue-500 border rounded text-white uppercase hover:bg-blue-700",
    },
    {
        title: "Departments",
        extend: "pdfHtml5",
        text: `<DocumentDuplicateIcon /> Copy`,
        className:
            "flex items-center px-4 py-2 bg-cyan-500 border rounded text-white uppercase hover:bg-cyan-700",
    },
];
</script>

<template>
    <Head title="Reports" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-300 leading-tight">
                Reports
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div>
                            <InputLabel for="rep" value="Report:" />
                            <SelectInput
                                id="rep"
                                class="block w-full mt-1"
                                v-model="report"
                                :options="types"
                            />
                        </div>

                        <div v-if="report == '1'">
                            <DataTable
                                :data="employees"
                                :columns="columns1"
                                class="w-full border shadow"
                                :options="{
                                    responsive: true,
                                    autoWidth: true,
                                    dom: 'Bfrtip',
                                    buttons: buttons1,
                                }"
                            >
                                <thead>
                                    <tr class="bg-gray-300">
                                        <th class="px-2 py-2">#</th>
                                        <th class="px-2 py-2">Name</th>
                                        <th class="px-2 py-2">Email</th>
                                        <th class="px-2 py-2">Phone</th>
                                        <th class="px-2 py-2">Department</th>
                                    </tr>
                                </thead>
                            </DataTable>
                        </div>
                        <div v-else></div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
