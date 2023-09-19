<template>
    <v-app id="inspire">
        <v-app-bar extended>
            <v-app-bar-nav-icon></v-app-bar-nav-icon>

            <v-app-bar-title>Application</v-app-bar-title>

            <v-spacer></v-spacer>

            <v-btn icon="mdi-close" @click="signOut"> </v-btn>
            <template #extension>
                <v-spacer></v-spacer>
                <v-tabs v-model="tab" color="primary" align-tabs="end">
                    <v-tab :value="1">PREINSCRIPCIÓN</v-tab>
                    <v-tab :value="2">Pagos</v-tab>
                    <v-tab :value="3">Facturacion</v-tab>
                </v-tabs>
            </template>
        </v-app-bar>

        <v-main>
            <v-container fluid>
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
                                    <template v-slot:activator="{ props }">
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
                                            @click="aceptMember(rowIndex)"
                                            title="Aceptar"
                                        />
                                        <v-list-item
                                            @click="rejectMember(rowIndex)"
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
            </v-container>
        </v-main>
    </v-app>
</template>
<script setup>
import { ref } from "vue";
import { router } from "@inertiajs/vue3";
import axios from "axios";

const props = defineProps({
    sheets: Object,
});

const tab = ref(1);

const aceptMember = async (rowIndex) => {
    let data = {
        row: rowIndex + 2,
    };

    let res = await axios.post("/admin/update-menber-sheet", data);

    console.log(res.data);
    console.log(rowIndex);
};
const rejectMember = (rowIndex) => {
    console.log(rowIndex);
};

const signOut = async () => {
    router.delete("sign-out");
};
</script>
