<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateUser;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function __construct(
        private User $user
    ) {
        $this->middleware('can:is-super-admin');
    }

    public function index()
    {
        $users = $this->user->with('roles')->latest()->paginate();
        return view('admin.pages.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.pages.users.create');
    }

    public function store(StoreUpdateUser $request)
    {
        $user = $this->user->create(
            [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),

                'cpf' => $request->cpf,
                'address' => $request->address,
                'data_birth' => $request->data_birth,
            ]
        );

        $participanteRole = Role::where('name', 'admin')->first();

        if ($participanteRole) {
            $user->roles()->attach($participanteRole->id);
        }

        return redirect()->route('users.index')
            ->with('success', 'Criado com sucesso.');
    }

    public function show(string $id)
    {
        if (!$user = $this->user->find($id)) {
            return redirect()->back();
        }

        return view('admin.pages.users.show', compact('user'));
    }

    public function edit(string $id)
    {
        if (!$user = $this->user->find($id)) {
            return redirect()->route('users.index');
        }

        return view('admin.pages.users.edit', compact('user'));
    }

    public function update(Request $request, string $id)
    {
        if (!$user = $this->user->find($id)) {
            return redirect()->back();
        }

        $dataForm =  $request->only('name', 'data_birth', 'address');
        $user->update($dataForm);

        return redirect()->route('users.index')
            ->with('success', 'Atualizada com sucesso.');
    }

    public function destroy(string $id)
    {
        if (!$user = $this->user->find($id)) {
            return redirect()->back();
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'Excluído com sucesso.');
    }
}
