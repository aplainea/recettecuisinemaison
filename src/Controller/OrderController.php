<?php

namespace App\Controller;

use App\Entity\Order;
use App\Repository\RecipeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    /**
     * @Route("/panier", name="panier")
     */
    public function index(SessionInterface $session, RecipeRepository $recipeRepository): Response
    {
        $panier = $session->get('panier', []);
        $panierData = [];

        foreach ($panier as $idOnpanier => $id){
            $panierData[] = [
                'recette' => $recipeRepository->find($id),
            ];
        }

        $total = 0;
        foreach ($panierData as $item) {
            $totalItem = $item['recette']->getPrice();
            $total += $totalItem;
        }

        return $this->render('order/index.html.twig', [
            'items' => $panierData,
            'total' => $total
        ]);
    }

    /**
     * @Route("/panier/add/{id}", name="panier_add")
     */
    public function addItem($id, SessionInterface $session): Response
    {
        $panier = $session->get('panier', []);

        $panier[$id] = $id;

        $session->set('panier', $panier);

        return $this->redirectToRoute('panier');
    }

    /**
     * @Route("/panier/remove/{id}", name="panier_remove")
     */
    public function remove($id, SessionInterface $session) {
        $panier = $session->get('panier', []);

        if (!empty($panier[$id])) {
            unset($panier[$id]);
        }

        $session->set('panier', $panier);

        return $this->redirectToRoute("panier");
    }

    /**
     * @Route("/commandes", name="orderspage")
     */
    public function showOrders(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $orders = $em->getRepository(Order::class)->findByUser($user = $this->getUser());
        return $this->render('order/orders.html.twig', [
            'orders' => $orders
        ]);
    }

    /**
     * @Route("/panier/validation", name="panier_confirm")
     */
    public function confirm(SessionInterface $session, RecipeRepository $recipeRepository): Response
    {

        $panier = $session->get('panier', []);

        foreach ($panier as $idOnpanier => $id){
            $panierData[] = [
                'recette' => $recipeRepository->find($id),
            ];
        }

        foreach ($panierData as $item) {
            $em = $this->getDoctrine()->getManager();

            // Add order
            $order = new Order();
            $order->setDate(new \DateTime('now'));
            $order->setUser($user = $this->getUser());
            $order->setRecipe($item['recette']);

            $em->persist($order);
            $em->flush();

            // Delete item on session
            foreach ($panier as $idOnpanier => $id) {
                if (!empty($panier[$id])) {
                    unset($panier[$id]);
                }
            }
            $session->set('panier', $panier);
        }

        return $this->redirectToRoute("orderspage");
    }

}
