<template>
    
    <div>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col" v-for="t, key in titulos" :key="key">{{t.titulo}}</th>
                    <th v-if="visualizar.visivel || atualizar.visivel || remover.visivel"></th>
                </tr>
            </thead>

            <tbody>
                
                <tr v-for="obj, chave in dadosFiltrados" :key="chave">
                    <td v-for="valor, chaveValor in obj" :key="chaveValor">
                        <span v-if="titulos[chaveValor].tipo == 'texto'">{{valor}}</span>
                        <span v-if="titulos[chaveValor].tipo == 'number'">{{valor}}</span>
                        <span v-if="titulos[chaveValor].tipo == 'data'">{{ valor | formataDataTempoGlobal}}</span>
                        <span v-if="titulos[chaveValor].tipo == 'double'">{{ valor |formataValorBancoParaTabela}}</span>
                        <span v-if="titulos[chaveValor].tipo == 'array'">{{ valor = valor.nome}}</span>
                        <span v-if="titulos[chaveValor].tipo == 'imagem'">
                            <img :src="'/storage/'+valor" width="30" height="40">
                        </span>
                    </td>
                    
                    <td v-if="visualizar.visivel || atualizar.visivel || remover.visivel">
                        <button v-if="visualizar.visivel" class="btn btn-outline-primary btn-sm" :data-toggle="visualizar.dataToggle" :data-target="visualizar.dataTarget" @click="setStore(obj)">Visualizar</button>
                        <button  v-if="atualizar.visivel" class="btn btn-outline-primary btn-sm" :data-toggle="atualizar.dataToggle" :data-target="atualizar.dataTarget" @click="setStore(obj)">Atualizar</button>
                        <button v-if="remover.visivel" class="btn btn-outline-danger btn-sm" :data-toggle="remover.dataToggle" :data-target="remover.dataTarget" @click="setStore(obj)">Remover</button>
                    </td>
                
                </tr> 

            
                <!-- Forma dinamica, em que percorremos cada linha da tabela, buscando chave e valor e retornamos apenas os valores referentes ao tiulo da coluna. Para isso, o titulo deve estar em caixa baixa. Porém, para visualização, definimos a classe dele como uppercase
                <thead>
                <tr>
                    <th scope="col" v-for="t, key in titulos" :key="key" class="text-uppercase">{{t}}</th>
                </tr>
                </thead>
                <tr v-for="obj in dados" :key="obj.id">
                    <td v-if="titulos.includes(chave)" v-for="valor, chave in obj" :key="chave">
                        <span v-if="chave == 'imagem'">
                            <img :src="'/storage/'+valor" width="30" height="40">
                        </span>
                        <span v-else>
                            {{valor}}   
                        </span>                    
                    </td> 
                Forma inicial em que traziamos todas as informações da tabela produtos
                    <tr v-form="p in dados" :key="p.id">
                        <th scope="row">{{p.id}}</th>
                            <td>{{p.valor}}</td>
                        <td><img :src="'/storage/'+p.imagem" width="30" height="40"></td>
                    </tr>
                
                </tr> -->
            </tbody>       
         </table> 
        
    </div>

</template>



<script>
    export default {

        props:['dados', 'titulos','visualizar', 'atualizar', 'remover'],
        //props:['dados'],
        methods: {
            setStore(obj){
                this.$store.state.transacao.status = '' //para evitar que o modal mostre msg antiga
                this.$store.state.transacao.mensagem = ''
                this.$store.state.transacao.dados = ''
                this.$store.state.item = obj
            }

        },

        computed: {
            dadosFiltrados(){
                //console.log(this.dados)
                let campos = Object.keys(this.titulos)
                let dadosFiltrados = []
                //console.log(campos)
                //console.log(this.dados)

                this.dados.map((item, chave)=> {
                    //console.log(chave,item)
                
                     let itemFiltrado = {}
                     campos.forEach(campo =>{
                         //console.log(campo)
                         itemFiltrado[campo] = item[campo]//utilizando a sintaxe de array para atribuir valores a objetos
                         //console.log(chave, item, campo)
                         //console.log(itemFiltrado)
                   })

                   dadosFiltrados.push(itemFiltrado)
                   //console.log(itemFiltrado)
              })

              //console.log(dadosFiltrados)
              return dadosFiltrados
            }
        }

    }
</script>