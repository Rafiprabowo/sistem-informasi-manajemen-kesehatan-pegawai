@extends('template')
@section('aside')
    @include('partials.aside.pegawai')
@endsection
@section('content')
    <a href="{{route('pegawai.dashboard')}}" class="btn btn-secondary">Kembali</a>
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-9">
            <div class="card card-lg">
                <div class="card-body markdown">
                    <h1>Hasil Diagnosa {{$user->first_name.' '.$user->last_name}}</h1>
                    <hr>
                    <h3>Tanggal Appointment :  {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d-m-Y') }}
                     {{ $appointment->appointment_start_time }} - {{ $appointment->appointment_end_time }}</h3>
                    <h3>Appointment ID : {{$appointment->id}}</h3>
                    <h3>Appointment Type : {{$appointment->appointment_type}}</h3>
                    <h3>Catatan Appointment : {{$appointment->note}}</h3>
                    <h3>Catatan Alergi Obat : {{$appointment->alergi_obat}}</h3>
                    <hr>
                    <h3>Nama Dokter : {{$appointment->doctor->user->first_name}} {{$appointment->doctor->user->last_name}} </h3>
                    <h3>Spesialisasi : {{$appointment->doctor->speciality->name}}</h3>
                    <hr>
                    <h2>Hasil Diagnosa</h2>
                    <hr>
                    @php
                        $firstDiagnosis = $appointment->diagnoses->first();
                    @endphp
                    <h2>Hasil Diagnosa Penyakit : {{ $firstDiagnosis->diagnosa }}</h2>
                    <h3>Resep : </h3>
                    @foreach ($appointment->diagnoses as $diagnosis)
                        <ul>
                      @foreach ($diagnosis->medicines as $medicine)
                      <li>{{ $medicine->name }} - Dosis: {{ $medicine->pivot->dosis_obat }}</li>
                      @endforeach
                      </ul>
                      @endforeach

                </div>
            </div>
        </div>
    </div>
@endsection
