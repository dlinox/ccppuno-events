<template>
  <v-app id="inspire-auth" class="h-screen">
      <v-card width="350" class="mx-auto my-auto pt-5">
          <v-container>
              <v-row>
                  <v-col cols="12">
                      LOGO
                  </v-col>
                  

                  <v-col cols="12" class="text-center">
                      <h3 class="text-h5">Iniciar Sesión</h3>
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
  email: "nearlino20@gmail.com",
  password: "test123***",
});

const submit = async () => {
  form.post("/sign-in", {
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
