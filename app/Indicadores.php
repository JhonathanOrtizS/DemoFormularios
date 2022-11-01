<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Indicadores extends Model
{
    //
    protected $table = 'indicadores';

    /*=============================================
     INNER JOIN DESDE EL MODELO
     =============================================
     public function categorias(){

        return $this->belongsTo('App\Categorias', 'id_cat', 'id_categoria');

    }*/
}
