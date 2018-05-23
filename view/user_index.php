<article class="hreview open special">
	<?php if (empty($haushalte)): ?>
		<div class="dhd">
			<h2 class="item title">Hoopla! Keine User gefunden.</h2>
		</div>
	<?php else: ?>
		<?php foreach ($haushalte as $haushalt): ?>
			<div class="panel panel-default">
				<div class="panel-heading"><?= $haushalt->name;?> <?= $haushalt->email;?> <?= $haushalt->password;?></div>
				<div class="panel-body">
					<p class="description">In der Datenbank existiert ein User mit dem Namen <?= $haushalt->name;?>. Dieser hat die EMail-Adresse: <a href="mailto:<?= $haushalt->email;?>"><?= $haushalt->email;?></a></p>
					<p>
						<a title="Löschen" href="/user/delete?id=<?= $haushalt->id ?>">Löschen</a>
					</p>
				</div>
			</div>
		<?php endforeach ?>
	<?php endif ?>
</article>
