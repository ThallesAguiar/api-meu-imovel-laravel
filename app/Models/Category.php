<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'slug'
    ];

    public function realStates()
    {
        return $this->belongsToMany(RealState::class, 'real_state_categories');
        /**
         * O segundo parametro é para identificar qual tabela do banco que é para salvar a relação.
         * Sem ela, o Model procura a tabela com relação, porem em ordem alfabetica.
         * ex.: Real_state e Category, ele procura por category_real_state, mas minha tabela é real_state_category.
         */
    }
}
