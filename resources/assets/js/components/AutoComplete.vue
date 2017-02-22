<template>
<div style="position:relative" :class="{'open':openSuggestion}">
    <input class="form-control" type="text" v-model="selection"
        @keydown.enter = 'enter'
        @keydown.down = 'down'
        @keydown.up = 'up'
        @input = 'change'
    />
    <ul class="dropdown-menu" style="width:100%">
        <li v-for="suggestion in matches"
            :class="{'active': isActive(suggestion)}"
            @click="suggestionClick(suggestion)" :key="suggestion.id"
        >
            <a href="#">{{ suggestion.title }}</a>
        </li>
    </ul>
</div>
</template>

<script>
export default {
    data() {
        return {
            open: false,
            current: 0,
            selection: ''
        }
    },
    props: {
        suggestions: {
            type: Array,
            required: true
        },
        /*
        selection: {
            type: String,
            required: true,
             twoWay: true
        },*/
    },
    computed: {
        matches() {
            var sg = this.suggestions.filter((str) => {
              if (this.selection.length >= 3) {
                var str_cap = str.title.toUpperCase()
                return str_cap.indexOf(this.selection.toUpperCase()) >= 0;
              }
            });

            return _.orderBy(sg, 'title')
        },
        openSuggestion() {
            return this.selection !== "" &&
                   this.matches.length != 0 &&
                   this.open === true;
        }
    },
    methods: {
        enter() {
            //this.selection = this.matches[this.current];
            console.log('enter')
            this.selection = index.title
            this.$emit('selected');

            this.open = false;
        },
        up() {
            console.log('up')
            if(this.current > 0)
                this.current--;
        },
        down() {
            if(this.current < this.suggestions.length - 1)
                this.current++;
        },
        isActive(index) {
            return index === this.current;
        },
        change() {
            if (this.open == false) {
                this.open = true;
                this.current = 0;
            }
        },
        suggestionClick(index) {
            // this.selection = this.matches[index];
            this.selection = index.title
            this.$emit('selected', index);
            this.open = false;
        },
    }
}
</script>
