<form action="" method="POST" >
    <?= $form->input('name', 'Titre') ?>
    <?= $form->input('slug', 'URL') ?>
    <button class="btn btn-primary">
        <?php if ($item->getID() !== null) : ?>
            Modifer
        <?php else : ?>
            Créer
        <?php endif ?>
    </button>
</form>