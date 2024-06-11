@extends('template')
@section('aside')
    @include('partials.aside.apoteker')
@endsection
@section('content-header')
    @include('partials.content-header.apoteker.obat.index')
@endsection
@section('content')
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
            <div id="table-default" class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th><button class="table-sort" data-sort="sort-name">No</button></th>
                        <th><button class="table-sort" data-sort="sort-name">Nama</button></th>
                        <th><button class="table-sort" data-sort="sort-city">Deskripsi</button></th>
                        <th><button class="table-sort" data-sort="sort-type">Kategori</button></th>

                    </tr>
                    </thead>
                    <tbody class="table-tbody">
                    @foreach($medicines as $index => $medicine)
                    <tr>
                            <td>{{$index + 1}}</td>
                            <td class="sort-name">{{$medicine->name}}</td>
                            <td class="sort-name">{{$medicine->description}}</td>
                            <td class="sort-type">{{$medicine->categories->name}}</td>
                    </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
