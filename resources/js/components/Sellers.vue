<template>
    <div>
        <!-- Search Sellers -->
        <card-component title="Pesquisar por Vendedores">
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
                </div><!-- row -->
                <button type="button" class="btn btn-primary" @click="search()">Buscar</button>
            </form>
        </card-component>

        <!-- Sellers Table -->
        <card-component title="Relação de Vendedores">
            <table-component>
                <template v-slot:thead>
                    <th>ID</th>
                    <th>Nome</th>
                    <th></th>
                </template>
                <template v-slot:tbody>
                    <tr v-for="seller, key in sellers.data" :key="key">
                        <td scope="row">{{ seller.id }}</td>
                        <td>{{  seller.name }}</td>
                        <td class="text-right">
                            <button class="btn btn-info btn-sm m-1" type="button" data-toggle="modal" data-target="#edit" @click="setSeller(seller)">
                                <i class="fas fa-pencil-alt"></i>
                            </button>
                            <button class="btn btn-primary btn-sm m-1" type="button" data-toggle="modal" data-target="#show" @click="setSeller(seller)">
                                <i class="far fa-eye"></i>
                            </button>
                            <button class="btn btn-danger btn-sm m-1" type="button" data-toggle="modal" data-target="#destroy" @click="setSeller(seller)">
                                <i class="far fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                </template>
            </table-component>

            <nav aria-label="Page navigation example" style="cursor: pointer;">
                <ul class="pagination">
                    <li :class="link.active ? 'page-item active' : 'page-item'" v-for="link, key in sellers.links" :key="key">
                        <a class="page-link" @click="paginate(link)" v-html="link.label"></a>
                    </li>
                </ul><!-- pagination -->
            </nav>

            <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#create" @click="removeAlert()">
                Novo Vendedor
            </button>
        </card-component>
        <!-- Modal Create Seller -->
        <modal-component title="Novo Vendedor" id="create">
            <template v-slot:body>
                <form>
                    <alert-component :title="alert.title" :status="alert.status" :message="alert.message" v-if="alert.status != ''"></alert-component>
                    <div class="form-group">
                        <label>Nome do Vendedor</label>
                        <input type="text" v-model="newSeller.name" class="form-control">
                    </div><!-- form-group -->
                </form>
            </template>
            <template v-slot:footer>
                <button type="button" class="btn btn-primary" @click="createSeller()">
                    Cadastrar
                </button>
            </template>
        </modal-component>

        <!-- Modal Edit Seller -->
        <modal-component title="Editar Vendedor" id="edit">
            <template v-slot:body>
                <alert-component :title="alert.title" :status="alert.status" :message="alert.message" v-if="alert.status != ''"></alert-component>
                <form>
                    <div class="form-group">
                        <label>Nome do Vendedor</label>
                        <input type="text" v-model="seller.name" class="form-control">
                    </div><!-- form-group -->
                </form>
            </template>
            <template v-slot:footer>
                <button type="button" class="btn btn-primary" @click="updateSeller()">
                    Atualizar
                </button>
            </template>
        </modal-component>

        <!-- Modal Destroy Seller -->
        <modal-component title="Remover Vendedor" id="destroy">
            <template v-slot:body>
                <alert-component :title="alert.title" :status="alert.status" :message="alert.message" v-if="alert.status != ''"></alert-component>
                <form v-if="alert.status == ''">
                    <div class="form-group">
                        <label>Nome do Vendedor</label>
                        <input type="text" v-model="seller.name" class="form-control" readonly>
                    </div><!-- form-group -->
                </form>
            </template>
            <template v-slot:footer>
                <button type="button" class="btn btn-danger" @click="destroySeller()">
                    Remover
                </button>
            </template>
        </modal-component>

        <!-- Modal Show Seller  -->
        <modal-component title="Vendedor" id="show">
            <template v-slot:body>
                <profile-component :data="[{title: 'Total de Clientes', value: 100}]" :name="seller.name" type="Vendedor"></profile-component>
            </template>
        </modal-component>
    </div>
</template>

<script>
    export default {
        props: ['url'],
        data() {
            return {
                sellers: {},
                seller: {},
                newSeller: {},
                alert: {
                    status: '',
                    title: '',
                    message: '',
                    errors: [],
                },
                paginateUrl: 'page=1',
                searchUrl: '',
                filter: {
                    id: null,
                    name: '',
                },
            } 
        },
        methods: {
            // CRUD
            getSellers() {
                let url = this.url + '/api/sellers?' + this.paginateUrl + this.searchUrl
                axios.get(url)
                    .then(response => {
                        this.sellers = response.data
                    })
            },
            updateSeller() {
                let url = this.url + '/api/sellers/' + this.seller.id
                let formData = new FormData()
                formData.append('_method', 'put')
                formData.append('name', this.seller.name)
                axios.post(url, formData)
                    .then(response => {
                        this.alert.status = 'success'
                        this.alert.title = ''
                        this.alert.message = response.data.message
                        this.getSellers()
                    })
                    .catch(error => {
                        this.alert.status = 'danger'
                        this.alert.title = 'Erro ao atualizar vendedor!'
                        this.alert.message = error.response.data.errors.name[0]
                    })
            },
            createSeller() {
                // check if newSeller.name != undefined
                if (this.newSeller.name) {
                    let url = this.url + '/api/sellers'
                    let formData = new FormData()
                    formData.append('name', this.newSeller.name)
                    axios.post(url, formData)
                        .then(response => {
                            this.alert.status = 'success'
                            this.alert.title = 'O Vendedor ' + this.newSeller.name + ' foi cadastrado com sucesso!'
                            this.alert.message = response.data.message
                            this.newSeller.name = ''
                            this.getSellers()
                        })
                        .catch(() => {
                            this.alert.status = 'danger'
                            this.alert.title = 'Erro ao cadastrar vendedor!'
                            this.alert.message = error.response.data.errors.message
                        })
                }
            },
            destroySeller() {
                let url = this.url + '/api/sellers/' + this.seller.id
                let formData = new FormData()
                formData.append('_method', 'delete')

                axios.post(url, formData)
                    .then(response => {
                        this.alert.status = 'success'
                        this.alert.title = response.data.message
                        this.alert.message = ''
                        this.getSellers()
                    })
                    .catch(error => {
                        this.alert.status = 'danger'
                        this.alert.title = 'Erro ao remover vendedor!'
                        this.alert.message = error.response.data.error
                    })
            },
            // Store
            setSeller(seller) {
                this.removeAlert()
                this.seller = JSON.parse(JSON.stringify(seller))
            },
            // Alert
            removeAlert() {
                this.alert.status = ''
            },
            // Pagination
            paginate(link) {
                if (link.url) {
                    this.paginateUrl = link.url.split('?')[1]
                    this.getSellers()
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
                this.getSellers()
            }
        },
        mounted() {
            this.getSellers()
        }
    }
</script>