import './bootstrap';
import {createApp} from 'vue';
import Index from "./components/Index.vue";
import {VueEditor} from "vue3-editor";

const app = createApp(Index);
app.component('vue-editor', VueEditor);

app.mount('#app');
