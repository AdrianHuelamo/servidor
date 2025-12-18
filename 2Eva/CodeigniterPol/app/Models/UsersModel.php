<?php
namespace App\Models;
use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table ='users';
    protected $allowdFields = ['username','password','rol'];

    public function checkUser($user,$pass)
    {
        return $this->where(['username'=> $user,'password'=>$pass])->find();
    }
}