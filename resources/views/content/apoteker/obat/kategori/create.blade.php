@extends('template')
@section('aside')
    @include('partials.aside.apoteker')
@endsection
@section('content-header')
    @include('partials.content-header.apoteker.obat.kategori.create')
@endsection
@section('content')
    <div class="col-lg-8">
        <form class="card">
            <div class="card-header">
                <h3 class="card-title">Tambah kategori form</h3>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label required">Nama</label>
                    <div>
                        <input name="name" type="text" class="form-control"  placeholder="nama kategori">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label required">Deskripsi</label>
                    <div>
                        <input type="text" name="description" class="form-control" placeholder="deskripsi kategori">
                    </div>
                </div>
            </div>
            <div class="card-footer text-end">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
@endsection
