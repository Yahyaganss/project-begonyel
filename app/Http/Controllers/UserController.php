<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        //ambil data dari tabel users

        // Eloquent (menggunakan model)
        $users = User::all();
        // dd($users);

        // Query builder
        // SELECT * FROM USER
        // $users = DB::table('users')->get();

        return view('backend.user.index', [
            'users' => $users,
        ]);
    }

    // show add form
    public function create()
    {
        return view('backend.user.add');
    }

    // insert data to table
    public function store(Request $request)
    {
        // data yg akan diterima function store
        $name = $request->name;
        $email = $request->email;
        $jk = $request->jk;
        $level = $request->level;
        $no_telp = $request->no_telp;
        $password = Hash::make($request->password);

        // validasi sebelum insert ke tabel
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'jk' => 'required',
            'level' => 'required',
            'no_telp' => 'required',
            'password' => 'required'
        ]);

        // buat object untuk simpan data ke table
        $user = new User();

        //kirim nilai2 yg didapat dari form ke table
        $user->name = $name;
        $user->email = $email;
        $user->jk = $jk;
        $user->level = $level;
        $user->no_telp = $no_telp;
        $user->password = $password;

        // simpan data yg telah diterima ke dalam table
        $user->save();

        // redirect ke halaman users
        return redirect('users');
    }

    public function edit($id)
    {
        $user = User::find($id); // SELECT * FROM user WHERE id = $id
        // dd($user);

        // tampilkan form edit dan kirim datanya
        return view('backend.user.edit', compact('user'));
    }

    // update data selected
    public function update(Request $request)
    {
        // data yg akan diterima function store

        $id = $request->id;
        $name = $request->name;
        $email = $request->email;
        $jk = $request->jk;
        $level = $request->level;
        $no_telp = $request->no_telp;

        // buat object untuk simpan data ke table
        $user = User::find($id);

        if($request->password) {
            $password = Hash::make($request->password);
        } else {
            $password = $user->password;
        }

        //kirim nilai2 yg didapat dari form ke table
        $user->name = $name;
        $user->email = $email;
        $user->jk = $jk;
        $user->level = $level;
        $user->no_telp = $no_telp;
        $user->password = $password;

        // simpan data yg telah diterima ke dalam table
        // $user->save();

        $user->update();

        // redirect ke halaman users
        return redirect('users');
    }

    public function delete($id)
    {
        // query/perintah hapus data berdasarkan id
        User::find($id)->delete();

        // kembalikan ke halaman users
        return redirect('users');
    }

    public function profile()
    {
        $user = User::find(Auth::user()->id);
        return view('backend.profile.profile', compact('user'));
    }

    // update data selected
    public function updateProfile(Request $request)
    {
        // data yg akan diterima function store   

        $id = $request->id;
        $name = $request->name;
        $email = $request->email;
        $jk = $request->jk;
        $no_telp = $request->no_telp;

        // buat object untuk simpan data ke table
        $user = User::find($id);

        if($request->password) {
            $password = Hash::make($request->password);
        } else {
            $password = $user->password;
        }
        //kirim nilai2 yg didapat dari form ke table
        $user->name = $name;
        $user->email = $email;
        $user->jk = $jk;
        $user->no_telp = $no_telp;
        $user->password = $password;

        // simpan data yg telah diterima ke dalam table
        // $user->save();

        $user->update();

        // redirect ke halaman users
        return redirect('profile')->with([
            'pesan' => 'Data Berhasil diupdate!',
        ]);
    }
}
