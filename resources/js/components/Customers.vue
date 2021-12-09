<template>
    <div>
        <!-- Search Customers -->
        <card-component title="Pesquisar por Clientes">
            <form action="">
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label>ID</label>
                        <input type="number" name="id" class="form-control" min="1"> 
                    </div><!-- form-group -->
                    <div class="form-group col-sm-6">
                        <label>Nome</label>
                        <input type="text" name="name" class="form-control">
                    </div><!-- form-group -->
                    <div class="form-group col-12">
                        <label>Tipo</label>
                        <select name="type" class="form-control">
                            <option selected>Todos</option>
                            <option value="">Pessoa Física</option>
                            <option value="">Pessoa Jurídica</option>
                        </select>
                    </div><!-- form-group -->
                </div><!-- row -->
                <button class="btn btn-primary">Buscar</button>
            </form>
        </card-component>

        <!-- Customers Table -->
        <card-component title="Relação de Clientes">
            <table-component>
                <template v-slot:thead>
                    <th>ID</th>
                    <th>Imagem</th>
                    <th>Nome</th>
                    <th>Tipo</th>
                    <th></th>
                </template>
                <template v-slot:tbody>
                    <tr v-for="i, key in 5" :key="key">
                        <td scope="row">1</td>
                        <td><img src="http://127.0.0.1:8000\images\people.jpeg" alt="Pessoa" height="50"></td>
                        <td>João da Silva</td>
                        <td>Pessoa Física</td>
                        <td class="text-right">
                            <button class="btn btn-info btn-sm m-1" type="button" data-toggle="modal" data-target="#edit">
                                <i class="fas fa-pencil-alt"></i>
                            </button>
                            <button class="btn btn-primary btn-sm m-1" type="button" data-toggle="modal" data-target="#show">
                                <i class="far fa-eye"></i>
                            </button>
                            <button class="btn btn-danger btn-sm m-1" type="button" data-toggle="modal" data-target="#destroy">
                                <i class="far fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                </template>
            </table-component>
            <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#create">
                Novo Cliente
            </button>
        </card-component>

        <!-- Modal Create Customer -->
        <modal-component title="Novo Cliente" id="create">
            <template v-slot:body>
                <div class="form-group">
                    <label>Imagem</label>
                    <input type="file" name="image" class="form-control-file">
                </div><!-- form-group -->

                <div class="form-group">
                    <label>Nome</label>
                    <input type="text" :name="name" class="form-control">
                </div><!-- form-group -->

                <div class="form-group">
                    <label>E-mail</label>
                    <input type="email" :name="email" class="form-control">
                </div><!-- form-group -->

                <div class="form-group">
                    <label>Tipo</label>
                    <select :name="type" class="form-control">
                        <option value="">Pessoa Física</option>
                        <option value="">Pessoa Jurídica</option>
                    </select>   
                </div><!-- form-group -->

                <div class="form-group">
                    <label>Telefones</label>
                    <div class="form-group" v-for="phone, key in phones" :key="key">
                        <div class="input-group">
                            <input type="text" class="form-control" v-model="phones[key]" :readonly="key != phones.length - 1 ? true : false ">
                            <div class="input-group-append" id="button-addon4">
                                <button v-if="key != phones.length - 1" class="btn btn-danger" type="button" @click="removePhone(key)"><i class="fas fa-minus"></i></button>
                                <button v-if="key == phones.length - 1" class="btn btn-success" type="button" @click="addPhone()"><i class="fas fa-plus"></i></button>
                            </div><!-- input-group-append -->
                        </div><!-- input-group -->
                    </div><!-- form-group -->
                </div><!-- form-group -->

                <label>Vendedores relacionados ao cliente</label>
                <table-component>
                    <template v-slot:thead>
                        <th>ID</th>
                        <th>Nome</th>
                        <th></th>
                    </template>
                    <template v-slot:tbody>
                        <tr v-for="seller, key in sellers" :key="key">
                            <td>1</td>
                            <td>Vitor Manuel</td>
                            <td class="text-right">
                                <button type="button" class="btn btn-danger" @click="removeSeller(key)">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </td>
                        </tr>
                    </template>
                </table-component>

                <div class="form-group">
                    <label>Adicionar Vendedor</label>
                    <div class="input-group">
                        <input type="number" min="1" placeholder="ID do vendedor" class="form-control">
                        <div class="input-group-append">
                            <button class="btn btn-success" type="button" @click="addSeller"><i class="fas fa-plus"></i></button>
                        </div><!-- input-group-append -->
                    </div><!-- input-group -->
                </div><!-- form-group -->
            </template>
            <template v-slot:footer>
                <button type="button" class="btn btn-primary">
                    Cadastrar
                </button>
            </template>
        </modal-component>

        <!-- Modal Edit Customer -->
        <modal-component title="Editar Cliente" id="edit">
            <template v-slot:body>
                <div class="form-group">
                    <label>Imagem</label>
                    <input type="file" name="image" class="form-control-file">
                    <small class="form-text text-muted">*Anexe uma imagem apenas se quiser substitur a atual!</small>
                </div><!-- form-group -->

                <div class="form-group">
                    <label>Nome</label>
                    <input type="text" :name="name" class="form-control">
                </div><!-- form-group -->

                <div class="form-group">
                    <label>E-mail</label>
                    <input type="email" :name="email" class="form-control">
                </div><!-- form-group -->

                <div class="form-group">
                    <label>Tipo</label>
                    <select :name="type" class="form-control">
                        <option value="">Pessoa Física</option>
                        <option value="">Pessoa Jurídica</option>
                    </select>   
                </div><!-- form-group -->

                <div class="form-group">
                    <label>Telefones</label>
                    <div class="form-group" v-for="phone, key in phones" :key="key">
                        <div class="input-group">
                            <input type="text" class="form-control" v-model="phones[key]" :readonly="key != phones.length - 1 ? true : false ">
                            <div class="input-group-append" id="button-addon4">
                                <button v-if="key != phones.length - 1" class="btn btn-danger" type="button" @click="removePhone(key)"><i class="fas fa-minus"></i></button>
                                <button v-if="key == phones.length - 1" class="btn btn-success" type="button" @click="addPhone()"><i class="fas fa-plus"></i></button>
                            </div><!-- input-group-append -->
                        </div><!-- input-group -->
                    </div><!-- form-group -->
                </div><!-- form-group -->
                <label>Vendedores relacionados ao cliente</label>
                <table-component>
                    <template v-slot:thead>
                        <th>ID</th>
                        <th>Nome</th>
                        <th></th>
                    </template>
                    <template v-slot:tbody>
                        <tr v-for="seller, key in sellers" :key="key">
                            <td>1</td>
                            <td>Vitor Manuel</td>
                            <td class="text-right">
                                <button type="button" class="btn btn-danger" @click="removeSeller(key)">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </td>
                        </tr>
                    </template>
                </table-component>

                <div class="form-group">
                    <label>Adicionar Vendedor</label>
                    <div class="input-group">
                        <input type="number" min="1" placeholder="ID do vendedor" class="form-control">
                        <div class="input-group-append">
                            <button class="btn btn-success" type="button" @click="addSeller"><i class="fas fa-plus"></i></button>
                        </div><!-- input-group-append -->
                    </div><!-- input-group -->
                </div><!-- form-group -->
            </template>
            <template v-slot:footer>
                <button type="button" class="btn btn-primary">
                    Salvar Alterações
                </button>
            </template>
        </modal-component>

        <!-- Modal Delete Customer -->
        <modal-component title="Remover Cliente" id="destroy">
            <template v-slot:body>
                 <profile-component 
                name="José da Silva"
                type="Cliente"
                :data="[
                    {title: 'E-mail', value: 'exemplo@gmail.com'},
                    {title: 'Vendedores Relacionados', value: 5},
                ]"></profile-component>

                <p><strong>Vendedores Relacionados</strong></p>
                <table-component>
                    <template v-slot:thead>
                        <th>ID</th>
                        <th>Nome</th>
                    </template>
                    <template v-slot:tbody>
                        <tr>
                            <th>1</th>
                            <th>João</th>
                        </tr>
                        <tr>
                            <th>2</th>
                            <th>Ricardo</th>
                        </tr>
                    </template>
                </table-component>
            </template>
            <template v-slot:footer>
                <button type="button" class="btn btn-danger">
                    Remover
                </button>
            </template>
        </modal-component>

        <!-- Modal Show Customer -->
        <modal-component title="Cliente" id="show">
            <template v-slot:body>
                <profile-component 
                name="José da Silva"
                type="Cliente"
                :data="[
                    {title: 'E-mail', value: 'exemplo@gmail.com'},
                    {title: 'Vendedores Relacionados', value: 5},
                ]"></profile-component>

                <p><strong>Vendedores Relacionados</strong></p>
                <table-component>
                    <template v-slot:thead>
                        <th>ID</th>
                        <th>Nome</th>
                    </template>
                    <template v-slot:tbody>
                        <tr>
                            <th>1</th>
                            <th>João</th>
                        </tr>
                        <tr>
                            <th>2</th>
                            <th>Ricardo</th>
                        </tr>
                    </template>
                </table-component>
            </template>
        </modal-component>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                phones: [''],
                sellers: ['']
            }
        },
        methods: {
            addPhone() {
                this.phones.push('')
            },
            removePhone(key) {
                this.phones.splice(key, 1); 
            },
            addSeller() {
                this.sellers.push('')
            },
            removeSeller(key) {
                this.sellers.splice(key, 1); 
            },
        }
    }
</script>