<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">


                <!-- INICIO DO CARD DE BUSCA DE PRODUTOS-------------------->
                <card-component titulo="Busca de Produtos">
                    <template v-slot:conteudo>
                        <div class="form-row">

                            <div class="col mb-3">
                                <input-container-component titulo="ID do Produto" id="InputId" id-help="idHelp" texto-ajuda="Opcional. ID do produto">            
                                    <input type="number" class="form-control" id="inputId" aria-describedby="idHelp" placeholder="ID" v-model="busca.id">
                                </input-container-component>
                            </div>

                            <div class="col mb-3">
                                <input-container-component titulo="Codigo de Barras" id="InputId" id-help="idHelp" texto-ajuda="Opcional. Informe o ID do registro">            
                                    <input type="number" class="form-control" id="inputId" aria-describedby="idHelp" placeholder="Codigo de Barras" v-model="busca.codbarras">
                                </input-container-component>
                            </div>

                            <div class="col mb-3">
                                <input-container-component titulo="Nome do Produto" id="InputNome" id-help="nomeHelp" texto-ajuda="Opcional. Informe o Nome do Produto">            
                                    <input type="text" class="form-control" id="inputNome" aria-describedby="nomeHelp" placeholder="Nome do Produto" v-model="busca.nome">
                                </input-container-component>
                            </div>

                        </div>
                    </template>

                    <template v-slot:rodape>
                        <div class="form-group">
                            Total de Registros encaontrados: <strong>{{produtos.total}}</strong>
                            <div class="float-right">
                                <button type="submit" class="btn btn-primary btn-sm btn mr-2" @click="limpar()">Limpar Campos</button>
                            <button type="submit" class="btn btn-primary btn-sm float-right" @click="pesquisar()">Pesquisar</button>
                            </div>
                        </div>
                    </template>

                </card-component>
                <!--FIM DO CARD DE BUSCA DE PRODUTOS--------------------->




                <!--INICIO DO CARD DE LISTAGEM DE PRODUTOS--********------------->
                <card-component titulo="Relação de Produtos">
                    <template v-slot:conteudo>
                        <table-component 
                        :dados="produtos.data"
                        :visualizar="{visivel: true, dataToggle: 'modal', dataTarget: '#modalProdutoVisualizar'}"
                        :atualizar="{visivel: true, dataToggle: 'modal', dataTarget: '#modalProdutoAtualizar'}"
                        :remover="{visivel: true, dataToggle: 'modal', dataTarget: '#modalProdutoRemover'}"
                        :titulos="{ 
                            id: {titulo: 'Id', tipo: 'texto'},
                            codbarras: {titulo: 'Cod.Barras', tipo: 'texto'},
                            imagem: {titulo: 'Imagem', tipo: 'imagem'},
                            nome:{titulo: 'Nome', tipo: 'texto'},
                            descricao:{titulo: 'Descrição.', tipo: 'texto'},
                            unidade:{titulo: 'Unid', tipo: 'texto'},
                            quantidade:{titulo: 'Qtd', tipo: 'number'},
                            marca_id:{titulo: 'M_Id', tipo: 'number'},
                            categoria_id:{titulo: 'Cat_Id', tipo: 'number'},
                            created_at: {titulo: 'Data Criação', tipo: 'data'},
                        }"
                        >
                        </table-component>
                    </template>


                    <template v-slot:rodape>
                        
                        <div class="row">
                            <div class="col-10">
                                <paginate-component>
                                    <li v-for="l, key in produtos.links" :key="key" 
                                    :class="l.active ? 'page-item active' : 'page-item'" 
                                    @click="paginacao(l)"
                                    >
                                        <a class="page-link" v-html="l.label"></a>
                                    </li> 
                                </paginate-component>
                            </div>
                            
                            <div class="col">
                               
                                <button type="buttom" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#modalProduto">Adicionar</button>
                            </div>
                        </div>
                        
                    </template>
                </card-component>
                <!--FIM DO CARD DE LISTAGEM*******************--------->

            </div>
        </div>





        <!--INICIO DO MODAL DE CRIAÇÃO DE NOVO PRODUTO********************-->
        <modal-component id="modalProduto" titulo="Adicionar Produtos">
            <template v-slot:alertas>
                <alert-component tipo="success" :detalhes="$store.state.transacao"  titulo="Cadastro realizado com sucesso!" v-if="$store.state.transacao.status == 'sucesso'"></alert-component>
                <alert-component tipo="danger" :detalhes="$store.state.transacao" titulo="Erro ao cadastrar Produto" v-if="$store.state.transacao.status == 'erro'"></alert-component>

            </template>
            
            <template v-slot:conteudo v-if="$store.state.transacao.status != 'sucesso'">
                <div class="form-group">
                    <input-container-component titulo="Codigo de Barras do Produto" id="novoCodigo" id-help="novoCodigoHelp" texto-ajuda="Informe o Codigo de Barras do Produto">            
                        <input type="number" class="form-control" id="inputCodigo" aria-describedby="novoCodigoHelp" placeholder="Codigo de Barras do Produto" v-model="codigoProduto">
                    </input-container-component>
                </div>

                <div class="form-row">
                    <div class="form-group col mr-2">
                        <input-container-component titulo="ID da Marca" id="novoMarcaId" id-help="novoMarcaIdHelp" texto-ajuda="Informe o ID da Marca">            
                            <input type="number" class="form-control" id="inputIdMarca" aria-describedby="novoMarcaIdHelp" placeholder="Id da Marca" v-model="idMarca">
                        </input-container-component>
                    </div>

                    <div class="form-group">
                        <input-container-component titulo="ID da Categoria" id="novoCategoriaId" id-help="novoCategoriaIdHelp" texto-ajuda="Informe o ID da Categoria">            
                            <input type="number" class="form-control" id="inputIdCategoria" aria-describedby="novoCategoriaIdHelp" placeholder="ID da Categoria" v-model="idCategoria">
                        </input-container-component>
                    </div>
                </div>

                <div class="form-group">
                    <input-container-component titulo="Nome do Produto" id="novoNome" id-help="novoNomeHelp" texto-ajuda="Informe o Nome do Produto">            
                        <input type="text" class="form-control" id="inputNome" aria-describedby="novoNomeHelp" placeholder="Nome do Produto" v-model="nomeProduto">
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component titulo="Descriçao do Produto" id="novoDescricao" id-help="novoDescricaoHelp" texto-ajuda="Informe a Descricao do Produto">            
                        <input type="text" class="form-control" id="inputDescricao" aria-describedby="novoDescricaoHelp" placeholder="Descricao do Produto" v-model="descricaoProduto">
                    </input-container-component>
                </div>

                <div class="form-row">
                    <div class="form-group col mr-2">
                        <input-container-component titulo="Unidade de Medida" id="novoUnidade" id-help="novoUnidadeHelp" texto-ajuda="Informe a Unidade da Medida">            
                            <input type="text" class="form-control" id="inputSigla" aria-describedby="novoDescricaoHelp" placeholder="Unidade de Medida" v-model="unidadeMedida">
                        </input-container-component>
                    </div>

                    <div class="form-group">
                        <input-container-component titulo="Quantidade" id="novoQtd" id-help="novoQtdHelp" texto-ajuda="Informe a Quantidade da Medida">            
                            <input type="text" class="form-control" id="inputQtd" aria-describedby="novoQtdHelp" placeholder="Quantidade da Medida" v-model="quantidadeMedida">
                        </input-container-component>
                    </div>
                </div>
            
                <div class="form-group">
                    <input-container-component titulo="Imagem" id="novoImagem" id-help="novoImagemHelp" texto-ajuda="Selecione uma imagem no formato PNG">            
                        <input type="file" class="form-control-file" id="inputNome" aria-describedby="novoImagemHelp" placeholder="Selecione uma imagem" @change="carregarImagem($event)">
                    </input-container-component>
                </div>
            </template>

            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" @click="salvar()" v-if="$store.state.transacao.status != 'sucesso'">Salvar</button>
            </template>
        </modal-component>
        <!--FIM DO MODAL DE CRIAÇÃO DE NOVO PRODUTO***********************-->




        <!--INICIO DO MODAL DE VISUALIZAÇÃO DE PRODUTO********************-->
        <modal-component id="modalProdutoVisualizar" titulo="Visualizar Produto">
            <template v-slot:alertas>
                <alert-component tipo="success" :detalhes="transacaoDetalhes"  titulo="Cadastro realizado com sucesso" v-if="transacaoStatus == 'adicionado1'"></alert-component>
                <alert-component tipo="danger" :detalhes="transacaoDetalhes" titulo="Erro ao cadastrar Produto" v-if="transacaoStatus == 'erro'"></alert-component>
            </template>
            
            <template v-slot:conteudo>
                <div class="form-group">
                    <input-container-component titulo="Id">            
                        <input type="number" col-1 class="form-control" :value="$store.state.item.id" disabled>
                    </input-container-component>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <input-container-component titulo="   ">  
                            <img :src="'storage/'+$store.state.item.imagem" width="100" height="140" v-if="$store.state.item.imagem">
                        </input-container-component>    
                    </div>

                    <div class="form-group">
                        <input-container-component titulo="">            
                            
                            <textarea class="form-control" rows="3" :value="$store.state.item.nome +' '+ $store.state.item.descricao +' '+ $store.state.item.quantidade +' '+ $store.state.item.unidade"></textarea>
                        </input-container-component>
                    </div>
                </div>


                <div class="form-group">
                    <input-container-component titulo="Codigo de Barras">            
                        <input input-sm type="text" class="form-control" :value="$store.state.item.codbarras" disabled>
                    </input-container-component>
                </div>
                
            </template>

            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </template>
        </modal-component>    
        <!--FIM DO MODAL DE VISUALIZAR DE PRODUTO*******************-->




        <!--INICIO DO MODAL DE REMOÇÃO DE PRODUTO********************-->
        <modal-component id="modalProdutoRemover" titulo="Remover Produto">
            <template v-slot:alertas>
                <alert-component tipo="success" :detalhes="$store.state.transacao"  titulo="Transação realizada com sucesso" v-if="$store.state.transacao.status == 'sucesso'"></alert-component>
                <alert-component tipo="danger" :detalhes="$store.state.transacao" titulo="Erro ao excluir Produto" v-if="$store.state.transacao.status == 'erro'"></alert-component>
                <!--Como a transação inicia com valor vazio, nenhum alerta é mostrado-->
            </template>
            
            <template v-slot:conteudo v-if="$store.state.transacao.status != 'sucesso'">
                <div class="form-group">
                    <input-container-component titulo="Id">            
                        <input type="number" class="form-control" :value="$store.state.item.id" disabled>
                    </input-container-component>
                </div>
                <div class="form-group">
                    <input-container-component titulo="Nome do Produto">            
                        <input type="text" class="form-control" :value="$store.state.item.nome" disabled>
                    </input-container-component>
                </div>
            </template>

            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-danger" @click="remover()" v-if="$store.state.transacao.status != 'sucesso'">Remover</button>
            </template>
        </modal-component>    
        <!--FIM DO MODAL DE REMOÇÃO DE PRODUTO-->






        <!--INICIO DO MODAL DE ATUALIZAÇÃO DE PRODUTO********************-->
        <modal-component id="modalProdutoAtualizar" titulo="Atualizar Produto">
            <template v-slot:alertas>
                <alert-component tipo="success" :detalhes="$store.state.transacao"  titulo="Transação realizada com sucesso" v-if="$store.state.transacao.status == 'sucessoAt'"></alert-component>
                <alert-component tipo="danger" :detalhes="$store.state.transacao" titulo="Erro ao atualizar Produto" v-if="$store.state.transacao.status == 'erroAt'"></alert-component>
                <!--Como a transação inicia com valor vazio, nenhum alerta é mostrado-->
            </template>
            
            <template v-slot:conteudo v-if="$store.state.transacao.status != 'sucessoAt'">
                  
                <div class="form-group">
                    <input-container-component titulo="Codigo de Barras do Produto" id="atualizarCodigo" id-help="atualizarCodigoHelp" texto-ajuda="Informe o Codigo de Barras do Produto" >            
                        <input type="number" class="form-control" id="inputCodigo" aria-describedby="novoCodigoHelp" placeholder="Codigo de Barras do Produto" v-model="$store.state.item.codbarras">
                    </input-container-component>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <input-container-component titulo="ID da Marca" id="atualizarMarcaId" id-help="atualizarMarcaIdHelp" texto-ajuda="Informe o ID da Marca">            
                            <input type="number" class="form-control" id="inputIdMarca" aria-describedby="novoMarcaIdHelp" placeholder="ID da Marca" v-model="$store.state.item.marca_id">
                        </input-container-component>
                    </div>

                    <div class="form-group">
                        <input-container-component titulo="ID da Categoria" id="atualizarCategoriaId" id-help="atualizarCategoriaIdHelp" texto-ajuda="Informe o ID da Categoria">            
                            <input type="number" class="form-control" id="inputIdCategoria" aria-describedby="novoCategoriaIdHelp" placeholder="ID da Categoria" v-model="$store.state.item.categoria_id">
                        </input-container-component>
                    </div>
                </div> 

                <div class="form-group">
                    <input-container-component titulo="Nome do Produto" id="atualizarNome" id-help="atualizarNomeHelp" texto-ajuda="Informe o Nome do Produto">            
                        <input type="text" class="form-control" id="inputNome" aria-describedby="novoNomeHelp" placeholder="Nome do Produto" v-model="$store.state.item.nome">
                    </input-container-component>
                </div>
                
                <div class="form-group">
                    <input-container-component titulo="Descriçao do Produto" id="atualizarDescricao" id-help="atualizarDescricaoHelp" texto-ajuda="Informe a Descricao do Produto">            
                        <input type="text" class="form-control" id="inputDescricao" aria-describedby="novoDescricaoHelp" placeholder="Descricao do Produto" v-model="$store.state.item.descricao">
                    </input-container-component>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <input-container-component titulo="Unidade de Medida" id="atualizarUnidade" id-help="atualizarUnidadeHelp" texto-ajuda="Informe a Unidade da Medida">            
                            <input type="text" class="form-control" id="inputSigla" aria-describedby="novoDescricaoHelp" placeholder="Unidade de Medida" v-model="$store.state.item.unidade">
                        </input-container-component>
                    </div>

                    <div class="form-group">
                        <input-container-component titulo="Quantidade" id="atualizarQtd" id-help="atualizarQtdHelp" texto-ajuda="Informe a Quantidade da Medida">            
                            <input type="text" class="form-control" id="inputQtd" aria-describedby="novoQtdHelp" placeholder="Quantidade da Medida" v-model="$store.state.item.quantidade">
                        </input-container-component>
                    </div>
                </div> 
            
                <div class="form-group">
                    <input-container-component titulo="Imagem" id="atualizarImagem" id-help="atualizarImagemHelp" texto-ajuda="Selecione uma imagem no formato PNG">            
                        <input type="file" class="form-control-file" id="inputNome" aria-describedby="novoImagemHelp" placeholder="Selecione uma imagem" @change="carregarImagem($event)">
                    </input-container-component>
                </div>
            </template>

            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" @click="atualizar()" v-if="$store.state.transacao.status != 'sucessoAt'">Atualizar</button>
            </template>
        </modal-component>
        <!--FIM DO MODAL DE ATUALIZAÇÃO DE PRODUTO***********************-->


    </div>
    
</template>

<script>
//import axios from 'axios'  O VSCode importou sozinho isso.
//import Paginate from './Paginate.vue'
//components: {Paginate}

    export default{

        data(){
            return{
                urlBase: 'http://localhost:8000/api/v1/produto',
                urlPaginacao: '',
                urlFiltro: '',
                codigoProduto:'',
                idMarca:'',
                idCategoria:'',
                nomeProduto:'',
                descricaoProduto:'',
                unidadeMedida:'',
                quantidadeMedida:'',
                arquivoImagem:[],
                transacaoStatus:'',
                transacaoDetalhes:{},
                produtos: { data: [] }, //da forma que estava antes data:[] dava erro ao iniciar o .map pois na primeira passada o array vazio dava erro, já o objeto não. quase isso,rs
                busca: {id:'', codbarras:'', nome:''}
            }
        },


        methods: {

            atualizar(){
                //console.log('nome atualizado', this.$store.state.item.nome)
                //console.log('imagem atualizada', this.ArquivoImagem)
                let formData = new FormData();
                formData.append('_method','patch') //por mais que a requisição seja post, internamente deverá ser tratada como patch
                formData.append('codbarras',  this.$store.state.item.codbarras)
                formData.append('marca_id', this.$store.state.item.marca_id)
                formData.append('categoria_id', this.$store.state.item.categoria_id)
                formData.append('nome', this.$store.state.item.nome)
                formData.append('descricao', this.$store.state.item.descricao)
                formData.append('unidade', this.$store.state.item.unidade)
                formData.append('quantidade', this.$store.state.item.quantidade) 
                 
                if(this.arquivoImagem[0]){
                    formData.append('imagem', this.arquivoImagem[0]) //adicionar imagem somente se houver selecionado alguma.
                }
                

                let url = this.urlBase + '/'+ this.$store.state.item.id

                let config = {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }

                axios.post(url, formData, config)
                    .then(response => {
                        
                        this.$store.state.transacao.status = 'sucessoAt'  //estava comentado 
                        this.$store.state.transacao.mensagem = 'Produto atualizado com sucesso!'
                        //console.log('Atualizado', response) 
                        //Limpar o campo de seleção de arquivos
                        //atualizarImagem.value = ''  //quando descomento dá erro
                        this.carregarLista()
                    })
                    .catch(errors =>{ 
                        this.$store.state.transacao.status = 'erroAt'  
                        this.$store.state.transacao.mensagem = errors.response.data.message
                        this.$store.state.transacao.dados = errors.response.data.errors

                        //console.log('Erro de atualização', errors.response)
                        //atualizarImagem.value = '' //adicionei por minha conta para testes
                    })  
            
            },



            remover(){

                let confirmacao = confirm('Tem certeza de que deseja remover esse registro?')
                if(!confirmacao) {
                    return false;
                }

                let formData = new FormData();
                formData.append('_method','delete')

                let url = this.urlBase + '/'+ this.$store.state.item.id
                //let url = this.urlBase + '/1450'  //usado apenas para simular um erro
                // console.log(url) 
                //console.log(this.$store.state.transacao)  
                    axios.post(url, formData)
                    .then(response => {
                       // console.log('Registro removido com sucesso', response)
                        this.$store.state.transacao.status = 'sucesso'  
                        this.$store.state.transacao.mensagem = response.data.msg
                        this.carregarLista()
                    })
                    .catch(errors =>{
                        //console.log('Houve um erro na tentativa de remoção do registro.', errors.response.data)
                        this.$store.state.transacao.status = 'erro'  
                        this.$store.state.transacao.mensagem = errors.response.data.erro
                    })  
            },



            pesquisar(){
                //console.log(this.busca)
                let filtro =''
                for (let chave in this.busca){

                    if(this.busca[chave]) { //somente se houver dados digitados
                    //console.log(chave, this.busca[chave])
                         if (filtro != ''){
                            filtro += ";"
                         }
                        filtro += chave + ':like:' + this.busca[chave]
                    }
                }
                if(filtro != ''){
                    this.urlPaginacao = 'page=1' //para evitar erros de pesquisa, estando em outras paginas
                    this.urlFiltro = '&filtro=' + filtro
                }else{
                    this.urlFiltro = ''
                }
                this.carregarLista()       
            },



            paginacao(l) {
                if(l.url){
                //this.urlBase= l.url //ajustando a url de consulta com o parametro de pagina
                this.urlPaginacao = l.url.split('?')[1]
                //console.log('url do botao clicado', l.url.split('?')[1])
                this.carregarLista() //requisitando novamente os dados para nossa API
                //console.log(l)
               }
            },

            
            carregarLista(){
                let url = this.urlBase + '?' + this.urlPaginacao + this.urlFiltro
                //console.log(url)
                axios.get(url)
                .then(response =>{
                    this.produtos = response.data
                   // console.log(this.produtos.data) traz certinho
                })
                .catch(errors => {
                    console.log(errors)
                })
            },



            carregarImagem(e){
                this.arquivoImagem = e.target.files
            },



            salvar(){

                let formData = new FormData();
                formData.append('codbarras', this.codigoProduto)
                formData.append('marca_id', this.idMarca)
                formData.append('categoria_id', this.idCategoria)
                formData.append('nome', this.nomeProduto)
                formData.append('descricao', this.descricaoProduto)
                formData.append('unidade', this.unidadeMedida)
                formData.append('quantidade', this.quantidadeMedida)
                formData.append('imagem', this.arquivoImagem[0])

                let config = {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }
                //axios espera 03 parametros(1º url, 2º conteudo da requisição e 3º configuraçoes da requisiçao)
                axios.post(this.urlBase, formData, config)
                .then(response => {
                    this.$store.state.transacao.status = 'sucesso'  //estava comentado 
                    this.$store.state.transacao.mensagem ='ID do Registro '+ response.data.id

                    //this.transacaoStatus = 'adicionado'
                    //this.transacaoDetalhes = {
                     //   mensagem: 'ID do Registro '+ response.data.id
                     // }
                      this.carregarLista() //adicionei por conta para testes e deu certo
                    //console.log(response)
                })
                .catch(errors => {
                    this.$store.state.transacao.status = 'erro'  
                    this.$store.state.transacao.mensagem = errors.response.data.message
                    this.$store.state.transacao.dados = errors.response.data.errors



                    //this.transacaoStatus = 'erro'
                    //this.transacaoDetalhes = {
                    //   mensagem: errors.response.data.message,
                     //  dados: errors.response.data.errors
                     // }
                    //errors.esponse.data.message //se estivéssemos usando outro cliete http que não o axios acima, o "response" e o "errors" poderiam ser outros nomes conforme a biblioteca usada.
                })
            }
        },



        mounted(){  //quando o componente estiver montado, execute a função a seguir
            this.carregarLista()
        }

    }
   
</script>
