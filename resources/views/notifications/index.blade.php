@extends('layouts.app')
@section('title','Notifications')
@section('page-title','Notifications')

@section('content')
<div class="page-header">
  <div class="page-header-left">
    <div class="breadcrumb"><a href="{{ route('dashboard') }}">Home</a><span>/</span><span>Notifications</span></div>
    <h1 class="page-title">Notifications</h1>
    <p class="page-subtitle">{{ auth()->user()->unreadNotifications()->count() }} unread</p>
  </div>
  @if(auth()->user()->unreadNotifications()->count() > 0)
  <form method="POST" action="{{ route('notifications.readAll') }}">
    @csrf
    <button type="submit" class="btn btn-outline"><i class="fas fa-check-double"></i> Mark All Read</button>
  </form>
  @endif
</div>

<div class="card">
  @forelse($notifications as $notif)
  <div class="notification-item {{ !$notif->is_read ? 'unread' : '' }}">
    <div class="notification-icon {{ $notif->type }}"><i class="fas {{ $notif->icon ?? 'fa-bell' }}"></i></div>
    <div style="flex:1;">
      <div class="notification-title">{{ $notif->title }}</div>
      <div class="notification-text">{{ $notif->message }}</div>
      <div class="notification-time"><i class="fas fa-clock" style="margin-right:4px;"></i>{{ $notif->created_at->diffForHumans() }}</div>
    </div>
    @if(!$notif->is_read)
    <form method="POST" action="{{ route('notifications.read', $notif->id) }}">
      @csrf
      <button type="submit" class="btn btn-ghost btn-icon btn-sm" title="Mark as read"><i class="fas fa-check" style="color:var(--success);"></i></button>
    </form>
    @endif
    @if($notif->action_url)
    <a href="{{ $notif->action_url }}" class="btn btn-outline btn-sm">View</a>
    @endif
  </div>
  @empty
  <div class="empty-state"><div class="empty-state-icon"><i class="fas fa-bell-slash"></i></div><h3>No notifications</h3><p>You're all caught up!</p></div>
  @endforelse
  @if($notifications->hasPages())
  <div class="card-footer">{{ $notifications->links() }}</div>
  @endif
</div>
@endsection
