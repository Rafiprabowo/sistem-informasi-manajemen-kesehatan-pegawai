@extends('template')
@section('aside')
    @include('partials.aside.admin')
@endsection
@section('content')
    <div class="col-12">
        <div class="d-flex mb-3">
            <a href="/admin/" class="btn btn-secondary">Kembali</a>
            <a href="{{ route('pegawais.create') }}" class="btn btn-primary mx-3">Tambah pegawai</a>
        </div>
        @if(session()->has('success'))
            <div class="alert alert-success alert-dismissible" role="alert">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="icon icon-tabler icon-tabler-check">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M5 12l5 5l10 -10"/>
                    </svg>
                </div>
                <div>
                    {{ session('success') }}
                </div>
                <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
            </div>
        @endif
        <div class="card">
            <div class="table-responsive">
                <table class="table table-vcenter card-table">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Jabatan</th>
                        <th>Alamat</th>
                        <th>No Hp</th>
                        <th>Jenis Kelamin</th>
                        <th>Kontak darurat</th>
                        <th>Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($employees as $employee)
                        <tr>
                            <td>{{ $loop->iteration + $i }}</td>
                            <td>{{ $employee->user->first_name }} {{ $employee->user->last_name }}</td>
                            <td>{{ $employee->position }}</td>
                            <td>{{ $employee->user->address }}</td>
                            <td>{{ $employee->user->phone }}</td>
                            <td>{{ $employee->gender }}</td>
                            <td>
                                <ul>
                                    <li>Nama : {{$employee->emergency_contact_name}}</li>
                                    <li>Alamat : {{$employee->emergency_contact_address}}</li>
                                    <li>No Hp : {{$employee->emergency_contact_number}}</li>
                                    <li>Hubungan : {{$employee->emergency_contact_relationship}}</li>
                                </ul>
                            </td>
                            <td>
                                <div class="d-flex">
                                    <div>
                                    <a href="{{route('pegawais.edit', $employee->id)}}" class="btn btn-secondary">Edit</a>
                                </div>
                                <form action="{{ route('pegawais.destroy', $employee->user->id) }}" method="POST"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus pegawai ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger mx-2">Hapus</button>
                                </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">Tidak ada data pegawai</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                <div class="card-footer d-flex align-items-center">
                    <p class="m-0 text-muted">
                        Showing {{ $employees->firstItem() }} to {{ $employees->lastItem() }}
                        of {{ $employees->total() }} entries
                    </p>
                    {{ $employees->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
