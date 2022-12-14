import { createApp } from 'vue';
import Articles from './components/Articles.vue';
import Navbar from './components/Navbar.vue';
import '../css/app.css';

const app = createApp();

app.component('articles', Articles);
app.component('navbar', Navbar);

app.mount('#app');

require('./bootstrap');
