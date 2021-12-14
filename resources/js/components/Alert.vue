<template>
    <div :class="'alert alert-' + status" role="alert">
        <h4 class="alert-heading">{{ title }}</h4>
        <p>{{ message }}</p>
        <slot></slot>
    </div><!-- alert -->
</template>

<script>
    export default {
        props: ['status', 'title', 'message', 'errors']
    }
</script>