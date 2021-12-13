<template> <!-- Erro customer_type.name em modal show e destroy -->
    <div>
        <!-- Search Customers -->
        <card-component title="Pesquisar por Clientes">
            <form action="">
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label>ID</label>
                        <input type="number" v-model="filter.id" class="form-control" min="1"> 
                    </div><!-- form-group -->
                    <div class="form-group col-sm-6">
                        <label>Nome</label>
                        <input type="text" v-model="filter.name" class="form-control">
                    </div><!-- form-group -->
                    <div class="form-group col-12">
                        <label>Tipo</label>
                        <select v-model="filter.customer_type_id" class="form-control">
                            <option value="" selected>Todos</option>
                            <option :value="type.id" v-for="type in customerTypes" :key="type.id">{{ type.name }}</option>
                        </select>
                    </div><!-- form-group -->
                </div><!-- row -->
                <button type="button" class="btn btn-primary" @click="search()">Buscar</button>
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
                    <tr v-for="customer, key in customers.data" :key="key">
                        <td scope="row">{{ customer.id }}</td>
                        <td><img :src="url + '/storage/' + customer.image" alt="Foto do Cliente" height="50"></td>
                        <td>{{ customer.name }}</td>
                        <td>{{ customer.customer_type.name }}</td>
                        <td class="text-right">
                            <button class="btn btn-info btn-sm m-1" type="button" data-toggle="modal" data-target="#edit" @click="setCustomer(customer)">
                                <i class="fas fa-pencil-alt"></i>
                            </button>
                            <button class="btn btn-primary btn-sm m-1" type="button" data-toggle="modal" data-target="#show" @click="setCustomer(customer)">
                                <i class="far fa-eye"></i>
                            </button>
                            <button class="btn btn-danger btn-sm m-1" type="button" data-toggle="modal" data-target="#destroy" @click="setCustomer(customer)">
                                <i class="far fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                </template>
            </table-component>

            <nav aria-label="Page navigation example" style="cursor: pointer;">
                <ul class="pagination">
                    <li :class="link.active ? 'page-item active' : 'page-item'" v-for="link, key in customers.links" :key="key">
                        <a class="page-link" @click="paginate(link)" v-html="link.label"></a>
                    </li>
                </ul><!-- pagination -->
            </nav>
            
            <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#create" @click="resetCustomer()">
                Novo Cliente
            </button>
        </card-component>

        <!-- Modal Create Customer -->
        <modal-component title="Novo Cliente" id="create">
            <template v-slot:body>
                <alert-component :title="alert.title" :status="alert.status" :message="alert.message" v-if="alert.status == 'success'"></alert-component>
                <alert-component :title="alert.title" :status="alert.status" :message="alert.message" v-if="alert.status == 'danger'">
                    <hr>
                    <ul>
                        <li v-for="error, key in alert.errors" :key="key">{{ error[0] }}</li>
                    </ul>
                </alert-component>
                <div class="form-group">
                    <label>Imagem</label>
                    <input type="file" name="image" class="form-control-file" @change="loadFile($event)">
                </div><!-- form-group -->

                <div class="form-group">
                    <label>Nome</label>
                    <input type="text" v-model="customer.name" class="form-control">
                </div><!-- form-group -->

                <div class="form-group">
                    <label>E-mail</label>
                    <input type="email" v-model="customer.email" class="form-control">
                </div><!-- form-group -->

                <div class="form-group">
                    <label>Tipo</label>
                    <select v-model="customer.customer_type_id" class="form-control">
                        <option :value="type.id" v-for="type in customerTypes" :key="type.id">{{ type.name }}</option>
                    </select>   
                </div><!-- form-group -->

                <div class="form-group">
                    <label>Telefones</label>
                    <div class="form-group" v-for="phone, key in customer.phones" :key="key">
                        <div class="input-group">
                            <input type="text" class="form-control" v-model="customer.phones[key]" :readonly="key != customer.phones.length - 1 ? true : false ">
                            <div class="input-group-append" id="button-addon4">
                                <button v-if="key != customer.phones.length - 1" class="btn btn-danger" type="button" @click="removePhone(key)"><i class="fas fa-minus"></i></button>
                                <button v-if="key == customer.phones.length - 1" class="btn btn-success" type="button" @click="addPhone()"><i class="fas fa-plus"></i></button>
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
                        <tr v-for="seller, key in customer.sellers" :key="key">
                            <td>{{ seller.id }}</td>
                            <td>{{ seller.name }}</td>
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
                        <input type="number" min="1" placeholder="ID do vendedor" class="form-control" v-model="seller.id">
                        <div class="input-group-append">
                            <button class="btn btn-success" type="button" @click="addSeller()"><i class="fas fa-plus"></i></button>
                        </div><!-- input-group-append -->
                    </div><!-- input-group -->
                    <div class="text-danger" v-if="seller.error != ''">
                        <span>{{ seller.error }}</span>
                    </div><!-- text-danger -->
                </div><!-- form-group -->
            </template>
            <template v-slot:footer>
                <button type="button" class="btn btn-primary" @click="createCustomer()">
                    Cadastrar
                </button>
            </template>
        </modal-component>

        <!-- Modal Edit Customer -->
        <modal-component title="Editar Cliente" id="edit">
            <template v-slot:body>
                <alert-component :title="alert.title" :status="alert.status" :message="alert.message" v-if="alert.status == 'success'"></alert-component>
                <alert-component :title="alert.title" :status="alert.status" :message="alert.message" v-if="alert.status == 'danger'">
                    <hr>
                    <ul>
                        <li v-for="error, key in alert.errors" :key="key">{{ error[0] }}</li>
                    </ul>
                </alert-component>
                <div class="form-group">
                    <label>Imagem</label>
                    <input type="file" name="image" class="form-control-file" @change="loadFile($event)">
                    <small class="form-text text-muted">*Anexe uma imagem apenas se quiser substitur a atual!</small>
                </div><!-- form-group -->

                <div class="form-group">
                    <label>Nome</label>
                    <input type="text" v-model="customer.name" class="form-control">
                </div><!-- form-group -->

                <div class="form-group">
                    <label>E-mail</label>
                    <input type="email" v-model="customer.email" class="form-control">
                </div><!-- form-group -->

                <div class="form-group">
                    <label>Tipo</label>
                    <select v-model="customer.customer_type_id" class="form-control">
                        <option :selected="customer.customer_type_id == type.id ? true : false" :value="type.id" v-for="type in customerTypes" :key="type.id">{{ type.name }}</option>
                    </select> 
                </div><!-- form-group -->

                <div class="form-group">
                    <label>Telefones</label>
                    <div class="form-group" v-for="phone, key in customer.phones" :key="key">
                        <div class="input-group">
                            <input type="text" class="form-control" v-model="customer.phones[key]" :readonly="key != customer.phones.length - 1 ? true : false ">
                            <div class="input-group-append" id="button-addon4">
                                <button v-if="key != customer.phones.length - 1" class="btn btn-danger" type="button" @click="removePhone(key)"><i class="fas fa-minus"></i></button>
                                <button v-if="key == customer.phones.length - 1" class="btn btn-success" type="button" @click="addPhone()"><i class="fas fa-plus"></i></button>
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
                        <tr v-for="seller, key in customer.sellers" :key="key">
                            <td>{{ seller.id }}</td>
                            <td>{{ seller.name }}</td>
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
                        <input type="number" min="1" placeholder="ID do vendedor" class="form-control" v-model="seller.id">
                        <div class="input-group-append">
                            <button class="btn btn-success" type="button" @click="addSeller()"><i class="fas fa-plus"></i></button>
                        </div><!-- input-group-append -->
                    </div><!-- input-group -->
                </div><!-- form-group -->
            </template>
            <template v-slot:footer>
                <button type="button" class="btn btn-primary" @click="updateCustomer()">
                    Salvar Alterações
                </button>
            </template>
        </modal-component>

        <!-- Modal Delete Customer -->
        <modal-component title="Remover Cliente" id="destroy">
            <template v-slot:body>
                <alert-component :title="alert.title" :status="alert.status" :message="alert.message" v-if="alert.status != ''"></alert-component>
                <div v-if="alert.status == ''">
                    <profile-component 
                    :name="customer.name"
                    type="Cliente"
                    :image="url + '/storage/' + customer.image"
                    :data="[
                        {title: 'E-mail', value: customer.email},
                        {title: 'Tipo de Cliente', value: customer.customer_type.name},
                        {title: 'Vendedores Relacionados', value: customer.sellers.length},
                    ]"></profile-component>

                    <p><strong>Telefones:</strong></p>
                    <ul class="list-group">
                        <li class="list-group-item" v-for="phone, key in customer.phones" :key="key">{{ phone.phone }}</li>
                    </ul>

                    <p><strong>Vendedores Relacionados</strong></p>
                    <table-component>
                        <template v-slot:thead>
                            <th>ID</th>
                            <th>Nome</th>
                        </template>
                        <template v-slot:tbody>
                            <tr v-for="seller, key in customer.sellers" :key="key">
                                <th>{{ seller.id }}</th>
                                <th>{{ seller.name }}</th>
                            </tr>
                        </template>
                    </table-component>
                </div>
            </template>
            <template v-slot:footer>
                <button type="button" class="btn btn-danger" @click="destroyCustomer()"  v-if="alert.status == ''">
                    Remover
                </button>
            </template>
        </modal-component>

        <!-- Modal Show Customer -->
        <modal-component title="Cliente" id="show">
            <template v-slot:body>
                <profile-component 
                :name="customer.name"
                type="Cliente"
                :image="url + '/storage/' + customer.image"
                :data="[
                    {title: 'E-mail', value: customer.email},
                    {title: 'Tipo de Cliente', value: customer.customer_type.name},
                    {title: 'Vendedores Relacionados', value: customer.sellers.length},
                ]"></profile-component>

                <p><strong>Telefones:</strong></p>
                <ul class="list-group">
                    <li class="list-group-item" v-for="phone, key in customer.phones" :key="key">{{ phone }}</li>
                </ul>

                <p><strong>Vendedores Relacionados</strong></p>
                <table-component>
                    <template v-slot:thead>
                        <th>ID</th>
                        <th>Nome</th>
                    </template>
                    <template v-slot:tbody>
                        <tr v-for="seller, key in customer.sellers" :key="key">
                            <th>{{ seller.id }}</th>
                            <th>{{ seller.name }}</th>
                        </tr>
                    </template>
                </table-component>
            </template>
        </modal-component>
    </div>
</template>

<script>
    export default {
        props: ['url', 'customerTypes'],
        data() {
            return {
                filter: {
                    name: '',
                    email: '', 
                    customer_type_id: '',
                },
                alert: {
                    status: '',
                    title: '',
                    message: '',
                    errors: [],
                },
                paginateUrl: 'page=1',
                searchUrl: '',
                customers: {},
                customer: {
                    name: '',
                    email: '',
                    image: '',
                    phones: [''],
                    sellers: [],
                    customer_type_id: null,
                },
                seller: {
                    id: '',
                    error: '',
                },
            }
        },
        methods: {
            // Reset Atributes
            resetSeller() {
                this.seller = {
                    id: '',
                    error: '',
                }
            },
            resetAlert() {
                this.alert = {
                    status: '',
                    title: '',
                    message: '',
                    errors: [],
                }
            },
            resetCustomer() {
                this.customer = {
                    name: '',
                    email: '',
                    image: '',
                    phones: [''],
                    sellers: [],
                    customer_type_id: null,
                }
            },
            // Add and Remove multi valued attributes 
            addPhone() {
                this.customer.phones.push('')
            },
            removePhone(key) {
                this.customer.phones.splice(key, 1); 
            },
            addSeller() {
                let url = this.url + '/api/sellers/' + this.seller.id
                axios.get(url)
                    .then(response => {
                        this.customer.sellers.push(response.data)
                        this.resetSeller()
                    })
                    .catch(error => {
                        this.seller.error = error.response.data.error
                    })
                
            },
            removeSeller(key) {
                this.customer.sellers.splice(key, 1); 
            },
            // Customers table buttons
            setCustomer(customer) {
                let phones = []
                customer.phones.map(phone => {
                    phones.push(phone.phone)
                })
                this.customer = JSON.parse(JSON.stringify(customer))
                this.customer.phones = phones
                this.resetAlert()
            },
            // CRUD Customers
            getCustomers() {
                let url = this.url + '/api/customers?' + this.paginateUrl + this.searchUrl
                axios.get(url)
                    .then(response => {
                        this.customers = response.data
                    })
            },
            updateCustomer() {
                let url = this.url + '/api/customers/' + this.customer.id
                let config = {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    }
                }
                let formData = new FormData()
                formData.append('name', this.customer.name)
                formData.append('email', this.customer.email)
                formData.append('phones', this.phones)
                this.customer.phones.forEach(function(phone) {
                    if (phone != ''){
                        formData.append('phones[]', phone)
                    }
                })
                this.customer.sellers.forEach(function(seller) {
                    formData.append('sellers[]', seller.id)
                })
                if (typeof this.customer.image[0] == 'object') {
                    formData.append('image', this.customer.image[0])
                    formData.append('_method', 'put')
                } else {
                    formData.append('_method', 'patch')
                }
                formData.append('customer_type_id', this.customer.customer_type_id)

                axios.post(url, formData, config)
                    .then(response => {
                        this.alert.status = 'success'
                        this.alert.title = response.data.message
                        this.getCustomers()
                    })
                    .catch(error => {
                        this.alert.status = 'danger'
                        this.alert.title = 'Erro ao atualizar cliente!'
                        this.alert.message = 'Ocorreram os seguintes erros:'
                        this.alert.errors = error.response.data.errors
                    })
            },
            destroyCustomer() {
                let url = this.url + '/api/customers/' + this.customer.id
                let formData = new FormData()
                formData.append('_method', 'delete')
                axios.post(url, formData)
                    .then(response => {
                        this.alert.status = 'success'
                        this.alert.title = response.data.message
                        this.getCustomers()
                    })
                    .catch(error => {
                        this.alert.status = 'danger'
                        this.alert.title = 'Erro ao remover cliente!'
                        this.alert.message = error.response.data.error
                        console.log(error.response.data)
                    })
            },
            createCustomer() {
                let url = this.url + '/api/customers'
                let config = {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    }
                }
                let formData = new FormData()
                formData.append('name', this.customer.name)
                formData.append('email', this.customer.email)
                this.customer.phones.forEach(function(phone) {
                    if (phone != ''){
                        formData.append('phones[]', phone)
                    }
                })
                this.customer.sellers.forEach(function(seller) {
                    formData.append('sellers[]', seller.id)
                })
                formData.append('image', this.customer.image[0])
                formData.append('customer_type_id', this.customer.customer_type_id)

                axios.post(url, formData, config)
                    .then(response => {
                        this.alert.status = 'success'
                        this.alert.title = 'Cliente cadastrado com sucesso!'
                        this.alert.message = response.data.message
                        this.getCustomers()
                        this.resetCustomer()
                    })
                    .catch(error => {
                        this.alert.status = 'danger'
                        this.alert.title = 'Erro ao cadastrar o cliente!'
                        this.alert.message = 'Ocorreram os seguintes erros:'
                        this.alert.errors = error.response.data.errors
                    })
            },
            // Pagination
            paginate(link) {
                if (link.url) {
                    this.paginateUrl = link.url.split('?')[1]
                    this.getCustomers()
                }
            },
            // Search
            search() {
                this.paginateUrl = 'page=1'
                let filter = ''
                for (let key in this.filter) {
                    if (this.filter[key]) {
                        filter+= key + ',like,%' + this.filter[key] + '%;'
                    }
                }
                this.searchUrl = '&filters=' + filter
                this.getCustomers()
            },
            // File
            loadFile(e) {
                this.customer.image = e.target.files
            },
        },
        mounted() {
            this.getCustomers()
        }
    }
</script>