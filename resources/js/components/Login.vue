<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card">
                    <div class="card-header">Login - Aplicação Teste</div>
                     
                    <div class="card-body">
                        <form method="POST" action="" @submit.prevent="login($event)">
                            <input type="hidden" name="_token" :value="csrf_token">
                            

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">E-mail</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email" value="" required autocomplete="email" autofocus  v-model="email">

                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Senha</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password" required autocomplete="current-password" v-model="password">

                                   
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember">

                                        <label class="form-check-label" for="remember">
                                            Mantenha-me conectado!
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Login
                                    </button>

                                   
                                        <a class="btn btn-link" href='http://localhost:8000/password/reset'>
                                            Esqueci a senha.
                                        </a>
                                    
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    export default{
        props:['csrf_token'],
        //o Data abaixo é um pouco diferente dos demais. Aula 346 - 9min35s
        data(){
            return{
                email: '',
                password: ''
            }
        },
        methods:{
            login(e) {
                //console.log('chegamos até aqui. Mudamos o comportamento padrao')
                //console.log(this.email, this.password)
                //let url = 'https://f1f1-177-50-134-86.ngrok.io/login'
 
                let url = 'http://localhost:8000/api/login'
                let configuracao = {
                    method: 'post',
                    //essa new URLSearchParams só serve para urlencoding, para o FormaData seria outra
                    body: new URLSearchParams({
                        'email': this.email,
                        'password': this.password
                    })
                }

                fetch(url, configuracao)
                //.then(response => console.log(response))
                .then(response => response.json())
                //.then(data => console.log(data)) //aqui estamos recuperando o token: yk6hgf...
                .then(data => { 
                   // console.log(data.token)
                    if (data.token){
                        document.cookie = 'token='+data.token+';SameSite=Lax'
                    }
                    e.target.submit()
                })
               //Funciona de forma assíncrona. Assim que tiver resolvido, então vai para o proximo
               
               //e.target.submit() AQUI DAVA ERRO NO FIREFOX - AULA 346 26min30s - removido para dentro do then acima
                
            }
          }
        }
        
    </script>
