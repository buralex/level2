<?php foreach ($items as $item): ?>
	<h1><?php echo $item->id; ?></h1>
	<img src="<?= "/img/" . $item->path; ?>" alt="<?php echo $item->title; ?>" style="max-width: 200px;">
<?php endforeach; ?>

<form action="<?= "/images/addOne"; ?>" method="post" enctype="multipart/form-data">
    <label for="title">Caption </label>
    <input type="text" id="title" name="title" required>

    <label for="path">image</label>
    <input type="file" id="path" name="path" required>

    <input type="submit">
</form>





