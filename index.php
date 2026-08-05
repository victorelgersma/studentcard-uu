<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="style.css" />

<title>Reserve your martenitsi</title>

</head>

<body>

<div class="container">

<h1>Reserve your martenitsi</h1>

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

<label>
Amount
<select name="amount">
    <option value="1">1 martenitsa</option>
    <option value="2">2 martenitsas</option>
    <option value="5">5 martenitsas</option>
    <option value="10">10 martenitsas</option>
    <option value="20">20 martenitsas</option>
</select>
</label>

<label>
Message
<textarea 
    name="message"
    rows="5"
    placeholder="Any questions or special requests?"
></textarea>
</label>

<button type="submit">
Reserve yours
</button>

</form>

</div>

</body>
</html>