@extends('template')
@section('aside')
    @include('partials.aside.apoteker')
@endsection
@section('content-header')
@include('partials.content-header.apoteker.obat.create')
@endsection
@section('content')
    <div class="col-md-6">
        <form class="card" action="{{route('medicines.store')}}" method="post">
            @csrf
            <div class="card-header">
                <h3 class="card-title">Tambah obat form</h3>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label required">Nama</label>
                    <div>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="nama obat">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label required">Deskripsi</label>
                    <div>
                        <input type="text" name="description" class="form-control @error('description') is-invalid @enderror" placeholder="deskripsi obat">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Pilih kategori</label>
                    <div>
                        <select class="form-select @error('categories_id') is-invalid @enderror" name="categories_id">
                            @if($categories)
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            @endif
                            @error('categories_id')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-footer text-end">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
@endsection
