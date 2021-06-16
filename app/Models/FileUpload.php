<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class FileUpload extends Model
{
    public $table_name;

    public function __construct($model)
    {
        $this->table_name = $model->getTable();
    }

    public function upload(Request $request)
    {
        $destinationPath = public_path('/files/images/' . $this->table_name);
        $image = $request->file('image');
        $name = time() . '.' . $image->getClientOriginalExtension();

        $image->move($destinationPath, $name);

        return [
            'success' => true,
            'name' => $name,
        ];
    }

    public function rollback(Request $request, $name)
    {
        $path = $destinationPath = public_path('/files/images/' . $this->table_name);
        $path = $path . DIRECTORY_SEPARATOR . $name;
        if (File::exists($path)) {
            File::deleteDirectory($path);
        }
    }
}
