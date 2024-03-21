<!DOCTYPE html>
<html lang="<?= $kirby->languageCode() ?? 'en' ?>">
<head>

	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>


<body>
	<h1><?= $page->title() ?></h1>

	<main>
		Kirby has: <?= kirby()->users()->count() ?> users.
		<?php if($kirby->user()): ?>
			<?= $kirby->user()->email() ?>
			<a href="/panel/logout">Logout</a>
		<?php else: ?>
			<a href="/panel/login">Login</a>
		<?php endif; ?>
	</main>

</body>

</html>
