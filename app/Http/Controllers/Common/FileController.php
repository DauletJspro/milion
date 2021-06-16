<?php


namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use MongoDB\Driver\Session;

class FileController extends Controller
{

    public function tempFileUpload(Request $request)
    {
        $this->validate($request, [
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $destinationPath = public_path('/temp/images/profile/' . $request->session()->getId() . DIRECTORY_SEPARATOR);
        if (File::exists($destinationPath)) {
            File::cleanDirectory($destinationPath);
        }
        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $name = time() . '.' . $image->getClientOriginalExtension();

            $image->move($destinationPath, $name);
            $path = 'temp/images/profile' . $request->session()->getId() . DIRECTORY_SEPARATOR . $name;
            return response()->json([
                'success' => true,
                'path' => asset($path),
            ]);
        }
    }

    public function moveFileFromTemp(Request $request)
    {
        $fromPath = public_path('/temp/images/profile/' . \session()->getId() . DIRECTORY_SEPARATOR);
        $toPath = public_path('/files/images/profile/');
        if (File::exists($fromPath)) {
            $files = File::files($fromPath);
            foreach ($files as $file) {
                $file = pathinfo($file);
                $file = $file['filename'] . '.' . $file['extension'];
                File::move($fromPath . DIRECTORY_SEPARATOR . $file, $toPath . DIRECTORY_SEPARATOR . $file);
            }
            File::cleanDirectory($fromPath);
            File::deleteDirectory($fromPath);
            Auth::user()->image = 'profile/' . $file;
            Auth::user()->save();
        }
    }
}
