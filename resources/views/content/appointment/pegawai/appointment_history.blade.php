@section('aside')
    @include('partials.aside.pegawai')
@endsection

@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Appointments</h3>
            </div>
            <div class="card-body border-bottom py-3">
                <div class="d-flex">
                    <div class="text-muted">
                        Show
                        <div class="mx-2 d-inline-block">
                            <input type="text" class="form-control form-control-sm" value="8" size="3" aria-label="Invoices count">
                        </div>
                        entries
                    </div>
                    <div class="ms-auto text-muted">
                        Search:
                        <div class="ms-2 d-inline-block">
                            <input type="text" class="form-control form-control-sm" aria-label="Search invoice">
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table card-table table-vcenter text-nowrap datatable">
                    <thead>
                    <tr>
                        <th class="w-1"><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></th>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Phone</th>
                        <th>Appointment time</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($user->employee->appointments)
                        @foreach($user->employee->appointments as $index => $appointment)
                            <tr>
                                <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select invoice"></td>
                                <td><span class="text-muted">{{$index + 1}}</span></td>
                                <td><a href="#" class="text-reset" tabindex="-1">{{$appointment->name}}</a></td>
                                <td>{{$appointment->address}}</td>
                                <td>{{$appointment->phone}}</td>
                                <td>{{$appointment->appointment_time}}</td>
                                <td>
                                    <span class="badge {{$appointment->status === 'pending' ? 'bg-warning':($appointment->status === 'approved' ? 'bg-success' :($appointment->status === 'rejected' ? 'bg-danger':'bg-secondary'))}} me-1">
                                        {{$appointment->status}}
                                    </span>
                                </td>
                                <td class="text-end">
                                        <span class="dropdown">
                                          <button class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport" data-bs-toggle="dropdown">Actions</button>
                                          <div class="dropdown-menu dropdown-menu-end">
                                              @if($appointment->status === "approved")
                                                  <a id="diagnosa" class="dropdown-item" data-id="{{$appointment->id}}">Diagnosa</a>
                                              @elseif($appointment->status === "pending")
                                                  <a id="approve" class="dropdown-item" data-id="{{$appointment->id}}">Approve</a>
                                              @endif
                                              <a id="delete" class="dropdown-item" data-id="{{$appointment->id}}">Delete</a>
                                          </div>
                                        </span>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td>data tidak tersedia</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endif

                    </tbody>
                </table>
            </div>
            <div class="card-footer d-flex align-items-center">
                <p class="m-0 text-muted">Showing <span>1</span> to <span>8</span> of <span>16</span> entries</p>
                <ul class="pagination m-0 ms-auto">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                            <!-- Download SVG icon from http://tabler-icons.io/i/chevron-left -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 6l-6 6l6 6" /></svg>
                            prev
                        </a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item active"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">4</a></li>
                    <li class="page-item"><a class="page-link" href="#">5</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#">
                            next <!-- Download SVG icon from http://tabler-icons.io/i/chevron-right -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 6l6 6l-6 6" /></svg>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready( function (){
            $('#approve').click(function (){
                // get appointment id
                var appointmentId = $(this).data('id')
                $.ajax({
                    url:'/api/approve-appointment/'+appointmentId,
                    type: 'POST',
                    data:{
                        _token:'{{csrf_token()}}'
                    },
                    success: function (response){
                        if(response.success){
                            location.reload()
                            alert('Appointment approved successfully!')
                        }else {
                            alert('Failed to approve appointment')
                        }
                    },
                    error:function (xhr){
                        alert('An error occured: ' + xhr.responseText)
                    }
                });
            });

            $('#delete').click(function(){
                var appointmentId = $(this).data('id')
                if(confirm('Are you sure wanto delete this appointment?')){
                    $.ajax({
                        url:'/api/delete-appointment/'+appointmentId,
                        type:'DELETE',
                        data:{
                            _token:'{{csrf_token()}}'
                        },
                        success:function (response){
                            if(response.success){
                                location.reload()
                                alert('Appopintment deleted successfully!')
                            }else {
                                alert('Failed to delete appointment')
                            }
                        },
                        error: function (xhr){
                            alert('An error occured : ' + xhr.responseText)
                        }

                    })
                }
            })
        });
    </script>
@endsection
