<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield("title", "Explain Hub")</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/css/normalize.css">
  <link rel="stylesheet" href="/css/style.css">
  <link rel="stylesheet" href="/css/packages/users/auth.css">
  <link rel="stylesheet" href="/css/packages/users/profile.css">
  <link rel="stylesheet" href="/css/packages/questions/modal.css">
  <link rel="stylesheet" href="/css/packages/questions/questions.css">
  <link rel="stylesheet" href="/css/packages/questions/question-card.css">
  <link rel="stylesheet" href="/css/packages/questions/question.css">
  <link rel="stylesheet" href="/css/packages/questions/status.css">
  <link rel="stylesheet" href="/css/packages/questions/tags.css">
  <link rel="stylesheet" href="/css/packages/questions/like-button.css">
  <link rel="stylesheet" href="/css/packages/questions/metrics.css">
  <link rel="stylesheet" href="/css/packages/questions/answers.css">
  <link rel="stylesheet" href="/css/packages/questions/answer-card.css">
  @if(request()->is('admin*'))
    <link rel="stylesheet" href="/css/packages/admin/admin.css">
  @endif
</head>
<body>
  @yield("content")
</body>
</html>
