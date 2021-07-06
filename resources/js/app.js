import Vue from 'vue'
import Messagerie from './components/MessagerieComponent'
import Store from './store/store'

new Vue({
    el: '#messagerie',
    components: {
        Messagerie
    },
    store: Store
})

/*
fetch('/api/user', {
    credentials: "same-origin",
    headers: {
        "X-Requested-With": "XMLHttpRequest",
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    }
})
 */
