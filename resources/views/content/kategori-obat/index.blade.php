@extends('template')
@if($user->role === "admin")
    @section('aside')
        @include('partials.aside.admin')
    @endsection
@elseif($user->role === "apoteker")
    @section('aside')
        @include('partials.aside.apoteker')
    @endsection
@endif
@section('content-header')
        @include('partials.content-header.kategori-obat.index')
@endsection
@section('content')
    <div class="col-md-8">
    <div class="card">
        <div class="card-body">
            @if(session()->has('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-check"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                    </div>
                    <div>
                        {{session('success')}}
                    </div>
                    <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                </div>
            @endif
            <div class="d-flex">
                    <div class="text-muted">
                        Show
                        <div class="mx-2 d-inline-block">
                            <input type="text" class="form-control form-control-sm" value="8" size="3" aria-label="Invoices count">
                        </div>
                        entries
                    </div>
                    <div class="ms-auto text-muted">
                        Search:
                        <div class="ms-2 d-inline-block">
                            <input type="text" class="form-control form-control-sm" aria-label="Search invoice">
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table card-table table-vcenter text-nowrap datatable">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Deskripsi</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($medicines) > 0)
                            @foreach($categories as $index => $categorie)
                        <tr>
                            <td>{{$index + 1}}</td>
                            <td class="sort-name">{{$categorie->name}}</td>
                            <td class="sort-name">{{$categorie->description}}</td>
                            <td>
                                <span class="dropdown">
                                    <button class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport" data-bs-toggle="dropdown">Actions</button>
                                    <div class="dropdown-menu">
                                         <a id="edit" class="dropdown-item" data-id="{{$categorie->id}}">Edit</a>
                                        <a id="hapus" class="dropdown-item" data-id="{{$categorie->id}}">Hapus</a>

                                    </div>
                                </span>
                            </td>
                        <tr>
                    @endforeach
                        @else
                            <tr>
                                <td>data tidak tersedia</td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        @endif

                        </tbody>
                    </table>
                </div>



        </div>
    </div>
    </div>
@endsection
