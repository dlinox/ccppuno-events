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
                                <v-row class="py-3">
                                    <v-col cols="4" md="4">
                                        <v-btn
                                            prepend-icon="mdi-file-excel-box-outline"
                                            color="green"
                                            @click="exportarExcel"
                                            >Exportar</v-btn
                                        >
                                    </v-col>

                                    <v-col cols="8" md="6">
                                        <v-text-field
                                            v-model="filter.search"
                                            label="Buscar por DNI"
                                        />
                                    </v-col>
                                </v-row>
                            </template>
                            <template v-slot:action="{ item }">
                                <v-btn
                                    @click="sendEmail(item)"
                                    append-icon="mdi-account-key-outline"
                                >
                                    Enviar acceso
                                </v-btn>

                                <v-btn
                                    @click="resetPassword(item)"
                                    color="black"
                                    class="mt-2"
                                    append-icon="mdi-lock-reset"
                                >
                                    resetear acceso
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
import axios from "axios";
const props = defineProps({
    items: Object,
    headers: Array,
    filters: Object,
    perPageOptions: Array,
});

const url = "/admin/inscribed";
const tab = ref(2);

const exportarExcel = async () => {
    try {
        const response = await axios.get("export-inscribed", {
            responseType: "blob", // Indicar que la respuesta es un archivo binario
        });

        const nombreArchivo =
            response.headers["content-disposition"].split("=")[1];

        const blob = new Blob([response.data], {
            type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
        });

        const link = document.createElement("a");
        link.href = window.URL.createObjectURL(blob);
        link.download = nombreArchivo; // Nombre del archivo de descarga
        link.style.display = "none";
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    } catch (error) {
        console.error(error);
    }
};

const sendEmail = async (item) => {
    // let res = await axios.post("/admin/send-email", {...item} );

    // console.log(res.data);

    router.visit("/admin/send-email", {
        method: "post",
        data: item,
        onSuccess: (page) => {
            alert("Correo Enviado");
        },
        onError: (errors) => {},
        onFinish: (visit) => {},
    });
};

const resetPassword = async (item) => {
    let res = await axios.post("/admin/reset-password", { ...item });
    if (res.data) {
        alert("Contraseña reseteada");
    } else {
        alert("Ocurrio un error, vuelva a intentarlo");
    }
};

const signOut = async () => {
    router.delete("sign-out");
};

const downloadCertificate = async (item) => {
    let res = await axios.get(`/admin/encrypt-term/${item.document}`);
    window.open(res.data, "_blank");
};
</script>
