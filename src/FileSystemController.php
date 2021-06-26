<?php

namespace NLDev\FileSystem;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use NLDev\FileSystem\Facades\FileSystem;
use NLDev\FileSystem\Models\File;

class FileSystemController extends Controller{

    public function index(){
        $files = File::all();

        echo '<pre>';
        echo FileSystem::check();
        echo '<br/>';
        foreach($files as $file){
            echo $file->link;
            echo $file->delete_form;
        }
        echo '</pre>';
    }

    public function create(){
        return view('FileSystem::create');
    }

    public function store(Request $request){
        $file = $request->file('file');
        $user = User::find(1);
        $upload = FileSystem::upload($file, $user);
        return $upload ? back()->withMessage('File uploaded with success') : back()->withMessage('Error when processing to upload file');
    }

    public function destroy(File $file){
        return FileSystem::remove($file);
    }

}
