@extends('admin.layouts.app')

@section('title', 'Manajemen Pengguna')

@section('content')
<h2 class="text-white mb-4">Manajemen Pengguna</h2>

<div class="card glass-card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Username</th> <!-- ✅ UBAH DARI ID JADI USERNAME -->
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Telepon</th>
                        <th>Tanggal Lahir</th>
                        <th>Alamat</th>
                        <th>Bergabung</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->username }}</td> <!-- ✅ GUNAKAN USERNAME -->
                        <td>{{ $user->nama ?? '-' }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->telepon ?? '-' }}</td>
                        <td>{{ $user->tanggal_lahir ? \Carbon\Carbon::parse($user->tanggal_lahir)->format('d M Y') : '-' }}</td>
                        <td>{{ $user->alamat != ', ,' ? $user->alamat : '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($user->date)->format('d M Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection