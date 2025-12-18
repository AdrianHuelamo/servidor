<?php
namespace App\Models;

use CodeIgniter\Model;

class ArtistasModel extends Model
{   
    protected $table = 'artistas';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nombre'];

    protected $returnType = 'array'; 

}