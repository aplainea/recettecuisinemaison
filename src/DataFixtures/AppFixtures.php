<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Recipe;
use App\Entity\User;
use App\Repository\CategoryRepository;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;
    private $category;
    private $user;


    public function __construct(UserPasswordEncoderInterface $encoder, CategoryRepository $category, UserRepository $user)
    {
        $this->encoder = $encoder;
        $this->category = $category;
        $this->user = $user;
    }

    public function load(ObjectManager $manager)
    {
        // Users
        $userType = ['admin', 'user'];
        foreach ($userType as $oneuser) {
            $user = new User();
            $user->setPseudo("$oneuser");
            $user->setName("$oneuser");
            $user->setFirstname("$oneuser");
            $user->setPassword($this->encoder->encodePassword($user, "$oneuser"));
            $user->setEmail("$oneuser@$oneuser.fr");
            $user->setAvatar("/img/avatar/$oneuser.png");
            $user->setUpdated(new \DateTime());
            $user->setRoles(['ROLE_'.strtoupper($oneuser)]);
            $users[]=$user;
            $manager->persist($user);
        }

        // Categories
        $catName = ['Entrée', 'Plat', 'Dessert'];
        foreach ($catName as $name) {
            $category = new Category();
            $category->setName($name);
            $categories[]=$category;
            $manager->persist($category);
        }

        // Recipes
        $recipes = array( // quelques vraies recettes (maison)
            array('name' => "Roulées au chorizo", 'description' => "A servir plutôt pour un apéro amélioré", 'ingredient' => "Un chorizo entier, 150 g de gruyère rapé, 1 oeuf, 1 pâte feuilletée préparer", 'nbperson' => 5, 'preparationtime' => "1 heure environ", 'price' => 20, 'picture' => "roulées_au_chorizo.jpg", 'category' => 1),
            array('name' => "Samoussas aux légumes", 'description' => "C'est bon pour le moral", 'ingredient' => "1 roule de feuilles  brics, 1 courgette, 2 carrotes, 50g de saint Moret", "3 courgettes, environ 50g de sauces tomates, 50g de gruyère râpé, 60g de lardon", 'nbperson' => 5, 'preparationtime' => "45 minutes environ", 'price' => 15, 'picture' => "samoussas_aux_légumes.jpg", 'category' => 1),
            array('name' => "Courgettes farcie", 'description' => "Comment faire manger de la courgette à vos enfants", 'ingredient' => "3 courgettes, environ 50g de sauces tomates, 50g de gruyère râpé, 60g de lardon", 'nbperson' => 6, 'preparationtime' => "1h30", 'price' => 40, 'picture' => "courgettes_farcies.jpg", 'category' => 2),
            array('name' => "Salade de thon", 'description' => "Une bonne petite salade", 'ingredient' => "200g de thon, 100g de maïs, 2 avocats, quelques tomates cerises", 'nbperson' => 2, 'preparationtime' => "20 minutes", 'price' => 10, 'picture' => "salade_de_thon.jpg", 'category' => 1),
            array('name' => "Dessert gourmand", 'description' => "Vous ne pourrez y résister", 'ingredient' => "100g Mascarpone, 50g de spéculoos émincés, 1 barquette de fraises", 'nbperson' => 1, 'preparationtime' => "30 minutes", 'price' => 15, 'picture' => "dessert_gourmand.jpg", 'category' => 3),
            array('name' => "Sablés aux pepites de chocolat", 'description' => "Croquant à l’extérieur moelleux à l’intérieur", 'ingredient' => "700g de farine, 325g de sucre, 325g de beurre fondu, 3 oeufs, 80g de pépites de chocolat", 'nbperson' => 20, 'preparationtime' => "3 heures", 'price' => 50, 'picture' => "sablés_aux_pepites_de_chocolat.jpg", 'category' => 3),
            array('name' => "Salade verte", 'description' => "Que du vert dans votre salade (ou presque)", 'ingredient' => "180g de riz, 100g d'olive verte, 100g de feta, 3 avocats, quelques tomates cerises", 'nbperson' => 2, 'preparationtime' => "20 minutes", 'price' => 10, 'picture' => "salade_verte.jpg", 'category' => 1),
            array('name' => "Tarte légumes", 'description' => "Plein de bons légumes", 'ingredient' => "1 pâte feuilletée préparer, 1 courgettes, 1 carotte, 1 poivron rouge, 1 aubergine, 1/4 d'oignon rouge, 50cl de crème liquide, 50g de gruyère rapé, sel poivre curry", 'nbperson' => 8, 'preparationtime' => "2 heure", 'price' => 30, 'picture' => "tarte_légumes.jpg", 'category' => 2),
            array('name' => "Poulet farcies et pomme de terre salardaise", 'description' => "Vous ne mangerez plus du poulet de la même manière", 'ingredient' => "5 escalope de poulet, 100g de tomates séchées, 100g de mozzarella, quelques feuilles de basilic, 1kg de patates, 1cas d'huile d'olives, sel poivre persil", 'nbperson' => 5, 'preparationtime' => "2h30", 'price' => 50, 'picture' => "poulet_farcies_et_pommes_de_terre_salardaise.jpg", 'category' => 2),
            array('name' => "Smoothie mangue", 'description' => "Une boisson dessert avec plein de bon fruit, en terrasse", 'ingredient' => "1 banane, 1 pomme, 1 mangue, 30cl d'orange pressé, 10 cl de citron pressé", 'nbperson' => 1, 'preparationtime' => "15 minutes", 'price' => 10, 'picture' => "smoothie_mangue.jpg", 'category' => 3),
            array('name' => "Salade exotique", 'description' => "Un plat pitaya maison", 'ingredient' => "240g de riz, 600g de crevettes au curry, 3 carraotes rapé, 1 poivron rouge, 1 poivron vert, quelques tomates cerises", 'nbperson' => 4, 'preparationtime' => "1 heure", 'price' => 30, 'picture' => "salade_exotique.jpg", 'category' => 2),
        );


        function stringToSlug($chaine) { // Transforme le nom de la recette en slug (lien url)
            $chaine = trim($chaine);
            $chaine = strtr($chaine,
                "ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ",
                "aaaaaaaaaaaaooooooooooooeeeeeeeecciiiiiiiiuuuuuuuuynn");
            $chaine = strtr($chaine,"ABCDEFGHIJKLMNOPQRSTUVWXYZ","abcdefghijklmnopqrstuvwxyz");
            $chaine = preg_replace('#([^.a-z0-9]+)#i', '-', $chaine);
            $chaine = preg_replace('#-{2,}#','-',$chaine);
            $chaine = preg_replace('#-$#','',$chaine);
            $chaine = preg_replace('#^-#','',$chaine);
            return $chaine;
        }


        foreach ($recipes as $recipe) {
            $rec = new Recipe();
            $rec->setName($recipe['name']);
            $rec->setSlug(stringToSlug($recipe['name']));
            $rec->setDescription($recipe['description']);
            $rec->setIngredient($recipe['ingredient']);
            $rec->setNbperson($recipe['nbperson']);
            $rec->setPreparationtime($recipe['preparationtime']);
            $rec->setPrice($recipe['price']);
            $rec->setPicture($recipe['picture']);
            $rec->setUpdated(new \DateTime('now'));
            $rec->setCategory($categories[$recipe['category']-1]);
            $rec->setUser($users[0]); // user: ADMIN

            $manager->persist($rec);

        }

        $manager->flush();
    }
}
