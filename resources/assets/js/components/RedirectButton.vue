<template>
<button class="btn btn-primary" v-on:click="redirecting">{{ label }}</button>
</template>

<script>
    export default {
        created() {
        },

        ready() {
            console.log('Redirect Button component ready.')
        },

        props: ['label', 'redirect'],

        methods: {
          redirecting: function(e) {
            e.preventDefault();
            window.location = this.redirect;
          }
        }
    }
</script>
