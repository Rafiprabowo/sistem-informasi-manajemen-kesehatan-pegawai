@extends('template')
@section('aside')
    @include('partials.aside.dokter')
@endsection
@section('content')
     <div class="col-12">
         @if(session()->has('success'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-check">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M5 12l5 5l10 -10" />
                </svg>
            </div>
            <div>
                {{ session('success') }}
            </div>
            <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
        </div>
        @endif
            <div class="mx-3">
            <a href="{{route('doctor.dashboard')}}" class="btn btn-secondary mb-3">Kembali</a>
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Buat Diagnosa Untuk Pegawai</h3>
                  </div>
                  <div class="card-body border-bottom py-3">
                    <div class="d-flex">
                      <div class="text-muted">
                        Show
                        <div class="mx-2 d-inline-block">
                          <input type="text" class="form-control form-control-sm" value="{{$appointments->total()}}" size="3" aria-label="Invoices count">
                        </div>
                        entries
                      </div>
                      <x-search-form
                        action="{{route('appointment.search')}}"
                        placeholder="Cari appointment"
                        buttonText="Cari"
                        value="{{ request('search') }}"
                    />
                    </div>
                  </div>
                  <div class="table-responsive">

                    <table class="table card-table table-vcenter text-nowrap datatable">
                      <thead>
                        <tr>
                          <th>Appointment ID</th>
                          <th>Detail Appointment</th>
                          <th>Biodata Pegawai</th>
                          <th>Kontak Darurat</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        @forelse($appointments as $index => $appointment)
                             <tr>
                                <td>{{ $appointment->id }}</td>
                                <td>
                                    <label for="" class="form-label">Detail Appointment</label>
                                    <ul class="list-group" >
                                        <li class="list-group-item">Tgl : {{ \Carbon\Carbon::parse($appointment->date)->format('d-m-Y') }}</li>
                                        <li class="list-group-item">Waktu: {{ \Carbon\Carbon::parse($appointment->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($appointment->end_time)->format('H:i') }}</li>
                                        <li class="list-group-item">Catatan: {{ $appointment->note }}</li>
                                        <li class="list-group-item">Alergi Obat: {{ $appointment->alergi_obat }}</li>
                                    </ul>
                                </td>
                                <td>
                                    <label for="" class="form-label">Biodata Pegawai</label>
                                    <ul class="list-group">
                                        <li class="list-group-item">Nama : {{ $appointment->employee->user->first_name . ' ' . $appointment->employee->user->last_name }}</li>
                                        <li class="list-group-item">JK: {{ $appointment->employee->gender }}</li>
                                        <li class="list-group-item">Tgl Lahir: {{ $appointment->employee->date_of_birth ? \Carbon\Carbon::parse($appointment->employee->date_of_birth)->format('d-m-Y') : 'Data tidak tersedia' }}</li>
                                        <li class="list-group-item">Usia: {{ $appointment->employee->age ?? 'Data tidak tersedia' }}</li>
                                        <li class="list-group-item">Riwayat Penyakit: {{ $appointment->employee->medical_history ?? 'null' }}</li>
                                    </ul>
                                </td>
                                 <td class="">
                                     <label for="" class="form-label">Kontak Darurat</label>
                                     <ul class="list-group">
                                         <li class="list-group-item">Nama  : {{$appointment->employee->emergency_contact_name}}</li>
                                         <li class="list-group-item">Hubungan : {{$appointment->employee->emergency_contact_name}}</li>
                                         <li class="list-group-item">Nomor Hp  : {{$appointment->employee->emergency_contact_number}}</li>
                                         <li class="list-group-item">Alamat  : {{$appointment->employee->emergency_contact_address}}</li>
                                     </ul>
                                 </td>
                                 <td>
                                     <div class="mb-3">
                                         <a href="{{route('diagnosa.edit', $appointment->id)}}" class="btn btn-primary">Buat Diagnosa</a>
                                     </div>
                                 </td>
                            </tr>
                        @empty
                        @endforelse
                      </tbody>
                    </table>
                  </div>
                    <div class="card-footer d-flex align-items-center">
                <p class="m-0 text-muted">Showing {{ $appointments->firstItem() }} to {{ $appointments->lastItem() }} of {{ $appointments->total() }} entries</p>
                {{ $appointments->links() }}
                </div>
              </div>
            @endsection
            @section('script')
                    <script>
                         $(document).ready(function() {
        // Check if there is a success message in sessionStorage
        var successMessage = sessionStorage.getItem('successMessage');
        if (successMessage) {
            // Display success message using alert or other UI element
            alert(successMessage);
            // Clear the session after displaying the message
            sessionStorage.removeItem('successMessage');
        }
    });
                    </script>

@endsection
