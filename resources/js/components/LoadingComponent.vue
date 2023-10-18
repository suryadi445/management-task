<template>
    <div class="vl-parent">
        <loading v-model:active="isLoading" :can-cancel="false" :is-full-page="fullPage" />
    </div>
</template>

<script>
export default {
    data() {
        return {
            isLoading: false,
            fullPage: true
        }
    }
}
</script>