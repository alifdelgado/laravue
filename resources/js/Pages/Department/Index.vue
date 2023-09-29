<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import Swal from "sweetalert2";
import {
    CheckCircleIcon,
    PencilIcon,
    PlusCircleIcon,
    TrashIcon,
    XMarkIcon,
} from "@heroicons/vue/24/outline";
import DangerButton from "@/Components/DangerButton.vue";

const props = defineProps({
    departments: { type: Object },
});

const form = useForm({
    id: "",
});

const deleteDepartment = (id) => {
    const alert = Swal.mixin({
        buttonsStyling: true,
    });

    alert
        .fire({
            title: "Please, confirm deletion",
            icon: "question",
            showCancelButton: true,
        })
        .then((result) => {
            if (result.isConfirmed) {
                form.delete(route("departments.destroy", id));
            }
        });
};
</script>

<template>
    <Head title="Departments" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-300">
                Departments
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="flex flex-col h-screen gap-2 p-5 overflow-hidden bg-white shadow-sm sm:rounded-lg"
                >
                    <div class="grid v-screen place-items-center">
                        <Link
                            class="flex items-center px-4 py-2 font-bold text-white bg-gray-800 rounded shadow w-28"
                            :href="route('departments.create')"
                            ><PlusCircleIcon class="w-5 h-5 mr-1" /> Add</Link
                        >
                    </div>
                    <div class="grid v-screen place-items-center">
                        <table class="border shadow table-auto">
                            <thead>
                                <tr class="w-full bg-gray-300">
                                    <th class="px-4 py-4">#</th>
                                    <th class="px-4 py-4">Department</th>
                                    <th class="px-4 py-4"></th>
                                    <th class="px-4 py-4"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    class="w-full"
                                    v-for="department in departments"
                                    :key="department.id"
                                >
                                    <td
                                        class="px-4 py-4 border border-gray-400"
                                    >
                                        {{ department.id }}
                                    </td>
                                    <td
                                        class="px-4 py-4 border border-gray-400"
                                    >
                                        {{ department.name }}
                                    </td>
                                    <td
                                        class="px-4 py-4 border border-gray-400"
                                    >
                                        <Link
                                            :href="
                                                route(
                                                    'departments.edit',
                                                    department.id
                                                )
                                            "
                                            :class="'px-4 py-2 border rounded flex text-white bg-yellow-500'"
                                        >
                                            <PencilIcon class="w-5 h-5" />
                                        </Link>
                                    </td>
                                    <td
                                        class="px-4 py-4 border border-gray-400"
                                    >
                                        <DangerButton
                                            @click="
                                                deleteDepartment(department.id)
                                            "
                                            class="text-white"
                                        >
                                            <TrashIcon class="w-5 h-5" />
                                        </DangerButton>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
