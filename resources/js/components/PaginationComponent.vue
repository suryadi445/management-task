<template>
    <div class="my-4 pagination">
        <ul class="flex">
            <li v-if="currentPage > 1" @click="paginate(currentPage - 1)" class="px-2 py-1 mr-1 bg-gray-200 cursor-pointer">
                &laquo;</li>
            <li v-for="page in totalPages" :key="page" @click="paginate(page)"
                :class="['px-2 py-1 mr-1', { 'bg-blue-500 text-white': page === currentPage, 'bg-gray-200': page !== currentPage, 'cursor-pointer': page !== currentPage }]">
                {{ page }}</li>
            <li v-if="currentPage < totalPages" @click="paginate(currentPage + 1)"
                class="px-2 py-1 ml-1 bg-gray-200 cursor-pointer">&raquo;</li>
        </ul>
    </div>
</template>

<script>
export default {
    props: {
        currentPage: {
            type: Number,
            required: true,
        },
        totalPages: {
            type: Number,
            required: true,
        },
    },
    methods: {
        paginate(page) {
            this.$emit('page-changed', page);
        },
    },
};
</script>

<style scoped>
.pagination {
    display: flex;
    justify-content: center;
}

ul {
    list-style: none;
    padding: 0;
    display: flex;
}
</style>
