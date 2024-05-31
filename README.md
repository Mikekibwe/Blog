## Objectif 

Créer un blog aveec un système de catégorie 

-Page listing d'article(Pagination)
-Page listing d'article pour une categorie(Pagination)
-Page presentation d'un article
-Administration des categorie
-Administration des articcles


  et mon fichier edit.php :<?php 
use App\Connection;
use App\ObjectHelper;
use App\Table\CategoryTable;
use App\Table\PostTable;
use App\HTML\Form;
use App\Validators\PostValidator;
use App\Auth;

Auth::check();

$pdo = Connection::getPDO();
$postTable = new PostTable($pdo);
$categoryTable = new CategoryTable($pdo);
$categories = $categoryTable->list();
$post = $postTable->find($params['id']);
$categoryTable->hydratePosts([$post]);
$success = false;

$errors = [];

if (!empty($_POST)) {
    $v = new PostValidator($_POST, $postTable, $post->getID(), $categories);
    ObjectHelper::hydrate($post, $_POST, ['name', 'content', 'slug', 'created_at']);
    if ($v->validate()) {
        $pdo->beginTransaction();
        $postTable->updatePost($post);
        $postTable->attachCategories($post->getID(), $_POST['categories_ids']);
        $pdo->commit();
        $categoryTable->hydratePosts([$post]);
        $success = true;
    } else {
        $errors = $v->errors();
    }
}
$form = new Form($post,$errors);
?>

<?php if ($success): ?>
    <div class="alert alert-success">
        L'article a bien été modifié
    </div>
<?php endif ?>
<?php if (isset($_GET['created'])): ?>
    <div class="alert alert-success">
        L'article a bien été créé
    </div>
<?php endif ?>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        L'article n'a pas pu etre modifier, merci de corriger vos ereurs
    </div>
<?php endif ?>

<h1>Editer l'article <?= e($post->getName()) ?></h1>

<?php require('_form.php') ?>        en executant edit.php dans le navigateur, j'ai l'erreur suivante:App\Table\PostTable::attachCategories(): Argument #2 ($categories) must be of type array, string given, called in C:\xampp\htdocs\Cours\Grafikart POO\Blog\views\admin\post\edit.php on line 28