<template>
    <div class="container">
        <vue-good-table theme="polar-bear" styleClass="vgt-table striped bordered" :columns="columns" :rows="data"
            :search-options="{
                enabled: true,
            }" :pagination-options="{
    enabled: true,
    mode: 'records',
}" :line-numbers="true">
            <template #table-row="props">
                <span v-if="props.column.field == 'actions'">
                    <button type="button" title="Edit" class="mr-1 text-orange-300" @click="edit(props.row.id)">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button type="button" title="Delete" class="ml-1 text-red-500" @click="remove(props.row.id)">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </span>
                <span v-else>
                    {{ props.formattedRow[props.column.field] }}
                </span>
            </template>
        </vue-good-table>
    </div>
</template>

<script>
export default {
    props: [
        'data',
        'columns',
        'edit',
        'remove',
    ],
};
</script>

