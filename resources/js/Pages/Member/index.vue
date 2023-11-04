<template>
    <v-app id="inspire">
        <v-app-bar extended>
            <v-app-bar-title class="mt-13">
                <img
                    class="d-none d-sm-block"
                    src="/logo_black.png"
                    alt="Logo CCPPuno"
                    width="250"
                />
                <img
                    class="d-block d-sm-none"
                    src="/logo_ccppuno.png"
                    alt="Logo CCPPuno"
                    width="50"
                />
            </v-app-bar-title>

            <v-spacer></v-spacer>

            <v-menu>
                <template v-slot:activator="{ props }">
                    <v-btn
                        prepend-icon="mdi-account"
                        color="primary"
                        v-bind="props"
                    >
                        {{ user.name }} {{ user.paternal_surname }}
                    </v-btn>
                </template>
                <v-list>
                    <v-list-item @click="signOut">
                        <v-list-item-title>Salir </v-list-item-title>
                    </v-list-item>
                </v-list>
            </v-menu>
        </v-app-bar>

        <v-main>
            <v-container>
                <v-row justify="center">
                    <v-col cols="12" md="8">
                        <v-card class="mt-5">
                            <v-img
                                src="https://lh6.googleusercontent.com/1prBFR9Y3dfmHcgaYVd2nrFs_w3xLuX-H1OneZGmLA5yKqutDRT8BOB8sTXdoDF378Wao9B8zISKnnYNQHl0EuPbk90Ec0RzJkKhJHv-Frm8-JFHErpjNHxdchvz5iGVeg=w1584"
                            ></v-img>

                            <v-card-text>
                                <p>
                                    Estimados participantes de la IX Convención
                                    Nacional de Contabilidad Gubernamental y
                                    Administración Pública, GUBER-2023
                                </p>

                                <p class="mt-2">
                                    Queremos agradecerles a todos por su
                                    participación en este evento tan
                                    significativo. Ha sido un placer contar con
                                    su presencia en la ciudad de Puno.
                                </p>
                                <p class="mt-2">
                                    Esperamos que este congreso haya sido
                                    enriquecedor y productivo para todos, y les
                                    agradecemos por su compromiso con el avance
                                    de nuestra disciplina.
                                </p>
                            </v-card-text>

                            <v-card-actions class="justify-center">
                                <v-btn
                                    variant="flat"
                                    prepend-icon="mdi-certificate-outline"
                                    color="blue"
                                    @click="generateKey(1)"
                                >
                                    Certificado
                                </v-btn>

                                <v-btn
                                    variant="flat"
                                    prepend-icon="mdi-certificate-outline"
                                    color="blue"
                                    @click="generateKey(2)"
                                >
                                    Certificado - Ética
                                </v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-col>
                </v-row>
            </v-container>
        </v-main>
    </v-app>
</template>
<script setup>
import { router } from "@inertiajs/vue3";
import axios from "axios";

const props = defineProps({
    user: Object,
});

const generateKey = async (type) => {
    let data = {
        document: props.user.document,
        event: 1,
        type: type,
    };
    let res = await axios.post("/m/generate-key", data);

    window.open(res.data, "_blank");
};

const signOut = async () => {
    router.delete("sign-out");
};
</script>
