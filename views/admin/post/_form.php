<form action="" method="POST" >
    <?= $form->input('name', 'Titre') ?>
    <?= $form->input('slug', 'URL') ?>
    <?= $form->textarea('content', 'Contenu') ?>
    <?= $form->textarea('created_at', 'Date de création') ?>

    <button class="btn btn-primary">
        <?php if ($post->getID() !== null) : ?>
            Modifer
        <?php else : ?>
            Créer
        <?php endif ?>
    </button>
</form>