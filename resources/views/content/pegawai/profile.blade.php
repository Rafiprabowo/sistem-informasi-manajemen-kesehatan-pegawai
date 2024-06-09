@extends('template')
@section('aside')
@endsection
@include('partials.aside.pegawai')
@section('content-header')
@include('partials.content-header.pegawai.profile'))
@endsection

@section('content')
              <div class="row row-cards">
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
                <div class="col-lg-10">
                  <form action="/pegawai/profile" class="card" method="post" >
                      @csrf
                    <div class="card-body">
                      <h3 class="card-title">Edit Profile</h3>
                      <div class="row row-cards">
                        <div class="col-md-5">
                          <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Nama" value="{{old('name', auth()->user()->name)}}" >
                            @error('name')
                              <div class="invalid-feedback">{{$message}}</div>
                              @enderror
                          </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                          <div class="mb-3">
                            <label class="form-label " >Username</label>
                            <input type="text" name="username" class="form-control" placeholder="Username" disabled value="{{auth()->user()->username}}">
                          </div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                          <div class="mb-3">
                            <label class="form-label ">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Email" disabled value="{{auth()->user()->email}}">
                          </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                          <div class="mb-3">
                            <label class="form-label ">Alamat</label>
                            <input type="text" name="address" class="form-control @error('address') is-invalid @enderror " placeholder="Address" value="{{old('address', auth()->user()->address)}}" >
                            @error('address')
                              <div class="invalid-feedback">{{$message}}</div>
                              @enderror
                          </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                          <div class="mb-3">
                            <label class="form-label ">Phone</label>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="+62xx" value="{{old('phone', auth()->user()->phone)}}">
                            @error('phone')
                              <div class="invalid-feedback">{{$message}}</div>
                              @enderror
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="card-footer text-end">
                      <button type="submit" class="btn btn-primary">Update Profile</button>
                    </div>
                  </form>
                </div>
              </div>
@endsection
