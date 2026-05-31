@php
    $isAdmin = auth()->check() && auth()->user()->role === 'admin';
@endphp

@if($isAdmin)
    @include('notifications.admin_index')
@else
    @include('notifications.user_index')
@endif
