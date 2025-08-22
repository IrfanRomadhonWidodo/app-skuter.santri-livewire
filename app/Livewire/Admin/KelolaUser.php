<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;

class KelolaUser extends Component
{
    use WithPagination;

    public $userId;
    public $name, $nim, $program, $email, $password, $role = 'mahasiswa';
    public $isEdit = false;
    public $showModal = false;
    public $search = '';

    protected $rules = [
        'name'     => 'required|string|max:255',
        'nim'      => 'nullable|string|max:50',
        'program'  => 'nullable|string|max:100',
        'email'    => 'required|email|unique:users,email',
        'password' => 'required|min:6',
        'role'     => 'required|in:mahasiswa,admin',
    ];

    protected $listeners = [
        'deleteUser' => 'deleteUser'
    ];

    public function render()
    {
        $users = User::when($this->search, function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('nim', 'like', '%' . $this->search . '%')
                  ->orWhere('program', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
        })->latest()->paginate(10);

        return view('livewire.admin.kelola.kelola-user', [
            'users' => $users,
        ]);
    }

    public function showCreateModal()
    {
        $this->resetForm();
        $this->isEdit = false;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset(['userId','name','nim','program','email','password','isEdit']);
        $this->role = 'mahasiswa';
        $this->resetErrorBag();
    }

    public function store()
    {
        try {
            $this->validate();

            User::create([
                'name'     => $this->name,
                'nim'      => $this->nim,
                'program'  => $this->program,
                'email'    => $this->email,
                'password' => Hash::make($this->password),
                'role'     => $this->role,
            ]);

            $this->closeModal();
            $this->dispatch('showSuccessMessage', ['message' => 'User berhasil ditambahkan.']);
            
        } catch (\Exception $e) {
            $this->dispatch('showErrorMessage', ['message' => 'Gagal menambahkan user: ' . $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        try {
            $user = User::findOrFail($id);

            $this->userId   = $user->id;
            $this->name     = $user->name;
            $this->nim      = $user->nim;
            $this->program  = $user->program;
            $this->email    = $user->email;
            $this->role     = $user->role;
            $this->password = ''; // Reset password field

            $this->isEdit = true;
            $this->showModal = true;
            
        } catch (\Exception $e) {
            $this->dispatch('showErrorMessage', ['message' => 'User tidak ditemukan.']);
        }
    }

    public function update()
    {
        try {
            $user = User::findOrFail($this->userId);

            $rules = [
                'name'     => 'required|string|max:255',
                'nim'      => 'nullable|string|max:50',
                'program'  => 'nullable|string|max:100',
                'email'    => 'required|email|unique:users,email,'.$user->id,
                'role'     => 'required|in:mahasiswa,admin',
            ];

            if ($this->password) {
                $rules['password'] = 'min:6';
            }

            $this->validate($rules);

            $data = [
                'name'    => $this->name,
                'nim'     => $this->nim,
                'program' => $this->program,
                'email'   => $this->email,
                'role'    => $this->role,
            ];

            if ($this->password) {
                $data['password'] = Hash::make($this->password);
            }

            $user->update($data);

            $this->closeModal();
            $this->dispatch('showSuccessMessage', ['message' => 'User berhasil diperbarui.']);
            
        } catch (\Exception $e) {
            $this->dispatch('showErrorMessage', ['message' => 'Gagal memperbarui user: ' . $e->getMessage()]);
        }
    }

    public function confirmDelete($id)
    {
        $this->dispatch('confirmDelete', ['id' => $id]);
    }

    public function deleteUser($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            $this->dispatch('showSuccessMessage', ['message' => 'User berhasil dihapus.']);
        } catch (\Exception $e) {
            $this->dispatch('showErrorMessage', ['message' => 'Gagal menghapus user: ' . $e->getMessage()]);
        }
    }


    public function updatingSearch()
    {
        $this->resetPage();
    }
}