
<!DOCTYPE html>
<html>
<head>
    <title>New Comment on Your Post</title>
</head>
<body>
    <h1>New Comment on Your Post</h1>
    <p>Hello {{ $post->user->name }},</p>
    <p>Someone has commented on your post titled "{{ $post->title }}".</p>
    <p>Comment:</p>
    <p>{{ $comment->content }}</p>
    <p>Thank you,</p>
    <p>{{ config('app.name') }}</p>
</body>
</html>



