<?php

namespace App\Models;

use CodeIgniter\Model;

class NewsModel extends Model
{   
    protected $table = 'news';
    protected $allowedFields = ['title','slug','body','id_category'];
    
    protected $returnType = 'array'; 
    
    /**
     * Obtiene una o todas las noticias, incluyendo la categoría.
     *
     * @param false|string $slug El slug de la noticia individual, o false para todas.
     *
     * @return array|null El array de datos de la noticia o null si no se encuentra (fila única). 
     * O un array de arrays si se obtienen todas las noticias (findAll).
     */
    public function getNews($slug = false)
    {
        // 1. Configurar la consulta con JOIN (Esto aplica a ambos casos: todas o una)
        $this->select('news.*, category.category');
        $this->join('category', 'news.id_category = category.id');

        if ($slug === false) {
            // Caso 1: Devolver TODAS las noticias con su categoría
            // La consulta se ejecuta aquí.
            return $this->findAll(); 
        }
        
        // Caso 2: Devolver una sola noticia con su categoría (filtrando por slug)
        // Encadenamos el WHERE y ejecutamos la consulta con first().
        return $this->where(['slug' => $slug])->first();
    }
}