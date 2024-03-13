<?php

namespace App\Models;

use CodeIgniter\Model;
//Ini akan membuat kelas database tersedia melalui $this->dbobjek.
class NewsModel extends Model
{
    protected $table = 'news';
     
    public function getNews($slug = false)
    {
        if ($slug === false) {
            return $this->findAll();
        }

        return $this->where(['slug' => $slug])->first();
    }

    protected $allowedFields = ['title', 'slug', 'body'];
}
