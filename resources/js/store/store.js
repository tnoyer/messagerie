import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

const get = function (url){
    fetch(url, {
        credentials: "same-origin",
        headers: {
            "X-Requested-With": "XMLHttpRequest",
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
}

/**
 * {
 *     1: {
 *         id: 1,
 *         name: John Doe 1,
 *         unread: 0,
 *         count: 100,
 *         messages: [{
 *             id: 1,
 *             from_id: 2,
 *             to_id: 3,
 *             ...
 *         }]
 *     }
 * }
 */
export default new Vuex.Store({
    strict: true,
    state: {
        conversations: {}
    },
    actions: {
        loadConversations: function (context){
            get('api/conversations')
        }
    }
})
