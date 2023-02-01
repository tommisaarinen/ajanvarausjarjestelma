require('./bootstrap')

import { createApp } from 'vue'
import AdminTools from './components/AdminTools.vue'
import { library } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { faClock, faFloppyDisk, faPenToSquare, faTrashCan } from '@fortawesome/free-regular-svg-icons'
import { faArrowRightFromBracket, faArrowRightToBracket, faPlus, faUserPlus } from '@fortawesome/free-solid-svg-icons'

library.add(faPenToSquare)
library.add(faTrashCan)
library.add(faPlus)
library.add(faUserPlus)
library.add(faClock)
library.add(faArrowRightFromBracket)
library.add(faArrowRightToBracket)
library.add(faFloppyDisk)

const app = createApp({}) 

app.component('admin-tools', AdminTools)
app.component('font-awesome-icon', FontAwesomeIcon)

app.mount('#app')