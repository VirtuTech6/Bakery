<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderProduct;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/orders')]
class OrderController extends AbstractController
{
    #[Route('', name: 'order_list', methods: ['GET'])]
    public function index(OrderRepository $orderRepository): JsonResponse
    {
        $orders = $orderRepository->findAll();
        $data = [];
        
        foreach ($orders as $order) {
            $data[] = [
                'id' => $order->getId(),
                'totalAmount' => $order->getTotalAmount(),
                'status' => $order->getStatus(),
                'date' => $order->getDate()->format('Y-m-d H:i:s'),
                'paymentMethod' => $order->getPaymentMethod(),
                'billingAddress' => $order->getBillingAddress(),
            ];
        }
        
        return $this->json($data);
    }

    #[Route('/{id}', name: 'order_show', methods: ['GET'])]
    public function show(Order $order): JsonResponse
    {
        $orderItems = [];
        foreach ($order->getOrderProducts() as $item) {
            $orderItems[] = [
                'id' => $item->getId(),
                'product' => [
                    'id' => $item->getProduct()->getId(),
                    'name' => $item->getProduct()->getName(),
                    'price' => $item->getProduct()->getPrice(),
                ],
                'quantity' => $item->getQuantity(),
                'price' => $item->getProduct()->getPrice() * $item->getQuantity(),
            ];
        }

        return $this->json([
            'id' => $order->getId(),
            'totalAmount' => $order->getTotalAmount(),
            'status' => $order->getStatus(),
            'date' => $order->getDate()->format('Y-m-d H:i:s'),
            'paymentMethod' => $order->getPaymentMethod(),
            'billingAddress' => $order->getBillingAddress(),
            'items' => $orderItems,
        ]);
    }

    #[Route('', name: 'order_create', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        
        $order = new Order();
        $order->setStatus($data['status'] ?? 'pending');
        $order->setTotalAmount($data['totalAmount'] ?? 0);
        $order->setPaymentMethod($data['paymentMethod'] ?? '');
        $order->setBillingAddress($data['billingAddress'] ?? '');
        
        $entityManager->persist($order);
        $entityManager->flush();
        
        return $this->json([
            'id' => $order->getId(),
            'message' => 'Commande créée avec succès'
        ], 201);
    }

    #[Route('/{id}', name: 'order_update', methods: ['PUT'])]
    public function update(Request $request, Order $order, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        
        if (isset($data['status'])) {
            $order->setStatus($data['status']);
        }
        
        if (isset($data['totalAmount'])) {
            $order->setTotalAmount($data['totalAmount']);
        }

        if (isset($data['paymentMethod'])) {
            $order->setPaymentMethod($data['paymentMethod']);
        }

        if (isset($data['billingAddress'])) {
            $order->setBillingAddress($data['billingAddress']);
        }

        if (isset($data['items'])) {
            // Supprimer les anciens OrderProducts
            foreach ($order->getOrderProducts() as $orderProduct) {
                $entityManager->remove($orderProduct);
            }
            $order->getOrderProducts()->clear();

            // Ajouter les nouveaux OrderProducts
            foreach ($data['items'] as $itemData) {
                $product = $entityManager->getReference('App\Entity\Product', $itemData['productId']);
                $orderProduct = new OrderProduct();
                $orderProduct->setOrder($order);
                $orderProduct->setProduct($product);
                $orderProduct->setQuantity($itemData['quantity']);
                $orderProduct->setUnitPrice($product->getPrice());
                $order->addOrderProduct($orderProduct);
                $entityManager->persist($orderProduct);
            }
        }
        
        $entityManager->flush();
        
        return $this->json([
            'message' => 'Commande mise à jour avec succès'
        ]);
    }

    #[Route('/{id}', name: 'order_delete', methods: ['DELETE'])]
    public function delete(Order $order, EntityManagerInterface $entityManager): JsonResponse
    {
        $entityManager->remove($order);
        $entityManager->flush();
        
        return $this->json([
            'message' => 'Commande supprimée avec succès'
        ]);
    }

    #[Route('/customer/{customerId}', name: 'order_by_customer', methods: ['GET'])]
    public function getOrdersByCustomer(int $customerId, OrderRepository $orderRepository): JsonResponse
    {
        $orders = $orderRepository->findBy(['user' => $customerId]);
        $data = [];
        
        foreach ($orders as $order) {
            $data[] = [
                'id' => $order->getId(),
                'totalAmount' => $order->getTotalAmount(),
                'status' => $order->getStatus(),
                'date' => $order->getDate()->format('Y-m-d H:i:s'),
                'paymentMethod' => $order->getPaymentMethod(),
                'billingAddress' => $order->getBillingAddress(),
            ];
        }
        
        return $this->json($data);
    }

    #[Route('/by-date/{date}', name: 'products_by_date', methods: ['GET'])]
    public function getProductsByDate(string $date, OrderRepository $orderRepository): JsonResponse
    {
        try {
            // Convertir la date reçue en objet DateTime
            $searchDate = new \DateTime($date);
            
            // Utiliser la nouvelle méthode du repository
            $orders = $orderRepository->findByDate($searchDate);

            $productsData = [];
            
            // Parcourir toutes les commandes et leurs produits
            foreach ($orders as $order) {
                foreach ($order->getOrderProducts() as $orderProduct) {
                    $product = $orderProduct->getProduct();
                    $productId = $product->getId();
                    
                    // Si le produit n'existe pas encore dans notre tableau, l'initialiser
                    if (!isset($productsData[$productId])) {
                        $productsData[$productId] = [
                            'id' => $productId,
                            'name' => $product->getName(),
                            'totalQuantity' => 0,
                            'totalAmount' => 0
                        ];
                    }
                    
                    // Mettre à jour les totaux pour ce produit
                    $productsData[$productId]['totalQuantity'] += $orderProduct->getQuantity();
                    $productsData[$productId]['totalAmount'] += $orderProduct->getQuantity() * $orderProduct->getUnitPrice();
                }
            }
            
            return $this->json(array_values($productsData));
        } catch (\Exception $e) {
            return $this->json([
                'error' => 'Erreur lors de la récupération des produits: ' . $e->getMessage()
            ], 400);
        }
    }
} 
