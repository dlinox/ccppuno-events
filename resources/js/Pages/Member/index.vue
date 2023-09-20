<template>
    <v-container>
        <v-row justify="center">
            <v-col cols="12" md="8">
                <v-card class="mt-5">
                    <v-card-title class="text-center">
                        <v-icon large color="orange">mdi-timer-sand</v-icon>
                        <span class="ml-3">Paciencia, por favor</span>
                    </v-card-title>

                    <v-card-text>
                        Nuestro sistema se habilitará próximamente, justo cuando
                        esté por iniciar el evento GUBER2023. Agradecemos tu
                        paciencia y comprensión. ¡Estamos trabajando para
                        brindarte la mejor experiencia!
                    </v-card-text>

                    <v-card-actions class="justify-center">
                        <v-btn
                            prepend-icon="mdi-logout-variant"
                            color="red"
                            @click="signOut"
                        >
                            Salir
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>
<script setup>
import { router } from "@inertiajs/vue3";

const signOut = async () => {
    router.delete("sign-out");
};
</script>
