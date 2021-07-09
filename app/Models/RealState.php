<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RealState extends Model
{
    use HasFactory;

    protected $table = 'real_state'; //troca o nome da tabela para o controller. Não afeta o BD.

    protected $fillable = [ //precisa deste fillable para dizer quais colunas você quer ter acesso.
        'user_id', 'title', 'description', 'content',
        'price', 'slug', 'bedrooms', 'bathrooms',
        'property_area', 'total_property_area'
    ];

    public function user()
    {
        // significa que pertence a 1:1 ou N:1
        return $this->belongsTo(User::class);

        /*$this->belongsTo(User::class, 'user_code');
            no primeiro parametro significa que ele vai procurar o user_id
            e caso for passado um segundo parametro, ele vai procurar pelo nome passado.
        */
    }

    /**
     * Faz a relação de N:N com Category
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'real_state_categories');
        /**
         * O segundo parametro é para identificar qual tabela do banco que é para salvar a relação.
         * Sem ela, o Model procura a tabela com relação, porem em ordem alfabetica.
         * ex.: Real_state e Category, ele procura por category_real_state, mas minha tabela é real_state_category.
         */
    }
}
