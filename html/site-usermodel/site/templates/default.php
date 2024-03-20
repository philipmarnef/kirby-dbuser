<!DOCTYPE html>
<html lang="<?= $kirby->languageCode() ?? 'en' ?>">
<head>

	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>


<body>
	<h1><?= $page->title() ?></h1>

	<main>
		<?= $page->text()->or('') ?>
	</main>

</body>

</html>
