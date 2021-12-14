<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div v-if="status" class="alert alert-success" role="alert">
                            {{ status }}
                        </div>
                        <h1 class="mb-0 text-center">Bem Vindo!</h1>
                        <hr>
                        <p><strong>Seu token de autorização:</strong></p>
                        <p>{{ token }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['status','token'],
    }
</script>
