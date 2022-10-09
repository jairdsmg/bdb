<?php

namespace App\Exports;

use App\Models\Preco;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;



class PrecosExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Preco::all();
    }

    public function headings():array {
        return ['Loja_id','Produto_id','Data','Valor'];
        //Nesse metodo devemos declarar que o retorno é um :array. Se nao mencionarmos, dará erro.
    }

    public function map($linha):array {
        //dd($linha);
        return [
           
            $linha->loja_id,
            $linha->produto_id,
            date('d/m/Y', strtotime($linha->data)),
            $linha->valor,
            'xyz',
            'abcd'
        ];

    }

}
