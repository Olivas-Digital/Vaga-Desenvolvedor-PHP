<template>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr class="bg-dark">
                    <slot name="thead"></slot>
                </tr>
            </thead>
            <tbody>
                <slot name="tbody"></slot>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        
    }
</script>