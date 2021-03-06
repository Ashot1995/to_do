<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public function category()
    {
        return $this->belongsTo('app\Models\Category', 'idCategory', 'id');
    }

    public function countTasks()
    {
        return self::all()->count();
    }

    public function search($idCategory = null, $q = null)
    {
        $result = self::orderBy('created_at', 'asc');
        if (!empty($q)) {
            $result = self::where('name', 'like', '%' . $q . '%');
        }
        if (!empty($idCategory)) {
            $result->where('idCategory', $idCategory);
        }

        return $result->get();
    }
}
