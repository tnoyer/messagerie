<template>
    <div class="row">
        <div class="col-md-3">
            <div class="list-group">
                <a href="#" class="list-group-item d-flex justify-content-between align-items-center">
                    John Doe {{ user }}
                    <span class="badge rounded-pill bg-primary">0</span>
                </a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            user: Number
        },
        mounted() {
            this.$store.dispatch('loadConversations')
        }
    }
</script>
