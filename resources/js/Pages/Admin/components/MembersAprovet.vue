<template>
    <v-table>
        <thead>
            <tr>
                <th class="text-center">Pago</th>
                <th class="text-left">
                    <small>Nombre</small>
                </th>
                <th class="text-left">
                    <small>Correo</small>
                </th>
                <th class="text-left">
                    <small>Llamanas / Whatsapp </small>
                </th>
                <th class="text-left">
                    <small>Modalidad</small>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="item in members" :key="item.id">
                <td>
                    <template v-if="item.payments.length > 0">
                        <v-btn
                            density="compact"
                            @click="openDialogValidate(item)"
                            >Validar</v-btn
                        >
                    </template>
                    <template v-else>
                        <v-btn density="compact" variant="tonal"
                            >Pendiente</v-btn
                        >
                    </template>
                </td>
                <td>{{ item.name }} {{ item.lastname }}</td>
                <td>
                    {{ item.email }}
                </td>

                <td>{{ item.phone }} / {{ item.whatsapp }}</td>

                <td>
                    {{ item.modality }}
                </td>
            </tr>
        </tbody>
    </v-table>

    <v-dialog v-model="dialogValidatePayment">
        <v-card class="mx-auto" min-width="350">
            <v-img
                :src="itemValidatePayment.voucher_image_path"
                contain
            ></v-img>
            <v-list-item subtitle="SERIE" class="border-b">
                <v-list-item-title>
                    {{ itemValidatePayment.series }}
                </v-list-item-title>
            </v-list-item>

            <v-list-item subtitle="MONTO" class="border-b">
                <v-list-item-title>
                    S/. {{ itemValidatePayment.amount }}
                </v-list-item-title>
            </v-list-item>

            <v-list-item subtitle="FEHCA DE PAGO" class="border-b">
                <v-list-item-title>
                    {{ itemValidatePayment.payment_date }}
                </v-list-item-title>
            </v-list-item>
            <v-card-actions>
                <v-btn
                    @click="validatePayment(itemValidatePayment, 'RECHAZADO')"
                    variant="tonal"
                    color="red"
                    >Rechazar</v-btn
                >
                <v-spacer></v-spacer>
                <v-btn
                    @click="validatePayment(itemValidatePayment, 'ACEPTADO')"
                    variant="flat"
                    >Aceptar</v-btn
                >
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>
<script setup>
import axios from "axios";
import { ref } from "vue";

const members = ref(null);

const dialogValidatePayment = ref(false);
const itemValidatePayment = ref(null);

const openDialogValidate = (item) => {
    itemValidatePayment.value = item.payments[0];
    dialogValidatePayment.value = true;
};

const validatePayment = async (pay, validate) => {
    let data = {
        pay: pay,
        validate: validate,
    };
    let res = await axios.post("/admin/validate-payment", data);
    console.log(res.data);
};

const init = async () => {
    let res = await axios.get("/admin/members-aprovet");
    console.log(res.data);
    members.value = res.data.data;
};
init();
</script>
