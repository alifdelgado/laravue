<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import Swal from "sweetalert2";
import {
    PencilIcon,
    PlusCircleIcon,
    TrashIcon,
    XCircleIcon,
} from "@heroicons/vue/24/outline";
import DangerButton from "@/Components/DangerButton.vue";
import { ref, nextTick } from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import WarningButton from "@/Components/WarningButton.vue";
import vueTailwindPaginationUmd from "@ocrv/vue-tailwind-pagination";
import Modal from "@/Components/Modal.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import SelectInput from "@/Components/SelectInput.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";

const nameInput = ref(null);
const modal = ref(false);
const title = ref("");
const operation = ref(1);
const id = ref("");

const props = defineProps({
    departments: { type: Object },
    employees: { type: Object },
});

const form = useForm({
    name: "",
    email: "",
    phone: "",
    department_id: "",
});
const formPage = useForm({});
const onPageClick = (e) => {
    formPage.get(route("employees.index", { page: e }));
};
const openModal = (op, name, email, phone, department, employee) => {
    modal.value = true;
    nextTick(() => nameInput.value.focus());
    operation.value = op;
    id.value = employee;
    title.value = "Create Employee";

    if (op > 1) {
        title.value = "Edit Employee";
        form.name = name;
        form.email = email;
        form.phone = phone;
        form.department_id = department;
    }
};

const closeModal = () => {
    modal.value = false;
    form.reset();
};

const save = () => {
    if (operation.value === 1) {
        form.post(route("employees.store"), {
            onSuccess: () => ok("Employee created successfully"),
        });
        return;
    }

    form.put(route("employees.update", id.value), {
        onSuccess: () => ok("Employee updated successfully"),
    });
};

const ok = (msj) => {
    form.reset();
    closeModal();
    Swal.fire({ title: msj, icon: "success" });
};

const deleteEmployee = (id) => {
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
                form.delete(route("employees.destroy", id), {
                    onSuccess: () => ok("Employee deleted successfully"),
                });
            }
        });
};
</script>

<template>
    <Head title="Employees" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-300">
                Employees
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="flex flex-col h-screen gap-2 p-5 overflow-hidden bg-white shadow-sm sm:rounded-lg"
                >
                    <div class="grid v-screen place-items-center">
                        <PrimaryButton @click="($event) => openModal(1)">
                            <PlusCircleIcon class="w-5 h-5" /> Add employee
                        </PrimaryButton>
                    </div>
                    <div class="grid v-screen place-items-center">
                        <table class="border shadow table-auto">
                            <thead>
                                <tr class="bg-gray-300">
                                    <th class="px-2 py-2">#</th>
                                    <th class="px-2 py-2">Name</th>
                                    <th class="px-2 py-2">Email</th>
                                    <th class="px-2 py-2">Phone</th>
                                    <th class="px-2 py-2">Department</th>
                                    <th class="px-2 py-2"></th>
                                    <th class="px-2 py-2"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="employee in employees.data"
                                    :key="employee.id"
                                >
                                    <td
                                        class="px-2 py-2 border border-gray-400"
                                    >
                                        {{ employee.id }}
                                    </td>
                                    <td
                                        class="px-2 py-2 border border-gray-400"
                                    >
                                        {{ employee.name }}
                                    </td>
                                    <td
                                        class="px-2 py-2 border border-gray-400"
                                    >
                                        {{ employee.email }}
                                    </td>
                                    <td
                                        class="px-2 py-2 border border-gray-400"
                                    >
                                        {{ employee.phone }}
                                    </td>
                                    <td
                                        class="px-2 py-2 border border-gray-400"
                                    >
                                        {{ employee.department.name }}
                                    </td>
                                    <td
                                        class="px-2 py-2 border border-gray-400"
                                    >
                                        <WarningButton
                                            @click="
                                                ($event) =>
                                                    openModal(
                                                        2,
                                                        employee.name,
                                                        employee.email,
                                                        employee.phone,
                                                        employee.department.id,
                                                        employee.id
                                                    )
                                            "
                                            :class="'px-4 py-2 border rounded flex text-white bg-yellow-500'"
                                        >
                                            <PencilIcon class="w-5 h-5" />
                                        </WarningButton>
                                    </td>
                                    <td
                                        class="px-2 py-2 border border-gray-400"
                                    >
                                        <DangerButton
                                            @click="deleteEmployee(employee.id)"
                                            class="text-white"
                                        >
                                            <TrashIcon class="w-5 h-5" />
                                        </DangerButton>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="grid v-screen place-items-center">
                        <vueTailwindPaginationUmd
                            :current="employees.current_page"
                            :total="employees.total"
                            :per-page="employees.per_page"
                            @page-changed="($event) => onPageClick($event)"
                        ></vueTailwindPaginationUmd>
                    </div>
                </div>
                <Modal :show="modal" @close="closeModal">
                    <h1 class="p-3 text-xl text-center">{{ title }}</h1>
                    <div class="p-4 mx-4 mb-4 border">
                        <div class="mb-2">
                            <InputLabel for="name" value="Name:" />
                            <TextInput
                                id="name"
                                ref="nameInput"
                                v-model="form.name"
                                class="block w-full mt-1"
                                placeholder="Name"
                            />
                            <InputError
                                class="mt-2"
                                :message="form.errors.name"
                            />
                        </div>
                        <div class="mb-2">
                            <InputLabel for="email" value="Email:" />
                            <TextInput
                                id="email"
                                type="email"
                                v-model="form.email"
                                class="block w-full mt-1"
                                placeholder="Email"
                            />
                            <InputError
                                class="mt-2"
                                :message="form.errors.email"
                            />
                        </div>
                        <div class="mb-2">
                            <InputLabel for="phone" value="Phone number:" />
                            <TextInput
                                id="phone"
                                v-model="form.phone"
                                class="block w-full mt-1"
                                placeholder="Phone number"
                            />
                            <InputError
                                class="mt-2"
                                :message="form.errors.phone"
                            />
                        </div>
                        <div class="mb-2">
                            <InputLabel
                                for="department_id"
                                value="Department:"
                            />
                            <SelectInput
                                id="department_od"
                                :options="departments"
                                v-model="form.department_id"
                                class="block w-full mt-1"
                                placeholder="Department"
                            />
                            <InputError
                                class="mt-2"
                                :message="form.errors.department_id"
                            />
                        </div>
                        <div class="flex gap-2">
                            <PrimaryButton
                                :disabled="form.processing"
                                @click="save"
                            >
                                <PlusCircleIcon class="w-5 h-5" /> Add employee
                            </PrimaryButton>
                            <SecondaryButton
                                :disabled="form.processing"
                                @click="closeModal"
                            >
                                <XCircleIcon class="w-5 h-5" /> Cancel
                            </SecondaryButton>
                        </div>
                    </div>
                </Modal>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
