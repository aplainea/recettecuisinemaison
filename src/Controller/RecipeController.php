<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Recipe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecipeController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $recipesEntree = $em->getRepository(Recipe::class)->find3RecipeByCategory("Entrée");
        $recipesPlat = $em->getRepository(Recipe::class)->find3RecipeByCategory("Plat");
        $recipesDessert = $em->getRepository(Recipe::class)->find3RecipeByCategory("Dessert");
        return $this->render('recipe/index.html.twig', [
            'recipesEntree' => $recipesEntree,
            'recipesPlat' => $recipesPlat,
            'recipesDessert' => $recipesDessert,
        ]);
    }

    /**
     * @Route("/recettes", name="recipespage")
     */
    public function showRecipes(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $recipes = $em->getRepository(Recipe::class)->findAll();
        return $this->render('recipe/recipes.html.twig', [
            'recipes' => $recipes
        ]);
    }

    /**
     * @Route("/recettes/categorie/{name}", name="recipesbycategory")
     */
    public function showRecipesByCategory(Category $category): Response
    {
        $em = $this->getDoctrine()->getManager();
        $recipesByCategory = $em->getRepository(Recipe::class)->findRecipeByCategory($category->getName());
        return $this->render('recipe/recipesbycategory.html.twig', [
            'recipesByCategory' => $recipesByCategory,
            'categoryName' => $category->getName()
        ]);
    }

    /**
     * @Route("/recettes/{slug}", name="recipepage")
     */
    public function showRecipe(Recipe $recipe): Response
    {
        return $this->render('recipe/recipe.html.twig', [
            'recipe' => $recipe
        ]);
    }
}
