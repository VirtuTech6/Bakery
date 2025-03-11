-- Insertion des commandes
INSERT INTO `order` (id, user_id, date, status, total_amount, payment_method, billing_address) VALUES
(1, 1, '2024-03-20 10:30:00', 'completed', '45.90', 'card', '123 Rue de la Boulangerie, 75001 Paris'),
(2, 2, '2024-03-20 11:15:00', 'processing', '32.50', 'cash', '456 Avenue des Croissants, 75002 Paris'),
(3, 1, '2024-03-20 14:20:00', 'pending', '28.75', 'card', '123 Rue de la Boulangerie, 75001 Paris'),
(4, 3, '2024-03-20 16:45:00', 'completed', '67.25', 'card', '789 Boulevard des Pains, 75003 Paris'),
(5, 2, '2024-03-20 17:30:00', 'processing', '42.80', 'cash', '456 Avenue des Croissants, 75002 Paris');

-- Insertion des produits de commande
INSERT INTO order_product (order_id, product_id, quantity, unit_price) VALUES
(1, 1, 2, 12.95),  -- 2 baguettes
(1, 2, 1, 20.00),  -- 1 pain complet
(2, 3, 3, 8.50),   -- 3 croissants
(2, 4, 1, 7.00),   -- 1 pain au chocolat
(3, 1, 1, 12.95),  -- 1 baguette
(3, 5, 2, 7.90),   -- 2 brioches
(4, 2, 2, 20.00),  -- 2 pains complets
(4, 3, 3, 8.50),   -- 3 croissants
(4, 6, 1, 10.25),  -- 1 pain aux raisins
(5, 1, 2, 12.95),  -- 2 baguettes
(5, 4, 2, 7.00),   -- 2 pains au chocolat
(5, 5, 1, 7.90);   -- 1 brioche 