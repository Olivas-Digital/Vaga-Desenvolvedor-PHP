<template>
    <div class="card">
        <div class="card-header">
            <h3 class="mb-0">{{ title }}</h3>
        </div><!-- card-header -->
        <div class="card-body">
            <slot></slot>
        </div><!-- card-body -->
    </div><!-- card -->
</template>

<script>
    export default {
        props: ['title']
    }
</script>