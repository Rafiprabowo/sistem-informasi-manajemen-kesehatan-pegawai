@extends('template')

    @section('aside')
        @include('partials.aside.dokter')
    @endsection
    @section('content-header')
        @include('partials.content-header.jadwal-dokter.index')
    @endsection

@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Jadwal dokter</h3>
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
                        <th>Jadwal</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($user->doctor->schedules)
                        @foreach($user->doctor->schedules as $index => $schedule)
                            <tr>
                                <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select invoice"></td>
                                <td><span class="text-muted">{{$index + 1}}</span></td>
                                <td><a href="#" class="text-reset" tabindex="-1">{{$schedule->available_time}}</a></td>
                                <td>
                                    <span class="badge {{ $schedule->is_available ? 'bg-success' : 'bg-danger' }} me-1">
                                        @if($schedule->is_available)
                                            Jadwal bisa dipakai
                                        @else
                                            Jadwal telah terpakai
                                        @endif
</span>

                                </td>
                                <td class="text-end">
                                        <span class="dropdown">
                                          <button class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport" data-bs-toggle="dropdown">Actions</button>
                                          <div class="dropdown-menu dropdown-menu-end">
                                              <a id="delete" class="dropdown-item" data-id="{{$schedule->id}}">Delete</a>
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

            {{--$('#delete').click(function(){--}}
            {{--    var appointmentId = $(this).data('id')--}}
            {{--    if(confirm('Are you sure wanto delete this appointment?')){--}}
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



