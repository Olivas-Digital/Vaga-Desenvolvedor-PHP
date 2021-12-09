<template>
    <div>
        <!-- Search Sellers -->
        <card-component title="Pesquisar por Vendedores">
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
                </div><!-- row -->
                <button class="btn btn-primary">Buscar</button>
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
                    <tr v-for="i, key in 5" :key="key">
                        <td scope="row">1</td>
                        <td>João da Silva</td>
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
                Novo Vendedor
            </button>
        </card-component>
        <!-- Modal Create Seller -->
        <modal-component title="Novo Vendedor" id="create">
            <template v-slot:body>
                <form>
                    <div class="form-group">
                        <label>Nome do Vendedor</label>
                        <input type="text" name="name" class="form-control">
                    </div><!-- form-group -->
                </form>
            </template>
            <template v-slot:footer>
                <button type="button" class="btn btn-primary">
                    Cadastrar
                </button>
            </template>
        </modal-component>

        <!-- Modal Edit Seller -->
        <modal-component title="Editar Vendedor" id="edit">
            <template v-slot:body>
                <form>
                    <div class="form-group">
                        <label>Nome do Vendedor</label>
                        <input type="text" name="name" class="form-control">
                    </div><!-- form-group -->
                </form>
            </template>
            <template v-slot:footer>
                <button type="button" class="btn btn-primary">
                    Atualizar
                </button>
            </template>
        </modal-component>

        <!-- Modal Soft Delete Seller -->
        <modal-component title="Desativar Vendedor" id="destroy">
            <template v-slot:body>
                <form>
                    <div class="form-group">
                        <label>Nome do Vendedor</label>
                        <input type="text" name="name" class="form-control" readonly>
                    </div><!-- form-group -->
                </form>
            </template>
            <template v-slot:footer>
                <button type="button" class="btn btn-danger">
                    Desativar
                </button>
            </template>
        </modal-component>

        <!-- Modal Show Seller  -->
        <modal-component title="Vendedor" id="show">
            <template v-slot:body>
                <profile-component></profile-component>
            </template>
        </modal-component>
    </div>
</template>

<script>
    export default {
        
    }
</script>