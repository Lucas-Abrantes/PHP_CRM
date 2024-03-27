<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
      // Especifica o nome da tabela se não for o plural do nome do model
      protected $table = 'clientes';

      // Define quais colunas podem ser preenchidas
      protected $fillable = ['nome', 'email', 'telefone', 'empresa', 'status', 'senha'];
  
      // Se você tiver timestamps (created_at, updated_at) e quiser usá-los, certifique-se de que está ativado (padrão é true)
      public $timestamps = true;
}
