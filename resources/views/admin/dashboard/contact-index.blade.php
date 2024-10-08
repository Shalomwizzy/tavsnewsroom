@extends('layouts.admin')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        @foreach ($messages as $message)
        <div class="col-sm-12 col-md-6 col-xl-4 mb-4">
            <div class="h-100 bg-dark rounded p-4">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <h6 class="mb-0">{{ $message->name }}</h6>
                    <small>{{ $message->created_at->diffForHumans() }}</small>
                </div>
                <div>
                    <span>{{ $message->message }}</span>
                </div>
                <div>
                    <button class="btn btn-primary mt-2" onclick="toggleReplyForm({{ $message->id }})">Reply</button>
                    <div id="reply-form-{{ $message->id }}" class="reply-form mt-2" style="display: none;">
                        <form action="{{ route('contact.reply', $message->id) }}" method="POST">
                            @csrf
                            <textarea name="reply" class="form-control mb-2" placeholder="Reply to this message"></textarea>
                            <button class="btn btn-primary" type="submit">Send Reply</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<script>
    function toggleReplyForm(messageId) {
        var replyForm = document.getElementById('reply-form-' + messageId);
        if (replyForm.style.display === "none") {
            replyForm.style.display = "block";
        } else {
            replyForm.style.display = "none";
        }
    }
</script>
@endsection

