<template>
    <v-app id="inspire-auth" class="h-screen">
        <v-card width="350" class="mx-auto my-auto">

            <v-img
                src="https://lh6.googleusercontent.com/1prBFR9Y3dfmHcgaYVd2nrFs_w3xLuX-H1OneZGmLA5yKqutDRT8BOB8sTXdoDF378Wao9B8zISKnnYNQHl0EuPbk90Ec0RzJkKhJHv-Frm8-JFHErpjNHxdchvz5iGVeg=w1584"
            ></v-img>

            <v-container>
                <v-row>
                

                    <v-col cols="12" class="text-center">
                        <h3 class="text-h5">Iniciar Sesión - Participante</h3>
                    </v-col>

                    <v-col cols="12" class="text-center">
                        <v-form ref="formRef" @submit.prevent="submit">
                            <v-text-field
                                v-model="form.email"
                                prependInnerIcon="mdi-account"
                                class="mb-4"
                                label="Usuario"
                            />
                            <v-text-field
                                v-model="form.password"
                                prependInnerIcon="mdi-key"
                                class="mb-4"
                                label="Contraseña"
                                type="password"
                            />
                            <v-btn
                                type="submit"
                                block
                                :loading="form.processing"
                            >
                                Ingresar
                            </v-btn>
                        </v-form>
                    </v-col>
                </v-row>
            </v-container>
            <v-card-actions>
                <small class="w-100 py-1 text-center">
                    © 2023 todos los derechos reservados
                </small>
            </v-card-actions>
        </v-card>
    </v-app>
</template>
<script setup>
import { useForm } from "@inertiajs/vue3";

const form = useForm({
    email: "",
    password: "",
});

const submit = async () => {
    form.post("/member/sign-in", {
        onError: (e) => {
            console.log(e);
        },
        onSuccess: (e) => {
            console.log(e);
            console.log("redireccionando");
        },
    });
};
</script>
