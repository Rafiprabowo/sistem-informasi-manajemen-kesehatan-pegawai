@extends('template')
@section('aside')
    @include('partials.aside.dokter')
@endsection
@section('content')
    <div class="col-md-8">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible" role="alert">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="icon icon-tabler icons-tabler-outline icon-tabler-check">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M5 12l5 5l10 -10"/>
                    </svg>
                </div>
                <div>
                    {{session('success')}}
                </div>
                <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
            </div>
        @endif
        @if(session('error'))
            {{session('error')}}
        @endif
        <div class="card">
              <div class="row g-0">
                  <form action="{{route('diagnose.store', $appointment->id)}}" method="post">
                      @csrf
                <div class="col d-flex flex-column">
                  <div class="card-body">
                    <h2 class="mb-4">Diagnosis Pegawai</h2>
                    <h3 class="card-title">Profile Details</h3>
                    <div class="col g-3">
                      <div class="col-md-6">
                        <div class="form-label">Nama</div>
                        <p>{{$appointment->employee->user->first_name}}</p>
                      </div>
                      <div class="col-md-6">
                        <div class="form-label">Alamat</div>
                        <p>{{$appointment->employee->user->address}}</p>
                      </div>
                      <div class="col-md-6">
                        <div class="form-label">No Hp</div>
                        <p>{{$appointment->employee->user->phone}}</p>
                      </div>
                    </div>
                    <h3 class="card-title mt-4">Diagnosis</h3>
                    <div>
                      <div class="row g-3">
                        <div class="col-md-8">
                            <textarea name="diagnose" id="diganosis" class="form-control" placeholder="Type something…" >{{$appointment->diagnoses->diagnosis ?? ''}}</textarea>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="card-footer bg-transparent mt-auto">
                    <div class="btn-list justify-content-end">
                      <a href="#" class="btn">
                        Cancel
                      </a>
                      <button type="submit" class="btn btn-primary">
                        Submit
                      </button>
                    </div>
                  </div>
                </div>
                  </form>
              </div>
            </div>
    </div>
@endsection


