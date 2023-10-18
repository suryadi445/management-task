<template>
    <input v-model="searchKeyword" @input="onSearch" type="text"
        class="w-full px-2 py-1 mr-2 border rounded-md outline-blue-500 sm:w-auto" placeholder="Cari...">
</template>

<script>
export default {
    data() {
        return {
            searchKeyword: ''
        };
    },
    methods: {
        onSearch() {
            this.$emit('search', this.searchKeyword);
        }
    }
};
</script>
