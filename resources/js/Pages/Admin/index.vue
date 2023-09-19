<template>
    <v-app id="inspire">
        <v-app-bar extended>
            <v-app-bar-nav-icon></v-app-bar-nav-icon>

            <v-app-bar-title>APP</v-app-bar-title>

            <v-spacer></v-spacer>

            <v-btn icon="mdi-close" @click="signOut"> </v-btn>
            <template #extension>
                <v-spacer></v-spacer>
                <v-tabs v-model="tab" color="primary" align-tabs="end">
                    <v-tab :value="1">PREINSCRIPCIÓN</v-tab>
                    <v-tab :value="2">Pagos</v-tab>
                    <!-- <v-tab :value="3">Facturacion</v-tab> -->
                </v-tabs>
            </template>
        </v-app-bar>

        <v-main>
            <v-container fluid>
                <v-window v-model="tab">
                    <v-window-item :value="1">
                        <v-table>
                            <thead>
                                <tr>
                                    <th class="text-center">-</th>
                                    <th
                                        v-for="header in sheets?.headers"
                                        class="text-left"
                                    >
                                        <small>{{ header }}</small>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(item, rowIndex) in sheets?.data"
                                    :key="item.name"
                                >
                                    <td>
                                        <v-menu>
                                            <template
                                                v-slot:activator="{ props }"
                                            >
                                                <v-btn
                                                    color="primary"
                                                    density="compact"
                                                    variant="tonal"
                                                    icon="mdi-dots-vertical"
                                                    v-bind="props"
                                                ></v-btn>
                                            </template>
                                            <v-list>
                                                <v-list-item
                                                    @click="
                                                        validateMember(
                                                            rowIndex,
                                                            'ACEPTADO',
                                                            item
                                                        )
                                                    "
                                                    title="Aceptar"
                                                />
                                                <v-list-item
                                                    @click="
                                                        validateMember(
                                                            rowIndex,
                                                            'RECHAZADO',
                                                            item
                                                        )
                                                    "
                                                    title="Rechazar"
                                                />
                                            </v-list>
                                        </v-menu>
                                    </td>
                                    <td v-for="header in sheets?.headers">
                                        {{ item[header] }}
                                    </td>
                                </tr>
                            </tbody>
                        </v-table>
                    </v-window-item>
                    <v-window-item :value="2">
                        <MembersAprovet />
                    </v-window-item>
                </v-window>
            </v-container>
        </v-main>
    </v-app>
</template>
<script setup>
import { ref } from "vue";
import { router } from "@inertiajs/vue3";
import axios from "axios";
import MembersAprovet from "./components/MembersAprovet.vue";

const props = defineProps({
    sheets: Object,
});

const tab = ref(1);

const data = ref({
    member: {
        document: null,
        name: null,
        lastname: null,
        deparment: null,
        modality: null,
        type: null,
        email: null,
        phone: null,
        whatsapp: null,
        collegiate_code: null,
        pre_registration_date: null,
        state: null,
    },
    sheet: {
        valueCell: null,
        indexRow: null,
    },
});

const validateMember = async (indexRow, value, item) => {
    console.log(item);

    data.value.member.document = item["N° DNI"];
    data.value.member.name = item["NOMBRES"];
    data.value.member.lastname = item["APELLIDOS"];
    data.value.member.deparment = item["DEPARTAMENTO"];
    data.value.member.modality = item["MODALIDAD DE PARTICIPACIÓN"];
    data.value.member.type = item["PARTICIPANTE"];
    data.value.member.email = item["CORREO PERSONAL"];
    data.value.member.phone = item["N° CELULAR (LLAMADAS)"];
    data.value.member.whatsapp = item["N° WHATSAPP (MENSAJES)"];
    data.value.member.collegiate_code = null;
    data.value.member.pre_registration_date = item["Marca temporal"];
    data.value.member.state = value == "ACEPTADO" ? true : false;

    data.value.sheet.indexRow = indexRow + 2;
    data.value.sheet.valueCell = value;

    console.log(data.value);

    let res = await axios.post("/admin/validate-pre-registration", data.value);

    console.log(res.data);
    // console.log(rowIndex);
};

const signOut = async () => {
    router.delete("sign-out");
};
</script>
