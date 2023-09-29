<script setup>
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { PlusCircleIcon } from "@heroicons/vue/24/outline";
import { Head, useForm } from "@inertiajs/vue3";

const props = defineProps({ department: { type: Object } });

const form = useForm({
    name: props.department.name,
});
</script>

<template>
    <Head title="Update Department" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-300">
                Update Department
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div
                            class="max-w-md px-6 py-8 mx-auto overflow-hidden border"
                        >
                            <form
                                @submit.prevent="
                                    form.patch(
                                        route('departments.update', department)
                                    )
                                "
                            >
                                <div>
                                    <InputLabel for="name" value="Department" />
                                    <TextInput
                                        id="name"
                                        type="text"
                                        class="block w-full mt-1"
                                        v-model="form.name"
                                        required
                                        autofocus
                                        autocomplete="name"
                                        :value="form.name"
                                    />

                                    <InputError
                                        class="mt-2"
                                        :message="form.errors.name"
                                    />
                                </div>
                                <div class="flex items-center mt-4">
                                    <PrimaryButton
                                        :class="{
                                            'opacity-25': form.processing,
                                        }"
                                        :disabled="form.processing"
                                    >
                                        <PlusCircleIcon class="w-5 h-5 mr-1" />
                                        Update department
                                    </PrimaryButton>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
