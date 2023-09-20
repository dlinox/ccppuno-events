<template>
    <v-app id="inspire">
        <v-app-bar app extended>
            <v-app-bar-title>Inscripciones - GUBER2023</v-app-bar-title>
            <v-spacer></v-spacer>
            <v-btn icon="mdi-logout-variant" @click="signOut"> </v-btn>
            <template #extension>
                <v-spacer></v-spacer>
                <v-tabs v-model="tab" color="primary" align-tabs="end">
                    <v-tab
                        :value="1"
                        @click="
                            () => {
                                router.get('/admin');
                            }
                        "
                    >
                        PREINSCRIPCIÓN
                    </v-tab>
                    <v-tab
                        :value="2"
                        @click="
                            () => {
                                router.get('/admin/inscribed');
                            }
                        "
                    >
                        INSCRITOS
                    </v-tab>
                </v-tabs>
            </template>
        </v-app-bar>

        <v-main>
            <v-container fluid>
                <v-card>
                    <v-card-item>
                        <DataTable
                            :headers="headers"
                            :items="items"
                            with-action
                            :url="url"
                        >
                            <template v-slot:header="{ filter }">
                                <v-row class="py-3" justify="end">
                                    <v-col cols="6">
                                        <v-text-field
                                            v-model="filter.search"
                                            label="Buscar por DNI"
                                        />
                                    </v-col>
                                </v-row>
                            </template>
                            <template v-slot:action="{ item }">
                                <v-btn @click="sendEmail(item)">
                                    Enviar CORREO
                                </v-btn>
                            </template>
                        </DataTable>
                    </v-card-item>
                </v-card>
            </v-container>
        </v-main>
    </v-app>
</template>
<script setup>
import { ref } from "vue";
import { router } from "@inertiajs/vue3";
import DataTable from "@/components/DataTable.vue";
const props = defineProps({
    items: Object,
    headers: Array,
    filters: Object,
    perPageOptions: Array,
});

const url = "/admin/inscribed";
const tab = ref(2);

const sendEmail = (item) => {
    

    router.visit("/admin/send-email", {
        method: "post",
        data: item,
        onSuccess: (page) => {
            alert('Correo Enviado');
        },
        onError: (errors) => {},
        onFinish: (visit) => {},
    });
};

// const data = ref({
//     member: {
//         document: null,
//         name: null,
//         lastname: null,
//         deparment: null,
//         modality: null,
//         type: null,
//         email: null,
//         phone: null,
//         whatsapp: null,
//         collegiate_code: null,
//         pre_registration_date: null,
//         state: null,
//     },
//     sheet: {
//         valueCell: null,
//         indexRow: null,
//     },
// });
// const validateMember = async (indexRow, value, item) => {
//     console.log(item);

//     data.value.member.document = item["N° DNI"];
//     data.value.member.name = item["NOMBRES"];
//     data.value.member.lastname = item["APELLIDOS"];
//     data.value.member.deparment = item["DEPARTAMENTO"];
//     data.value.member.modality = item["MODALIDAD DE PARTICIPACIÓN"];
//     data.value.member.type = item["PARTICIPANTE"];
//     data.value.member.email = item["CORREO PERSONAL"];
//     data.value.member.phone = item["N° CELULAR (LLAMADAS)"];
//     data.value.member.whatsapp = item["N° WHATSAPP (MENSAJES)"];
//     data.value.member.collegiate_code = null;
//     data.value.member.pre_registration_date = item["Marca temporal"];
//     data.value.member.state = value == "ACEPTADO" ? true : false;

//     data.value.sheet.indexRow = indexRow + 2;
//     data.value.sheet.valueCell = value;

//     console.log(data.value);

//     let res = await axios.post("/admin/validate-pre-registration", data.value);

//     console.log(res.data);
//     // console.log(rowIndex);
// };

const signOut = async () => {
    router.delete("sign-out");
};
</script>
