import './bootstrap';

import { createApp } from 'vue'
import index from './router'

import App from './App.vue'

const app = createApp(App)
app.use(index)
app.mount("#app")
