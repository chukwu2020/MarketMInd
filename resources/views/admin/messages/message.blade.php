<strong>
    {{ $message->user->name ?? $message->guest_name ?? 'Unknown' }}
</strong>
<small class="text-muted">
    {{ $message->user->email ?? $message->guest_email ?? '' }}
</small>

<!-- Display Messages -->

@foreach ($messages as $message)
    <div class="card mb-2">
        <div class="card-body">
            <strong>{{ $message->user->name ?? $message->guest_name ?? 'Unknown' }}</strong>
            <small class="text-muted">{{ $message->user->email ?? $message->guest_email ?? '' }}</small>

            <p class="mt-2">{{ $message->content }}</p>
            <small>{{ $message->created_at->diffForHumans() }}</small>

            @if($message->response)
                <div class="mt-2 p-2 bg-light border">
                    <strong>Admin Reply:</strong>
                    <p>{{ $message->response }}</p>
                </div>
            @elseif(auth()->user()->is_admin)
                <form method="POST" action="{{ route('messages.respond', $message->id) }}">
                    @csrf
                    @method('PATCH')
                    <textarea name="response" class="form-control" placeholder="Type your reply..." required></textarea>
                    <button class="btn btn-sm btn-success mt-1">Send Reply</button>
                </form>
            @endif
        </div>
    </div>
@endforeach

