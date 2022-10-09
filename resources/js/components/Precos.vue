<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">


                <!-- INICIO DO CARD DE BUSCA DE DATA OU PRODUTO-------------------->
                <card-component titulo="Consultar preços">
                    <template v-slot:links>
                        <div class="float-right">
                            
                            <!--<a href="('/v1/preco/exportacao/', ['extensao' => 'csv'])">CSV</a> -->
                            <a href="/v1/preco/exportacao">XLSX</a> 
                        </div>
                    </template>

                    <template v-slot:conteudo>
                        <div class="form-row">

                            <div class="col mb-3">
                                <input-container-component titulo="Pesquisa pela Loja" id="InputId" id-help="idHelp" texto-ajuda="Opcional">            
                                    <input type="number" class="form-control" id="inputIdLoja" aria-describedby="idHelp" placeholder="ID da Loja" v-model="busca.loja_id">
                                </input-container-component>
                            </div>

                            <div class="col mb-3">
                                <input-container-component titulo="Pesquisa pelo Produto" id="InputNome" id-help="nomeHelp" texto-ajuda="Opcional">            
                                    <input type="texto" class="form-control" id="inputIdProduto" aria-describedby="nomeHelp" placeholder="ID do Produto" v-model="busca.produto_id">
                                </input-container-component>
                            </div>

                            <div class="col mb-3">
                                <input-container-component titulo="Data Única ou Inicial" id="InputData" id-help="nomeHelp" texto-ajuda="Opcional.">            
                                    <input type="date" class="form-control" id="inputDataInicial" aria-describedby="nomeHelp" placeholder="Data Inicial" v-model="busca.data[0]">
                                </input-container-component>
                            </div>

                            
                            <div class="col mb-3">
                                <input-container-component titulo="Data Final" id="InputNome" id-help="nomeHelp" texto-ajuda="Opcional.">            
                                    <input type="date" class="form-control" id="inputDataFinal" aria-describedby="nomeHelp" placeholder="Data Final" v-model="busca.data[1]">
                                </input-container-component>
                            </div>

                        </div>
                    </template>

                    <template v-slot:rodape>
                        <div class="form-group">
                            Total de Registros encaontrados: <strong>{{precos.total}}</strong>
                            <div class="float-right">
                                <button type="submit" class="btn btn-primary btn-sm btn mr-2" @click="limpar()">Limpar Campos</button>
                                <button type="submit" class="btn btn-primary btn-sm float-right" @click="pesquisar()">Pesquisar</button>
                            </div>
                        </div>
                    </template>
                   
                </card-component>
                <!--FIM DO CARD DE BUSCA DE PRECOS--------------------->







                <!--INICIO DO CARD DE LISTAGEM DE PRECOS--********----------->
                <card-component titulo="Relação de Precos">
                    <template v-slot:conteudo>
                        <table-component 
                        :dados="precos.data"
                        :visualizar="{visivel: true, dataToggle: 'modal', dataTarget: '#modalPrecoVisualizar'}"
                        :atualizar="{visivel: true, dataToggle: 'modal', dataTarget: '#modalPrecoAtualizar'}"
                        :remover="{visivel: true, dataToggle: 'modal', dataTarget: '#modalPrecoRemover'}"

                        :titulos="{ 
                            id: {titulo: 'Id', tipo: 'number'},
                            loja_id: {titulo: 'Loja_id', tipo: 'number'},
                            produto_id: {titulo: 'Produto_id', tipo: 'texto'},
                            produto: {titulo: 'Produto', tipo: 'array'},
                            data:{titulo: 'Data', tipo: 'data'},
                            valor:{titulo: 'Valor', tipo: 'double'},
                           // created_at: {titulo: 'Data Criação', tipo: 'data'},
                        }"
                        >
                        </table-component>
                    </template>


                    <template v-slot:rodape>
                        
                        <div class="row">
                            <div class="col-10">
                                <paginate-component>
                                    <li v-for="l, key in precos.links" :key="key" 
                                    :class="l.active ? 'page-item active' : 'page-item'" 
                                    @click="paginacao(l)"
                                    >
                                        <a class="page-link" v-html="l.label"></a>
                                    </li> 
                                </paginate-component>
                            </div>
                            
                            <div class="col">
                                <button type="buttom" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalPrecoEmLote">Adicionar em Lote</button>
                               
                                <button type="buttom" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#modalPreco">Adicionar</button>
                            </div>
                        </div>
                        
                    </template>
                </card-component>
                <!---FIM DO CARD DE LISTAGEM*******************--------->

            </div>
        </div>





        <!--INICIO DO MODAL DE CADASTRAR PREÇO*******************-->
        <modal-component id="modalPreco" titulo="Cadastrar Preco">
            <template v-slot:alertas>
                <alert-component tipo="success" :detalhes="$store.state.transacao"  titulo="Preço inserido com sucesso!" v-if="$store.state.transacao.status == 'sucesso'"></alert-component>
                <alert-component tipo="danger" :detalhes="$store.state.transacao" titulo="Erro ao cadastrar Preço" v-if="$store.state.transacao.status == 'erro'"></alert-component>

            </template>
            
            <template v-slot:conteudo v-if="$store.state.transacao.status != 'sucesso'">
                <div class="form-row">
                    <div class="form-group col mr-2">
                        <input-container-component titulo="Id da Loja" id="novoLoja" id-help="novoLojaHelp" texto-ajuda="">            
                            <input type="number" class="form-control" id="inputId" aria-describedby="novoCodigoHelp" style="color:blue" placeholder="Id da Loja" v-model="idLoja">
                        </input-container-component>
                    </div>
                
                    <div class="form-group col mr-2">
                        <input-container-component titulo="Id do Produto" id="novoProdutoId" id-help="novoProdutoIdHelp" texto-ajuda="">            
                            <input type="number" class="form-control" id="inputIdProduto" aria-describedby="novoProdutoIdHelp" placeholder="Id do Produto" v-model="idProduto">
                        </input-container-component>
                    </div>

                    <div class="form-group">
                        <input-container-component titulo="Data" id="novoDataId" id-help="novoDataIdHelp" texto-ajuda="">            
                            <input type="date" class="form-control" id="inputIdData" aria-describedby="novoDataIdHelp" placeholder="Data para o preço" v-model="idData">
                        </input-container-component>
                    </div>
                </div>

                <div class="form-group">
                    <input-container-component titulo="Valor" id="novoValor" id-help="novoValorHelp" texto-ajuda="">            
                        <input type="number" class="form-control" id="inputValor" aria-describedby="novoValorHelp" placeholder="Valor do Produto" v-model="valorProduto">
                    </input-container-component>
                </div>

            </template>

            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" @click="salvar()" v-if="$store.state.transacao.status != 'sucesso'">Salvar</button>
            </template>
        </modal-component>
        <!--FIM DO MODAL DE CADASTRO DE PREÇO**********************-->






        <!--INICIO DO MODAL DE VISUALIZAÇÃO DE PRECO********************-->
        <modal-component id="modalPrecoVisualizar" titulo="Visualizar Preco">
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
        <!--FIM DO MODAL DE VISUALIZAR PRECO*******************-->




        <!--INICIO DO MODAL DE REMOÇÃO DE PREÇO CADASTRADO********************-->
        <modal-component id="modalPrecoRemover" titulo="Remover Preço Cadastrado">
            <template v-slot:alertas>
                <alert-component tipo="success" :detalhes="$store.state.transacao"  titulo="Transação realizada com sucesso" v-if="$store.state.transacao.status == 'sucesso'"></alert-component>
                <alert-component tipo="danger" :detalhes="$store.state.transacao" titulo="Erro ao excluir Produto" v-if="$store.state.transacao.status == 'erro'"></alert-component>
            </template>
            
            <template v-slot:conteudo v-if="$store.state.transacao.status != 'sucesso'">
                <div class="form-group">
                    <input-container-component titulo="Id do Cadastro">            
                        <input type="number" class="form-control" :value="$store.state.item.id" disabled>
                    </input-container-component>
                </div>
                <div class="form-group col mr-2">
                        <input-container-component titulo="Id da Loja" id="novoIdLoja" id-help="novoLojaHelp" texto-ajuda="">            
                            <input type="number" class="form-control" id="inputId" aria-describedby="novoCodigoHelp" placeholder="Id da Loja" v-model="$store.state.item.loja_id">
                        </input-container-component>
                    </div>
                
                    <div class="form-group col mr-2">
                        <input-container-component titulo="Id do Produto" id="novoProdutoId" id-help="novoProdutoIdHelp" texto-ajuda="">            
                            <input type="number" class="form-control" id="inputIdProduto" aria-describedby="novoProdutoIdHelp" placeholder="Id do Produto" v-model="$store.state.item.produto_id">
                        </input-container-component>
                    </div>
            </template>

            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-danger" @click="remover()" v-if="$store.state.transacao.status != 'sucesso'">Remover</button>
            </template>
        </modal-component>    
       <!-- FIM DO MODAL DE REMOÇÃO DE PRODUTO-->






        <!--INICIO DO MODAL DE ATUALIZAÇÃO DE PRECO********************-->
        <modal-component id="modalPrecoAtualizar" titulo="Editar Preco">
            <template v-slot:alertas>
                <alert-component tipo="success" :detalhes="$store.state.transacao"  titulo="Transação realizada com sucesso" v-if="$store.state.transacao.status == 'sucessoAt'"></alert-component>
                <alert-component tipo="danger" :detalhes="$store.state.transacao" titulo="Erro ao atualizar Preco" v-if="$store.state.transacao.status == 'erroAt'"></alert-component>
              <!--Como a transação inicia com valor vazio, nenhum alerta é mostrado-->
            </template>

            <template v-slot:conteudo v-if="$store.state.transacao.status != 'sucessoAt'">
                <div class="form-row">
                    <div class="form-group col mr-2">
                        <input-container-component titulo="Editar Id da Loja" id="novoIdLoja" id-help="novoLojaHelp" texto-ajuda="">            
                            <input type="number" class="form-control" id="inputId" aria-describedby="novoCodigoHelp" placeholder="Id da Loja" v-model="$store.state.item.loja_id">
                        </input-container-component>
                    </div>
                
                    <div class="form-group col mr-2">
                        <input-container-component titulo="Editar Id do Produto" id="novoProdutoId" id-help="novoProdutoIdHelp" texto-ajuda="">            
                            <input type="number" class="form-control" id="inputIdProduto" aria-describedby="novoProdutoIdHelp" placeholder="Id do Produto" v-model="$store.state.item.produto_id">
                        </input-container-component>
                    </div>

                    <div class="form-group">
                        <input-container-component titulo=" Editar Data do Preço" id="atualizaDataId" id-help="novoDataIdHelp" texto-ajuda="">            
                            <input type="date" class="form-control" id="inputIdData" aria-describedby="novoDataIdHelp" placeholder="Atualizar a data do preço" v-model="$store.state.item.data">
                        </input-container-component>
                    </div>
                </div>

                <div class="form-group">
                    <input-container-component titulo=" Editar Valor do Produto" id="novoValor" id-help="novoValorHelp" texto-ajuda="">            
                        <input type="number" class="form-control" id="inputValor" aria-describedby="novoValorHelp" placeholder="Valor do Produto" v-model="$store.state.item.valor">
                    </input-container-component>
                </div>

            </template>

            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" @click="atualizar()" v-if="$store.state.transacao.status != 'sucessoAt'">Atualizar</button>
            </template>
        </modal-component>
        <!--FIM DO MODAL DE ATUALIZAÇÃO DE PRECO***********************-->



        <!--INICIO DO MODAL DE CADASTRAR PREÇOS EM LOTE*******************-->
        <modal-component id="modalPrecoEmLote" titulo="Cadastrar Precos em Lote">
            <template v-slot:alertas>
                <alert-component tipo="success" :detalhes="$store.state.transacao"  titulo="Preços inseridos com sucesso!" v-if="$store.state.transacao.status == 'sucesso'"></alert-component>
                <alert-component tipo="danger" :detalhes="$store.state.transacao" titulo="Erro ao cadastrar Preços" v-if="$store.state.transacao.status == 'erro'"></alert-component>
            </template>
            
            <template v-slot:conteudo v-if="$store.state.transacao.status != 'sucesso'">
                <div class="form-row">
                    <div class="form-group col mr-2">
                        <input-container-component titulo="Id do Produto" id="novoProdutoId" id-help="novoProdutoIdHelp" texto-ajuda="">            
                            <input type="number" class="form-control" id="inputIdProduto" aria-describedby="novoProdutoIdHelp" placeholder="Id do Produto" v-model="idProduto">
                        </input-container-component>
                    </div>

                    <div class="form-group">
                        <input-container-component titulo="Data da coleta dos preços" id="novoDataId" id-help="novoDataIdHelp" texto-ajuda="">            
                            <input type="date" class="form-control" id="inputIdData" aria-describedby="novoDataIdHelp" placeholder="Data para o preço" v-model="idData">
                        </input-container-component>
                    </div>
                </div>


                <!--INPUTS DOS ID'S DAS LOJAS------------>
                <div class="form-row">
                    <div class="form-group col mr-1">
                        <input-container-component titulo="Assaí" id="assaiId">            
                            <input type="number" class="form-control" id="assaiId" aria-describedby="novoCodigoHelp" style="color:red" placeholder="id"  v-model="loja1">
                        </input-container-component>
                    </div>

                    <div class="form-group col mr-1">
                        <input-container-component titulo="Com. Esp." id="espId5">            
                            <input type="number" class="form-control" id="espId" aria-describedby="novoCodigoHelp" placeholder="id" v-model="loja2">
                        </input-container-component>
                    </div>

                    <div class="form-group col mr-1">
                        <input-container-component titulo="Nagumo" id="nagumoId">            
                            <input type="number" class="form-control" id="nagumoId" aria-describedby="novoCodigoHelp" placeholder="Nagumo" v-model="loja3">
                        </input-container-component>
                    </div>

                    <div class="form-group col mr-1">
                        <input-container-component titulo="Tenda" id="tendaId">            
                            <input type="number" class="form-control" id="tendaId" aria-describedby="novoCodigoHelp" placeholder="id" v-model="loja4">
                        </input-container-component>
                    </div>

                    <div class="form-group col mr-2">
                        <input-container-component titulo="Davó" id="davoId">            
                            <input type="number" class="form-control" id="davoId" aria-describedby="novoCodigoHelp" placeholder="id" v-model="loja5">
                        </input-container-component>
                    </div> 
                </div>


               <!---INPUTS DOS PREÇOS -->
                <div class="form-row">
                    <div class="form-group col mr-1">
                        <input-container-component titulo="" id="4">            
                            <input type="number" class="form-control" id="assaiId" aria-describedby="novoCodigoHelp" placeholder="R$" v-model="valorProdutoL1">
                        </input-container-component>
                    </div>

                    <div class="form-group col mr-1">
                        <input-container-component titulo="" id="5">            
                            <input type="number" class="form-control" id="espId" aria-describedby="novoCodigoHelp" placeholder="R$" v-model="valorProdutoL2">
                        </input-container-component>
                    </div>

                    <div class="form-group col mr-1">
                        <input-container-component titulo="" id="1">            
                            <input type="number" class="form-control" id="nagumoId" aria-describedby="novoCodigoHelp" placeholder="R$" v-model="valorProdutoL3">
                        </input-container-component>
                    </div>

                    <div class="form-group col mr-1">
                        <input-container-component titulo="" id="3">            
                            <input type="number" class="form-control" id="tendaId" aria-describedby="novoCodigoHelp" placeholder="R$" v-model="valorProdutoL4">
                        </input-container-component>
                    </div>

                    <div class="form-group col mr-2">
                        <input-container-component titulo="" id="2">            
                            <input type="number" class="form-control" id="davoId" aria-describedby="novoCodigoHelp" placeholder="R$" v-model="valorProdutoL5">
                        </input-container-component>
                    </div> 
                </div>
            </template>

            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" @click="salvarLote()" v-if="$store.state.transacao.status != 'sucesso'">Cadastrar</button>
            </template>
        </modal-component>
        <!--FIM DO MODAL DE CADASTRO DE PREÇO EM LOTE**********************-->


    </div>
    
</template>

<script>
//import { exportDefaultSpecifier } from '@babel/types';

import axios from 'axios';



    export default {
        

        data(){
            return{
                urlBase: 'http://localhost:8000/api/v1/preco',
                urlPaginacao: '',
                urlFiltro: '',
                loja1: '',
                loja2: '',
                loja3: '',
                loja4: '',
                loja5: '',
                idLoja: '',
                idProduto: '',
                idData: '',
                valorProduto: '',
                valorProdutoL1: '',
                valorProdutoL2: '',
                valorProdutoL3: '',
                valorProdutoL4: '',
                valorProdutoL5: '',
                transacaoStatus:'',
                transacaoDetalhes:{},
                arquivoImagem:[],
                precos: { data: [] }, //da forma que estava antes data:[] dava erro ao iniciar o .map pois na primeira passada o array vazio dava erro, já o objeto não. quase isso,rs
                //busca: {loja_id:'', produto_id:'', data:''} 
                busca: {loja_id:'', produto_id:'', data: []} 
            }
        },


        methods: {
             
            atualizar(){
                let formData = new FormData();
                formData.append('_method','patch') 
                formData.append('loja_id',  this.$store.state.item.loja_id)
                formData.append('produto_id', this.$store.state.item.produto_id)
                formData.append('data', this.$store.state.item.data)
                formData.append('valor', this.$store.state.item.valor.toString().replace(',','.'))

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
                        this.carregarLista()
                    })
                    .catch(errors =>{ 
                        this.$store.state.transacao.status = 'erroAt'  
                        this.$store.state.transacao.mensagem = errors.response.data.message
                        this.$store.state.transacao.dados = errors.response.data.errors
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
                    axios.post(url, formData)
                    .then(response => {
                        this.$store.state.transacao.status = 'sucesso'  
                        this.$store.state.transacao.mensagem = response.data.msg
                        this.carregarLista()
                    })
                    .catch(errors =>{
                        this.$store.state.transacao.status = 'erro'  
                        this.$store.state.transacao.mensagem = errors.response.data.erro
                    })  
            }, 


            
            pesquisar(){
               // console.log(this.busca)
                let filtro =''
                let pref = 'data'

                for (let chave in this.busca){
                    if(this.busca[chave]) { //somente se houver dados digitados //original
                        if(this.busca[chave] != this.busca.data){//se chave diferente de data
                            pref = ';data'
                            if (filtro != ''){
                                 filtro += ";"
                             }
                            filtro += chave + ':like:' + this.busca[chave]
                            //console.log(filtro)
                        }else{

                            if(!(this.busca.data[0]== undefined | this.busca.data[0]=='' ) && (this.busca.data[1]== undefined | this.busca.data[1]=='' )) {
                                filtro += pref +':like:'+ this.busca.data[0]
                            }

                            if((this.busca.data[0]== undefined | this.busca.data[0]=='' ) && !(this.busca.data[1]== undefined | this.busca.data[1]=='' )) {
                                filtro += pref +':<=:'+this.busca.data[1]       
                                //console.log('o filtro ficou assim' + filtro)
                            }

                            if(!(this.busca.data[0]== undefined | this.busca.data[0]=='' ) && !(this.busca.data[1]== undefined | this.busca.data[1]=='' )) {
                                filtro += pref +':>=:'+ this.busca.data[0]+';data:<=:'+this.busca.data[1]       
                                //console.log('o filtro ficou assim' + filtro)
                            }
                        }
                        //SE O LOJA_ID=='' E O PRODUTO_ID==''
                        if((this.busca.produto_id == undefined | this.busca.produto_id =='' ) && (this.busca.loja_id == undefined | this.busca.loja_id =='' )){
                            pref = 'data'
                        //console.log('prdotudo id e loja id estão vazios . Acho que nem precisava desse if aqui. Somente o pref = 'data' la em cima já resolveria)
                        }
                    }
                    
                }
                if(filtro != ''){
                    this.urlPaginacao = 'page=1' //para evitar erros de pesquisa, estando em outras paginas
                    this.urlFiltro = '&filtro=' + filtro
                    //console.log('com filtro diferente de vazio, a url fica assim' + this.urlFiltro)
                }else{
                    this.urlFiltro = ''
                    //console.log('com filtro vazio, a url fica assim' + this.urlFiltro)
                }
                this.carregarLista()       
            },






            paginacao(l) {
                //console.log(l)
                if(l.url){
                // this.urlBase= l.url //ajustando a url de consulta com o parametro de pagina
                this.urlPaginacao = l.url.split('?')[1]
                //console.log('url do botao clicado', l.url.split('?')[1])
                this.carregarLista() //requisitando novamente os dados para nossa API
               }
            },  

            

            carregarLista(){
                let url = this.urlBase + '?' + this.urlPaginacao + this.urlFiltro
                //console.log(url)
                axios.get(url)
                .then(response =>{
                    //this.precos.data= response.data 
                    this.precos= response.data 
                    //this.precos= response - so acrescentamos .data após usar paginação - depois de alterado o index do referido controller
                    //
                    
                    //console.log(this.precos.total)
                })
                .catch(errors => {
                    console.log(errors)
                })
            },




            /*
            carregarImagem(e){
                this.arquivoImagem = e.target.files
            },  */



            salvar(){
            

                let formData = new FormData();
                formData.append('loja_id', this.idLoja)
                formData.append('produto_id', this.idProduto)
                formData.append('data', this.idData)
                formData.append('valor', this.valorProduto.toString().replace(',','.'))

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

                    this.carregarLista() //adicionei por conta para testes e deu certo
                    //console.log(response)
                })
                .catch(errors => {
                    this.$store.state.transacao.status = 'erro'  
                    this.$store.state.transacao.mensagem = errors.response.data.message
                    this.$store.state.transacao.dados = errors.response.data.errors
                })
            },

            limpar(){
                this.$store.state.item.busca.loja_id='', 
                this.produto_id='', 
                this.inputData=''
            },


            salvarLote(){
		        let config = {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }
			    let i=''
                let el = this
		
                for(i = 1; i < 5; i++){   
					let formData = new FormData();
                    let loja = `${'loja' + i}`
                    //console.log(`${'loja' + i}`)
                    //console.log(el+'.'+`${loja}`)
					formData.append('loja_id', this.loja1)
					formData.append('produto_id', this.idProduto)
					formData.append('data', this.idData)
					formData.append('valor', this.valorProdutoL1)
					axios.post(this.urlBase, formData, config)
					.then(response => {
					    console.log('adicionado requisicao'+(i))
                        console.log(`${'this.'+'loja'+i}`)
                    })
                    .catch(errors => {
					    //console.log('erro na requisicao'+(i))
                        console.log(`${this.loja}`)
                       // console.log(`${'this' +'.'+('valorProdutoL'+i)}`)
                    
                    })
			    }
            }


        },

           

        mounted(){  //quando o componente estiver montado, execute a função a seguir
            this.carregarLista()
        }

    }
   
   
</script>
