<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="'.route('user.edit', $row->id).'" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a> ';
                    $btn .= '<form action="'.route('user.destroy', $row->id).'" method="POST" style="display:inline">';
                    $btn .= csrf_field().method_field('DELETE');
                    $btn .= '<button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Hapus data ini?\')">
                                <i class="fas fa-trash"></i>
                            </button>';
                    $btn .= '</form>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $breadcrumb = (object) [
            'title' => 'Data User',
            'list'  => ['Home', 'Data User']
        ];
        $page = (object) [
            'title' => ''
        ];
        $data = User::all();
        $activeMenu = 'user';
        return view('user.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Data User',
            'list' => ['Home', 'Data User', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah User'
        ];
        $activeMenu = 'user';
        return view('user.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);

        User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        return redirect()->route('user.index')->with('success', 'Data berhasil disimpan');
    }

    public function edit(string $id)
    {
        $user = User::findOrFail($id);

        $breadcrumb = (object) [
            'title' => 'Data User',
            'list' => ['Home', 'Data User', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit User'
        ];
        $activeMenu = 'user';
        return view('user.edit', [
            'user' => $user, // ← INI WAJIB ADA
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu
        ]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'username' => 'required|unique:users,username,'.$id,
            'email' => 'required|email|unique:users,email,'.$id
        ]);

        $user = User::findOrFail($id);
        $user->username = $request->username;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect()->route('user.index')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('user.index')->with('success', 'Data berhasil dihapus');
    }
}
