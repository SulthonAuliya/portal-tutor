@extends('layouts.app')

@section('content')
    <div class="container mb-5 mt-5">
        <div class="card card-table p-3 shadow mb-5 bg-body rounded pt-4">
            <h1 class="text-center fw-bold text-primary" style="text-shadow: 1px 1px 3px #489dff9f !important">All Notifications of {{$user->full_name}}</h1>
            <div class="row">
                <div class="col-12">
                    
                </div>
                <div class="col-12 mt-3">
                    <div class="row" id="notif-list">
                        @foreach ($notifications as $notif)
                            <div class="col-12 mt-3" >
                                <a href="{{$notif->data['url']}}" data-notification-id="{{$notif->id}}" class="text-decoration-none list-notif">
                                    <div class="card p-4 card-notif @if ($notif->read_at !== null) read @endif">
                                        <h5 class="">{{ $notif->data['message' ]}}</h5>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        
    </div>
@endsection
@push('addon-script')
<script>
       $('#notif-list').on('click', 'a.list-notif', function(event) {
            event.preventDefault(); // Prevent immediate navigation
            var notificationUrl = $(this).attr('href'); // Get the URL to redirect to
            var notificationId = $(this).data('notification-id'); // Get the notification ID

            // Mark the notification as read and then redirect
            markNotificationAsRead(notificationId, notificationUrl);
        });

        function markNotificationAsRead(notificationId, redirectUrl) {
                $.ajax({
                    url: '{{ route("ajax.read-notif" ) }}', // Endpoint to mark notification as read
                    type: 'POST', // Use POST method for state-changing operations
                    data: {
                        _token: '{{ csrf_token() }}',
                        notif: notificationId // Include CSRF token for security
                    },
                    success: function(response) {
                        // Redirect to the specified URL after the notification is marked as read
                        window.location.href = redirectUrl; 
                    },
                    error: function(xhr, status, error) {
                        console.error("Error marking notification as read:", error);
                        // In case of an error, you can still redirect to avoid user confusion
                        window.location.href = redirectUrl;
                    }
                });
            }
</script>
@endpush
    