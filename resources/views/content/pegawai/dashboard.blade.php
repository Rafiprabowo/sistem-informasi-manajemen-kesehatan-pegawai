@extends('template')

@section('aside')
    @include('partials.aside.pegawai')
@endsection

@section('content-header')

@endsection

@section('content')
<div class="row row-deck row-cards">
    <div class="col-sm-6 col-lg-3">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex align-items-center">
                      <h2>Appointment Pending</h2>
                    </div>
                    <div class="h1 mb-3">
                        {{$totalAppointmentsPending}}
                    </div>
                  </div>
                </div>
              </div>
     <div class="col-sm-6 col-lg-3">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex align-items-center">
                      <h2>Appointment yang sudah didiagnosa</h2>
                    </div>
                    <div class="h1 mb-3">
                        {{$totalDiagnosedAppointments}}
                    </div>
                  </div>
                </div>
              </div>

    <div class="col-sm-6 col-lg-3">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex align-items-center">
                      <h2>Medical Check Up</h2>
                    </div>
                    <div class="h1 mb-3">
                        {{$totalMedicalCheckups}}
                    </div>
                  </div>
                </div>
              </div>

</div>
@endsection
