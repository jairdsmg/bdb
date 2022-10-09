<?php

namespace App\Http\Controllers;
use App\Models\Produto;  //adicionei para fazer meus testes
use App\Models\Preco;
use App\Http\Requests\StorePrecoRequest;
use Illuminate\Http\Request;
use App\Repositories\PrecoRepository;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PrecosExport;



class PrecoController extends Controller
{
    public function __construct(Preco $preco){
        $this->preco = $preco;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $precoRepository = new PrecoRepository($this->preco);

        if($request->has('atributos_produto')){
            $atributos_produto = 'produto:preco_id,'.$request->atributos_produto;
            $precoRepository->selectAtributosRegistrosRelacionados($atributos_produto);
        }else{
            $precoRepository->selectAtributosRegistrosRelacionados('produto');
        }

        if($request->has('filtro')){
            $precoRepository->filtro($request->filtro);  
        }

        if($request->has('atributos')){
            $precoRepository->selectAtributos($request->atributos); 
        }

        return response()->json($precoRepository->getResultadoPaginado(10), 200);






         /*
        $precos = $this->preco->with('produto')->get();
        //$precos = $this->preco->all();
       // return response()->json($precos, 200);
        return response()->json($precoRepository->getResultadoPaginado(3), 200);*/
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePrecoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->preco->rules(), $this->preco->feedback());
        $preco = $this->preco->create($request->all());
        return response()->json($preco, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  Integer  $preco
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //$preco = $this->preco->find($id);
        $preco = $this->preco->with('produto')->find($id);
        if ($preco === null){
            return response()->json(['erro' =>'O recurso pesquisado não existe!'], 404);
        }
        return response()->json($preco, 200);
    }

    /* COPIA DO ORIGINAL
    public function show($id)
    {
        $preco = $this->preco->find($id);
        if ($preco === null){
            return response()->json(['erro' =>'O recurso pesquisado não existe!'], 404);
        }
        return response()->json($preco, 200);
    }
    
    */



    /**
     * Update the specified resource in storage.
     *
     * @param  Integer $request
     * @param  \App\Models\Preco  $preco
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $preco = $this->preco->find($id);

        if($preco === null){
            return response()->json(['erro' => 'Impossível realizar a atualização. O recurso pesquisado não existe'], 404) ;
        }

        if ($request->method() === 'PATCH'){
            $regrasDinamicas = array();

            //percorrendo todas as regras definidas no Model
            foreach ($preco->rules() as $input => $regra){
    
                //coletar apenas as regras apicaveis aos parametros parciais da requisição
                if(array_key_exists($input, $request->all())){
                    $regrasDinamicas[$input] = $regra;
                }
            }
           // dd($regrasDinamicas);
            $request->validate($regrasDinamicas, $preco->feedback());
        }else{
            $request->validate($preco->rules(), $preco->feedback());
        }
        

        $preco->update($request->all());
        return response()->json($preco, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer  $preco
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $preco = $this->preco->find($id);
        if($preco ===null){
            return response()->json(['erro' => 'O recurso pesquisado não existe!'], 404);
        }
        $preco->delete();
        return response()->json(['msg' => 'Preço removido com sucesso!'], 200);
    }



    public function exportacao(){
        return Excel::download(new PrecosExport, 'lista_de_precos.xlsx');
    }




}
