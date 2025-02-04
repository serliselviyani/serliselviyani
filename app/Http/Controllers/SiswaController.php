<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SiswaController extends Controller
{
    public function index(): View
    {
        //get Data db
        $siswas = DB::table('siswas')
        ->join('users', 'siswas.id_user', '=', 'users.id')
        ->select(
            'siswas.*',
            'users.name',
            'users.email'
        )
        ->paginate(10);


        return view('admin.siswa.index', compact('siswas'));
    
    }
    public function create(): View
    {
        return view('admin.siswa.create');
    }


public function store(Request $request): RedirectResponse
{
    //validate form
    $validated =$request->validate([
        'name'     =>'required|string|max:250',
        'email'    =>'required|email|max:250|unique:users',
        'password' =>'required|min:8|confirmed',
        'image'    =>'required|image|mimes:jpeg,png,jpg|max:2048',
        'nis'      =>'required|numeric',
        'tingkatan'=>'required',
        'jurusan'  =>'required',
        'kelas'    =>'required',
        'hp'       =>'required|numeric',
    ]);

    //upload image
    $image = $request->file('image');
    $image->storeAs('public/siswas', $image->hashName());

    $id_akun = $this->insertAccount($request->name, $request->email, $request->password);
     
    //create post
    Siswa::create([
        'id_user'  =>$id_akun,
        'image'    =>$image->hashName(),
        'nis'      =>$request->nis,
        'tingkatan'=>$request->tingkatan,
        'jurusan'  =>$request->jurusan,
        'kelas'    =>$request->kelas,
        'hp'       =>$request->hp,
        'status'   =>1

    ]);

    //redirect to index
    return redirect()->route('siswa.index')->with(['success' => 'Data Berhasil Disimpan!']);

}

public function insertAccount(string $name, string $email, string $password)
{
    
    User::create([
        'name'     =>$name,
        'email'    =>$email,
        'password' =>Hash::make($password),
        'usertype' =>'siswa'
    ]);

    $id = DB::table('users')->where('email', $email)->value('id');

    return $id;
}
}