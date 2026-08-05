<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="style.css" />

</head>

<body>

<div class="container">

<p class="intro">
<h1>Unofficial Convenience Card </h1>

This is a laminated, pocket-sized copy of your enrollment certificate. It is <em>not</em> issued by Utrecht University and is <em>not</em>not a university ID card.

However, in accordance with Utrecht University's policy, it may be used to demonstrate your student status when accessing university buildings, provided that an enrollment certificate is accepted for that purpose.

</p>

<form method="post" action="send_order.php">

<label>
Your name
<input name="name" autocomplete="name" required>
</label>

<label>
Email
<input 
    type="email"
    name="email"
    autocomplete="email"
    required
>
</label>

<!-- Drop a PDF of your enrollment certificate here --> 

</form>

</div>

</body>
</html>