<template>
    <Head title="Registro | GUBER 2023" />
    <v-app id="app-landing">
        <v-main class="h-100">
            <v-row no-gutters>
                <v-col cols="12" md="7" class="col-form">
                    <div class="mx-10 pt-5">
                        <!-- <h1 class="text-md-h2 text-h3 font-weight-black">
                            GUBER 2023
                        </h1>
                        <h3 class="text-primary">
                            IX CONVENSION NACIONAL CONTABILIDAD GUBERNAMENTAL Y
                            ADMINISTRACIÓN PÚBLICA
                        </h3> -->
                    </div>

                    <v-form ref="formRegister" @submit.prevent="submit">
                        <v-card
                            class="mt-4 mx-auto bg-transparent"
                            flat
                            max-width="600"
                        >
                            <v-toolbar
                                density="compact"
                                title="Datos Personales"
                                color="primary"
                            >
                            </v-toolbar>
                            <v-container>
                                <v-row>
                                    <v-col cols="12">
                                        <v-alert type="info" variant="tonal">
                                            Por favor, complete todos los campos
                                            de manera cuidadosa, ya que serán
                                            validados posteriormente.
                                        </v-alert>
                                    </v-col>
                                    <!-- <v-col cols="12" class="d-flex">
                                        <v-text-field
                                            density="compact"
                                            v-model="form.collegiate_code"
                                            label="Codigo de matricula"
                                            :readonly="!isMember"
                                            :rules="
                                                isMember ? [isRequired] : []
                                            "
                                            :error-messages="
                                                form.errors.collegiate_code
                                            "
                                        >
                                            <template #prepend>
                                                <v-tooltip location="bottom">
                                                    <template
                                                        v-slot:activator="{
                                                            props,
                                                        }"
                                                    >
                                                        <v-checkbox
                                                            style="width: 25px"
                                                            density="compact"
                                                            v-bind="props"
                                                            v-model="isMember"
                                                        />
                                                    </template>

                                                    SOY COLEGIADO
                                                </v-tooltip>
                                            </template>
                                        </v-text-field>
                                    </v-col> -->
                                    <v-col cols="12">
                                        {{ member }}
                                    </v-col>
                                    <v-col cols="12">
                                        {{ payment }}
                                    </v-col>
                                </v-row>
                            </v-container>
                        </v-card>

                        <v-card
                            class="mx-auto bg-transparent"
                            flat
                            max-width="600"
                        >
                            <v-toolbar
                                color="primary"
                                density="compact"
                                title="Datos del pago"
                            >
                            </v-toolbar>

                            <v-container>
                                <v-row>
                                    <v-col cols="12" sm="6">
                                        <v-row>
                                            <v-col cols="12">
                                                <v-text-field
                                                    v-model="form.series"
                                                    label="Serie / N° de Operación "
                                                    :rules="[isRequired]"
                                                    :error-messages="
                                                        form.errors.series
                                                    "
                                                />
                                            </v-col>
                                            <v-col cols="12">
                                                <v-text-field
                                                    v-model="form.amount"
                                                    label="Monto"
                                                    :rules="[isRequired]"
                                                    :error-messages="
                                                        form.errors.amount
                                                    "
                                                />
                                            </v-col>
                                            <v-col cols="12">
                                                <v-text-field
                                                    v-model="form.payment_date"
                                                    label="Fecha"
                                                    type="date"
                                                    :rules="[isRequired]"
                                                    :error-messages="
                                                        form.errors.payment_date
                                                    "
                                                />
                                            </v-col>
                                        </v-row>
                                    </v-col>

                                    <v-col>
                                        <CropCompressImage
                                            :aspect-ratio="1"
                                            @onCropper="
                                                (preview_img = $event.blob),
                                                    (form.voucher_image_file =
                                                        $event.file)
                                            "
                                        />

                                        <v-card variant="tonal">
                                            <v-alert
                                                v-if="
                                                    form.errors
                                                        .voucher_image_file
                                                "
                                                type="error"
                                            >
                                                {{
                                                    form.errors
                                                        .voucher_image_file
                                                }}
                                            </v-alert>
                                            <v-img
                                                v-if="preview_img"
                                                aspect-ratio="16/9"
                                                contain
                                                :src="preview_img"
                                            ></v-img>
                                        </v-card>
                                    </v-col>
                                </v-row>
                            </v-container>
                        </v-card>

                        <v-card
                            variant="tonal"
                            class="my-4 mx-auto"
                            max-width="600"
                        >
                            <v-btn
                                :loading="form.processing"
                                type="submit"
                                block
                                variant="tonal"
                            >
                                Registrarme
                            </v-btn>
                        </v-card>
                    </v-form>
                </v-col>

                <!-- <v-col
                    :cols="false"
                    md="5"
                    class="md-hidden"
                    style="
                        min-height: 100vh;
                        background-image: url('/banner-event.jpeg');
                        background-position: right top;
                        background-repeat: no-repeat;
                        background-size: contain;
                    "
                ></v-col> -->
            </v-row>
        </v-main>

        <v-snackbar v-model="snackbarSuccess" multi-line color="success">
            ¡Registro realizado con exito.!
        </v-snackbar>
    </v-app>
</template>
<script setup>
import CropCompressImage from "@/components/CropCompressImage.vue";
import { isRequired } from "@/helpers/validations.js";
import { useForm, Head } from "@inertiajs/vue3";
import { ref, watch } from "vue";

const props = defineProps({
    member: Object,
    payment: Array,
});

const preview_img = ref(null);
const isMember = ref(false);
const formRegister = ref(null);
const snackbarSuccess = ref(false);

const form = useForm({
    collegiate_code: null,
    isMember: false,
    memberId: props.member.id,

    series: null,
    amount: null,
    payment_date: null,
    voucher_image_file: null,
});

watch(isMember, (val) => {
    console.log(val);
    form.isMember = val;
    form.collegiate_code = null;
});

const submit = async () => {
    const { valid } = await formRegister.value.validate();
    if (!valid) return;
    console.log("valido");
    form.post("/register", {
        onSuccess: () => {
            console.log("registro exitoso");
            preview_img.value = null;
            snackbarSuccess.value = true;
            form.reset();
        },
    });
};
</script>
<style lang="scss">
#app-landing {
    width: 100%;
    min-height: 100vh;
    .col-banner {
        background-color: #0a1b4f;
    }
    .col-form {
        overflow: hidden;
    }
}
</style>
