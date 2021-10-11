// import "../css/app.scss";
require("./bootstrap");
import { createApp } from "vue";
import Index from "./Index.vue";
import router from "./routes";
import PrimeVue from "primevue/config";
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import ColumnGroup from "primevue/columngroup";

import "primevue/resources/themes/saga-blue/theme.css";
import "primevue/resources/primevue.min.css";
import "primeicons/primeicons.css";
import "primeflex/primeflex.css";

createApp({
    components: {
        Index
    }
})
    .use(PrimeVue, { ripple: true })
    .use(router)
    .mount("#app");
