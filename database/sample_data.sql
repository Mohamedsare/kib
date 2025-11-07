-- Données de démonstration pour KIB

USE kib_db;

-- Ajouter des catégories supplémentaires si elles n'existent pas déjà
INSERT IGNORE INTO categories (name, slug) VALUES
('T-shirts', 't-shirts'),
('Sacs', 'sacs');

-- Ajouter des services de démonstration
INSERT INTO services (title, slug, description, price_base, category_id, active) VALUES
('Maillots de football', 'maillots-football', 'Personnalisation de maillots de football avec votre logo, nom et numéro. Matériaux de qualité premium.', 5000.00, 1, 1),
('Gobelets personnalisés', 'gobelets-personnalises', 'Gobelets en plastique ou en carton avec impression de votre logo ou message. Idéal pour entreprises et événements.', 1500.00, 2, 1),
('Cartes de visite premium', 'cartes-visite-premium', 'Impression de cartes de visite professionnelles avec finition mate, brillante ou vernis sélectif.', 2000.00, 3, 1),
('Pochettes téléphone', 'pochettes-telephone', 'Étuis et pochettes pour smartphones avec impression haute qualité de votre design.', 2500.00, 4, 1),
('Porte-clés en métal', 'porte-cles-metal', 'Porte-clés personnalisés en métal laqué avec gravure ou impression de votre logo.', 1000.00, 5, 1),
('Badges et écussons', 'badges-ecussons', 'Badges personnalisés pour identification, promotion ou souvenirs.', 800.00, 6, 1),
('T-shirts personnalisés', 't-shirts-personnalises', 'T-shirts en coton avec impression de votre design pour événements, équipes ou promotion.', 3500.00, (SELECT id FROM categories WHERE slug = 't-shirts'), 1),
('Sacs personnalisés', 'sacs-personnalises', 'Sacs en toile ou coton avec impression de votre logo. Idéal pour promotion d\'entreprise.', 4000.00, (SELECT id FROM categories WHERE slug = 'sacs'), 1);

-- Ajouter des réalisations de démonstration
INSERT INTO realizations (title, description, category_id, images, featured) VALUES
('Maillots équipe ASEC', 'Maillots personnalisés pour une équipe de football locale avec logo et couleurs de l\'équipe', 1, '["maillot1.jpg", "maillot2.jpg"]', 1),
('Gobelets événement Corporate', 'Gobelets personnalisés pour un événement d\'entreprise avec logo de l\'organisation', 2, '["gobelet1.jpg", "gobelet2.jpg"]', 1),
('Cartes de visite Architecte', 'Cartes de visite premium pour cabinet d\'architecture avec design élégant', 3, '["carte1.jpg"]', 1),
('Pochettes iPhone boutique', 'Pochettes personnalisées pour une boutique de téléphonie avec logo', 4, '["pochette1.jpg", "pochette2.jpg"]', 1),
('Porte-clés événement', 'Porte-clés souvenir pour événement avec logo gravé', 5, '["portecles1.jpg"]', 1),
('Badges conférence', 'Badges d\'identification pour une conférence d\'entreprise', 6, '["badge1.jpg", "badge2.jpg"]', 0),
('T-shirts événement sportif', 'T-shirts personnalisés pour événement sportif', (SELECT id FROM categories WHERE slug = 't-shirts'), '["tshirt1.jpg"]', 0),
('Sacs de course promo', 'Sacs personnalisés pour campagne promotionnelle', (SELECT id FROM categories WHERE slug = 'sacs'), '["sac1.jpg"]', 0);
