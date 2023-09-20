<template>
    <v-container>
        <v-row justify="center">
            <v-col v-if="verified" cols="12" md="6">
                <v-card class="mt-5">
                    <v-card-title class="text-center">
                        <v-icon large color="green">mdi-check-circle</v-icon>
                        <span class="ml-3">¡Correo verificado con éxito!</span>
                    </v-card-title>

                    <v-card-text>
                        ¡Gracias por verificar tu dirección de correo
                        electrónico Convención GUBER2023!
                        <br /><br />
                        <strong>Próximo paso:</strong> Verificaremos el estado
                        de tu pago. Una vez confirmado, recibirás un correo
                        electrónico final para confirmar tu participación en la
                        convención. <br /><br />
                        Te recomendamos revisar tu bandeja de entrada y la
                        carpeta de spam durante los próximos días para
                        asegurarte de recibir nuestras comunicaciones. Estamos
                        emocionados de tenerte con nosotros en GUBER2023.
                    </v-card-text>

                    <!-- <v-card-actions class="justify-center">
            <v-btn color="primary" >Ir al Dashboard</v-btn>
          </v-card-actions> -->
                </v-card>
            </v-col>

            <v-col v-else cols="12" md="6">
                <v-card class="mt-5">
                    <v-card-title class="text-center red--text">
                        <v-icon large color="red">mdi-alert-circle</v-icon>
                        <span class="ml-3"
                            >Error en la verificación del correo</span
                        >
                    </v-card-title>

                    <v-card-text>
                        Lamentablemente, no pudimos verificar tu dirección de
                        correo electrónico para GUBER2023.
                        <br /><br />
                        Es posible que el enlace haya expirado o no sea válido.
                        Por favor, verifica si has utilizado el enlace más
                        reciente que te enviamos o solicita un nuevo enlace de
                        verificación.
                        <br /><br />
                        Si el problema persiste, por favor contacta a nuestro
                        equipo de soporte.
                    </v-card-text>

                    <!-- <v-card-actions class="justify-center">
            <v-btn color="primary" @click="requestNewLink">Solicitar nuevo enlace</v-btn>
          </v-card-actions> -->
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>
<script setup>
const props = defineProps({
    verified: Boolean,
});
</script>
