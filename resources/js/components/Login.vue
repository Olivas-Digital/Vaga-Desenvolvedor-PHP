<template>
    <form method="post" @submit.prevent="login($event)">
        <!-- @csrf -->
        <div class="input-group mb-3">
            <input type="hidden" :value="csrf_token" name="_token">
            <input type="email" name="email" :class="errors['email'] != null ? 'is-invalid form-control' : 'form-control'"
                   placeholder="E-mail" v-model="email" autofocus>
                   <!-- value="{{ old('email') }}" placeholder="E-mail" autofocus> -->

            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                </div>
            </div>

            <span v-if="errors['email'] != null" class="invalid-feedback" role="alert">
                <strong>{{ errors['email'][0] }}</strong>
            </span>
        </div>
        <div class="input-group mb-3">
            <input type="password" name="password" :class="errors['password'] != null ? 'is-invalid form-control' : 'form-control'"
                   placeholder="Senha" v-model="password">

            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                </div>
            </div>

            <span v-if="errors['password'] != null" class="invalid-feedback" role="alert">
                <strong>{{ errors['password'][0] }}</strong>
            </span>
        </div>

        <button type=submit class="btn btn-block btn-flat btn-primary">
            <span class="fas fa-sign-in-alt"></span>
            Entrar
        </button>

    </form>
</template>

<script>
    export default {
        props: ['csrf_token', 'errors', 'oldEmail'],
        data(){
            return {
                password: '',
                email: this.oldEmail
            }
        },
        methods: {
            login(e) {
                let url = 'http://127.0.0.1:8000/api/auth/login'
                let config = {
                    method: 'post',
                    body: new URLSearchParams({
                        'email': this.email,
                        'password': this.password 
                    })
                }
                fetch(url, config)
                    .then(response => response.json())
                    .then(data => {
                        if(data.access_token){
                            document.cookie = 'token=' + data.access_token +';SameSite=Lax'
                        }
                        e.target.submit()
                    })
            }
        }
    }
</script>
