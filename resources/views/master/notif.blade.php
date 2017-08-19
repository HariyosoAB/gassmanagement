@if(isset($notif[0]))
  @foreach($notif as $notf)
  <li><?php echo date_format(date_create($notf->notification_timestamp), 'jS F g:ia '); ?> -- {{$notf->notification_text}}</li>
  @endforeach
@else
  <li>There are no New Notification</li>
@endif
