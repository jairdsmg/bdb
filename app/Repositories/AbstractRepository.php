<?php

namespace App\Repositories;
use Illuminate\Database\Eloquent\Model;


abstract class AbstractRepository{

    public function __construct(Model $model){
        $this->model = $model;
    }


    public function selectAtributosRegistrosRelacionados($atributos){
        $this->model = $this->model->with($atributos);
    }


    public function filtro($filtros){
        $filtros = explode(';', $filtros);
            foreach($filtros as $key => $condicao){
                $c = explode(':',$condicao);
               /* console.log('o sc explodido fica assim '+ $c);*/
                $this->model = $this->model->where($c[0], $c[1], $c[2]);
               /* console.log('o this.model antes da verificação da data fica assim '+ $this->model);
                if($c[0]=='data'){
                    console.log('tem o filtro data');
                }*/
            }  
    }


    public function selectAtributos($atributos){
        $this->model = $this->model->selectRaw($atributos);
    }


    public function getResultado(){
      return  $this->model->get();
    }

    
    public function getResultadoPaginado($numeroRegistroPorPagina){
        return  $this->model->paginate($numeroRegistroPorPagina);
      }


}

?>