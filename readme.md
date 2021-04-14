## Repository et Doctrine

Doctrine est un systeme de mapping qui va permettre la correspondance entre PHP et le relationnel (BDD).

recupération des enregistrements de la table:

`Entité = Enregistrement => lignes des tables`

`EntityManager = Manipulation des enregistrements => créer | modifier | supprimer`

`Repository =  faire remonter les enregistrements => Objet dispo dans le projet`

<u>Important :</u> si la fonction est liée à une route on peut se faire livrer le repository sans passer par un constructeur

```php
public function homepage(ProductRepository $producRepository)
{

    $count = $producRepository->count(['price' => 1500]);

    $product = $producRepository->find($id);

    $products = $producRepository->findAll($id);

    // avec des criteres
    $products = $producRepository->findBy([
        'slug' => 'chaise-en-bois',
        'price' => 1500
    ], ['name' => 'DESC']);

    $products = $producRepository->findOneBy([
        'price' => 1500
    ]);
    ...
}
```
### EntityManagerInterface

```php
// Création d'un produit
public function homepage(EntityManagerInterface, $em)
{
    $product = new Product;

    $product->setName('Table en métal')
        ->setPrice(3000)
        ->setSlug('table-en-métal');

    // préparation du produit (on ecrit le SQL)
    $em->persist($product);

    // ecriture en base
    $em->flush();
    ...
}
```
Pour une modification,; il faut se faire livrer le Repository pour pouvoir manipuler l'entité.

```php
public function homepage(EntityManagerInterface $em)
{
    $productRepository = $em->getRepository(Product::class);
    $product = $productRepository->find(3);
    $product->setPrice(2500);

    // entité existante pas de persist
    $em->flush
    ...
    // remove
    $em->remove($product);
    $em->flush();
}
```
### Travailler et naviguer dans les migrations

Voir toutes les commandes sur les migrations possibles :

```bash
bin/console doctrine:migration --help
```
Migration permet de versionner la BDD.


## Composant Form

initialiser un formulaire avec le `FormBuilder`:

```bash
bin/console debug:autowiring --all
```

annonce qu'il est possible d'utiliser le service `Symfony\Component\Form\FormFactoryInterface (form.factory)` en se faisaint liver par injection de dépendance `FormFactoryInterface`

```php
// init form
$builder = $factory->createBuilder();

// config du formulaire 
$builder->add('name')
    ...
    ->add('description');

$form = $builder->getForm();
// de la classe Form on bne récupère que la vue et on le passe a Twig:
$formView = $form->createView();

return $this->render('product/create.html.twig', [
    'formView' => $formView
])

```

### Configurer les champs du formulaire
```bash
bin/console make:form ProductType
```

```php
public function createband(FormFactoryInterface $factory, Request $request, SluggerInterface $slugger, EntitymanagerInterface $em)
{
    ...
    $builder = $factory->createBuilder(FormType::class, null, [
        'data_class'=>Product::class
    ]);

    // add prend 3 parametres: le nom du champ / le type de champ / options du champ
    $builder->add('name', TextAreaType::class, [
        'label'=>'nom du produit',
        'attr' => ['placeholder'=>'nom du produit']
    ])
    ->add('price', MoneyType::class, []);
    ->add('Catégories', EntityType::class, [
        'label'=> 'Categorie',
        'placeholder'=> '-- choisir une catégorie --',
        'class'=> Category::class,
        'choice_label'=> 'name' //possible de travailler encore plus dans le détail (Course -> 3:20) 
    ]);

    $form = $builer->getForm();
    $form->handleRequest($request);

    if($form->isSubmitted()){

        $product = form->getData();
        $product->setSlug(\strtolower($slugger->slug(product->getName())))
        $em->persist($product);
        $em->flush();

    }


    $formView = $form->createView();
}
```

### Twig : Les fonctions de rendu pour les formulaires

```html
{% extends "base.html.twig" %}

{% form_theme forView 'bootstrap_4_layout.html.twig' %}


{{form_theme formView _self}}

{{ form_start(formView) }}

{{ form_errors(formView) }}

{{ form_row(formView.name) }}

<button type="submit" class="btn btn-primary">
    <i class="fas fas-save"></i>
</button>
<!-- 
theme de form livrés avec symfony

 -->

{{ form_end(formView)}}
<!-- appelé a chaque for_row -->
{% block form_row %}
    <div class="form-group">
        {{ form_label(form) }}
        {{ form_widget(form, {'attr': {'class':'form-control'} }) }}
        {{ form_help(form) }}
        {{ form_errors(form) }}
    </div>
{% endblock %}
```
### Modifier une entité

Faire une fonction liée a une route
```php
/**
 * @Route("/admin/{id}/edit", name="band_editBand")
 */
public function editProduct($id, ProductRepository $productRepository)
{
    //  récupération du produit avec le repository correspondant
    $product = $productRepository->find($id)

    return->$this->render('product/edit.html.twig', [
        'product'=> $product;
    ])
}
```
Même procédé que la création : on build un formulaire directement sur le ProductType :
```php
public function editProduct($id, ProductRepository $productRepository)
{
    //  récupération du produit avec le repository correspondant
    $product = $productRepository->find($id)

    // soit passer l'élémént à modifier en deuxieme param de createForm()
    // soit $form->setData($product)
    $form = $this->createForm(ProductType::class, $product);
    // $form->setData($product);

    // inspection de la requete
    $form->handleRquest($request);
    // gestion des modifications
    if($form->isSubmitted() && $form->isValid()){
        // le formulaire travaille deja sur l'objet passé en parametre plus haut
        // pad besoin de getData() 
        // $product = $form->getData();

        // pas de persit car il exiqte deja dans la bdd
        $em->flush();
    }

    $formView = $form->createView();

    return->$this->render('product/edit.html.twig', [
        'product'=> $product;
        'formView'=>$formView
    ])
}
```
📖 Vraiment comprendre les Voters