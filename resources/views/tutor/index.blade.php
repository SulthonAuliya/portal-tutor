@extends('layouts.app')

@section('content')
    <div class="container mb-5 mt-5">
        <div class="card card-table p-3 shadow mb-5 bg-body rounded">
            <h1 class="text-center fw-bold">Manage Tutoring Session</h1>
            <div class="row">
                <div class="col-12">
                    
                </div>
                <div class="col-12 mt-3">
                    <div class="table-container">
                        <table id="datatable" class="table table-striped nowrap" style="width: 100%">
                            <thead>
                                
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Title</th>
                                    <th class="text-center">Invitation Code</th>
                                    <th class="text-center">Created Date</th>
                                    <th class="text-center">Start date</th>
                                    <th class="text-center">End Date</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($tutors) > 0)  
                                @foreach ($tutors as $tutor)  
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $tutor->post->title }}</td>
                                    <td class="text-center"><span class="fw-bolder" style="color: #5D8BFF; letter-spacing: 2px">{{ $tutor->invitation_code}}</span></td>
                                    <td class="text-center">{{ $tutor->created_at->format('d/m/Y')}}</td>
                                    <td class="text-center">{{ $tutor->start_time ? $tutor->start_time->format('d/m/Y') : '-' }}</td>
                                    <td class="text-center">{{ $tutor->end_time ? $tutor->end_time->format('d/m/Y') : '-' }}</td>
                                    <td class="text-center">
                                        @if ($tutor->status === 0)
                                        <span class="badge bg-secondary p-2 font-monospace" style="letter-spacing: 2px">Belum Mulai</span>
                                        @elseif ($tutor->status === 1)
                                        <span class="badge bg-primary p-2 font-monospace" style="letter-spacing: 2px">Sedang berjalan</span>
                                        @elseif ($tutor->status === 2)
                                        <span class="badge bg-success p-2 font-monospace" style="letter-spacing: 2px">Selesai</span>
                                        @elseif ($tutor->status === 3)
                                        <span class="badge bg-danger p-2 font-monospace" style="letter-spacing: 2px">Dibatalkan</span>
                                        @endif
                                    </td>
                                    
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <button class="btn btn-primary " type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fa fa-ellipsis-v"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-hover" aria-labelledby="dropdownMenuButton">
                                                <li><a class="dropdown-item" href="{{route('tutor.detail', $tutor->id)}}">Detail</a></li>
                                                @if (Auth::user()->role === 'Tutor')
                                                <li><a class="dropdown-item" href="#">Batalkan</a></li>
                                                <li><a class="dropdown-item" href="#">Delete</a></li>
                                                @endif
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="8" class="text-center">Belum ada data tutoring session!</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('addon-script')
<script>
    @if (count($tutors) > 0)
        $('#datatable').DataTable( {
            responsive: true
        } );
    @endif
</script>
@endpush
    