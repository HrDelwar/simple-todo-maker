import {createApp} from "vue"
import App from "./App"
import router from "./router"
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import Unicon from 'vue-unicons'
import {uniTrashAlt} from 'vue-unicons/dist/icons'

Unicon.add([uniTrashAlt])
const app = createApp(App)
app.use(router)
app.use(Unicon)
app.use(VueSweetalert2)
app.mount("#WpSTM")