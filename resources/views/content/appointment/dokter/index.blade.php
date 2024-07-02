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

            <div>
            <a href="{{route('doctor.dashboard')}}" class="btn btn-secondary mb-3">Kembali</a>
        </div>
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Data Appointment</h3>
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
                        <th>No</th>
                        <th>Nama Pegawai</th>
                        <th>Jenis Kelamin</th>
                        <th>Jabatan</th>
                        <th>Appointment Date</th>
                        <th>Waktu Mulai</th>
                        <th>Catatan Appointment</th>
                        <th>Catatan Alergi Obat</th>
                        <th>Status</th>
                        <th>Status Diagnosa</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($appointments as $index => $appointment)
                        <tr>
                                <td><span class="text-muted">{{$index + 1}}</span></td>
                                <td>{{$appointment->employee->user->first_name}} {{$appointment->employee->user->last_name}}</td>
                                <td>{{$appointment->employee->user->gender}}</td>
                                <td>{{$appointment->employee->user->position}}</td>
                                <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d-m-Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($appointment->appointment_start_time)->format('H:i') }}</td>
                                <td>{{$appointment->note}}</td>
                                <td>{{$appointment->alergi_obat}}</td>
                                <td>
                                    <span class="badge {{$appointment->status === 'pending' ? 'bg-warning':($appointment->status === 'approved' ? 'bg-success' :($appointment->status === 'rejected' ? 'bg-danger':'bg-secondary'))}} me-1">
                                        {{$appointment->status}}
                                    </span>
                                </td>
                              <td><span class="badge {{$appointment->diagnosed === false ? 'bg-warning':($appointment->diagnosed === true ? 'bg-success' : '')}} me-1">
                                        @if($appointment->diagnosed == true )
                                            Sudah
                                      @else
                                      Belum
                                      @endif
                                    </span></td>
                                 <td class="text-end">
                                    @if($appointment->status === "approved")
                                      @elseif($appointment->status === "pending")
                                       <a href="{{route('approve-appointment', $appointment->id)}}" id="approve" class="btn btn-green">Approve</a>
                                       @endif
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
    </div>
@endsection
@section('script')
    <script>
        $(document).ready( function (){
             var token = $("meta[name='csrf-token']").attr("content");
            $('#approve').click(function (){
                $.ajax({
                    url:$(this).attr('href'),
                    type: 'GET',
                    success: function (response){
                        if(response.success){
                            alert('Appointment approved successfully!')
                           location.reload()
                        }else {
                            alert('Failed to approve appointment')
                        }
                    },
                    error:function (xhr){
                        alert('An error occured: ' + xhr.responseText)
                    }
                });
            });
            {{--$('#cancel').click(function (){--}}
            {{--    $.ajax({--}}
            {{--        url: $(this).attr('href'),--}}
            {{--        type: 'GET',--}}
            {{--        success: function (response){--}}
            {{--            if(response.success){--}}
            {{--                location.reload()--}}
            {{--                alert('Appointment cancelled successfully!')--}}
            {{--            }else {--}}
            {{--                alert('Failed to cancel appointment')--}}
            {{--            }--}}
            {{--        },--}}
            {{--        error: function (xhr){--}}
            {{--            alert('An error occured: ' + xhr.responseText)--}}
            {{--        }--}}
            {{--    })--}}
            {{--})--}}
            {{--$('#delete').click(function(){--}}
            {{--    let appointmentId = $(this).data('id')--}}
            {{--    if(confirm('Are you sure want to delete this appointment?')){--}}
            {{--        $.ajax({--}}
            {{--            url:'/api/delete-appointment/'+appointmentId,--}}
            {{--            type:'DELETE',--}}
            {{--            data:{--}}
            {{--                _token:'{{csrf_token()}}'--}}
            {{--            },--}}
            {{--            success:function (response){--}}
            {{--                if(response.success){--}}
            {{--                    location.reload()--}}
            {{--                    alert('Appopintment deleted successfully!')--}}
            {{--                }else {--}}
            {{--                    alert('Failed to delete appointment')--}}
            {{--                }--}}
            {{--            },--}}
            {{--            error: function (xhr){--}}
            {{--                alert('An error occured : ' + xhr.responseText)--}}
            {{--            }--}}

            {{--        })--}}
            {{--    }--}}
            {{--})--}}
        });
    </script>
@endsection
