@extends('template')
@section('aside')
    @include('partials.aside.pegawai')
@endsection
@section('content-header')
    @include('partials.content-header.pegawai.create_janji_temu')
@endsection
@section('content')
    <div class="col-md-6">
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
              <form class="card" action="/pegawai/janji-temu" method="post">
                  @csrf
                <div class="card-header">
                  <h3 class="card-title">Form Janji Temu</h3>
                </div>
                <div class="card-body">
                    <input type="hidden" name="employee_id" value="{{$user->employee->id}}">
                  <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Nama" value="{{old('name', $user->name)}}" >
                            @error('name')
                              <div class="invalid-feedback">{{$message}}</div>
                              @enderror
                          </div>
                  <div class="mb-3">
                            <label class="form-label ">Alamat</label>
                            <input type="text" name="address" class="form-control @error('address') is-invalid @enderror " placeholder="Address" value="{{old('address', $user->address)}}" >
                            @error('address')
                              <div class="invalid-feedback">{{$message}}</div>
                              @enderror
                          </div>
                     <div class="mb-3">
                            <label class="form-label ">Phone</label>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="+62xx" value="{{old('phone',$user->phone)}}">
                            @error('phone')
                              <div class="invalid-feedback">{{$message}}</div>
                              @enderror
                          </div>
                  <div class="mb-3">
                    <label class="form-label">Pilih Dokter</label>
                    <div>
                      <select class="form-select" name="doctor_id">
                       @if($doctors)
                           @foreach($doctors as $doctor)
                           <option value="{{$doctor->id}}">{{$doctor->user->name}}</option>
                           @endforeach
                          @else
                          <option class="@error('doctor_id') is-invalid @enderror">Dokter tidak tersedia</option>
                           @error('doctor_id')
                            <div class="invalid-feedback">{{$message}}</div>
                           @enderror
                          @endif
                      </select>
                    </div>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Pilih Tanggal & Waktu</label>
                    <div>
                        <input type="datetime-local" class="form-fieldset @error('appointments_time') is-invalid @enderror" name="appointments_time" id="">
                        @error('appointments_time')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                  </div>
                </div>
                <div class="card-footer text-end">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>

              </form>
            </div>
@endsection
