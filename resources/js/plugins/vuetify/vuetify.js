import { createVuetify } from "vuetify";
import defaults from './defaults'
import theme from './theme'
import "@mdi/font/css/materialdesignicons.css";
import "vuetify/styles";

import { VStepper } from 'vuetify/labs/VStepper'



export default createVuetify({
    defaults,
    theme,
    components: {
        VStepper,
      },
});
