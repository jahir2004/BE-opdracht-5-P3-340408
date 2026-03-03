USE jamin_be_opdr4;

-- ============================================================
-- CLEAR EXISTING DATA (reverse FK order: children first)
-- ============================================================
DELETE FROM ProductPerLeverancier;
DELETE FROM ProductPerAllergeen;
DELETE FROM Magazijn;
DELETE FROM Leverancier;
DELETE FROM Product;
DELETE FROM Allergeen;
DELETE FROM Contact;

-- ============================================================
-- INSERT ORDER: respect foreign key dependencies
--   1. Allergeen, Contact, Product  (geen FK)
--   2. Leverancier                  (FK → Contact)
--   3. Magazijn                     (FK → Product)
--   4. ProductPerAllergeen          (FK → Product, Allergeen)
--   5. ProductPerLeverancier        (FK → Leverancier, Product)
-- ============================================================

-- 1a. Allergeen
INSERT INTO Allergeen (Id, Naam, Omschrijving) VALUES
(1, 'Gluten',        'Dit product bevat gluten'),
(2, 'Gelatine',      'Dit product bevat gelatine'),
(3, 'AZO-Kleurstof', 'Dit product bevat AZO-kleurstoffen'),
(4, 'Lactose',       'Dit product bevat lactose'),
(5, 'Soja',          'Dit product bevat soja');

-- 1b. Contact
-- Leverancier 7 (Hom Ken Food) heeft ContactId NULL → geen adres (Scenario 03)
INSERT INTO Contact (Id, Straat, Huisnummer, Postcode, Stad) VALUES
(1, 'Van Gilslaan',           34,  '1045CB', 'Hilvarenbeek'),
(2, 'Den Dolderpad',           2,  '1067RC', 'Utrecht'),
(3, 'Fredo Raalteweg',       257,  '1236OP', 'Nijmegen'),
(4, 'Bertrand Russellhof',    21,  '2034AP', 'Den Haag'),
(5, 'Leon van Bonstraat',    213,  '145XC',  'Lunteren'),
(6, 'Bea van Lingenlaan',    234,  '2197FG', 'Sint Pancras');

-- 1c. Product
INSERT INTO Product (Id, Naam, Barcode) VALUES
(1,  'Mintnopjes',      '8719587231278'),
(2,  'Schoolkrijt',     '8719587326713'),
(3,  'Honingdrop',      '8719587327836'),
(4,  'Zure Beren',      '8719587321441'),
(5,  'Cola Flesjes',    '8719587321237'),
(6,  'Turtles',         '8719587322245'),
(7,  'Witte Muizen',    '8719587328256'),
(8,  'Reuzen Slangen',  '8719587325641'),
(9,  'Zoute Rijen',     '8719587322739'),
(10, 'Winegums',        '8719587327527'),
(11, 'Drop Munten',     '8719587322345'),
(12, 'Kruis Drop',      '8719587322265'),
(13, 'Zoute Ruitjes',   '8719587323256'),
(14, 'Drop ninja''s',   '8719587323277');

-- 2. Leverancier
-- Leverancier 7 heeft ContactId NULL → geen adresgegevens (Scenario 03)
INSERT INTO Leverancier (Id, Naam, ContactPersoon, LeverancierNummer, Mobiel, ContactId) VALUES
(1, 'Venco',          'Bert van Linge',    'L1029384719', '06-28493827', 1),
(2, 'Astra Sweets',   'Jasper del Monte',  'L1029284315', '06-39398734', 2),
(3, 'Haribo',         'Sven Stalman',      'L1029324748', '06-24383291', 3),
(4, 'Basset',         'Joyce Stelterberg', 'L1023845773', '06-48293823', 4),
(5, 'De Bron',        'Remco Veenstra',    'L1023857736', '06-34291234', 5),
(6, 'Quality Street', 'Johan Nooij',       'L1029234586', '06-23458456', 6),
(7, 'Hom Ken Food',   'Hom Ken',           'L1029234599', '06-23458477', NULL);

-- 3. Magazijn (producten 1-13; product 14 niet in magazijn)
INSERT INTO Magazijn (Id, ProductId, VerpakkingsEenheid, AantalAanwezig) VALUES
(1,  1,  5,    453),
(2,  2,  2.5,  400),
(3,  3,  5,    1),
(4,  4,  1,    800),
(5,  5,  3,    234),
(6,  6,  2,    345),
(7,  7,  1,    795),
(8,  8,  10,   233),
(9,  9,  2.5,  10),
(10, 10, 3,    123),
(11, 11, 2,    NULL),
(12, 12, 1,    367),
(13, 13, 5,    20);

-- 4. ProductPerAllergeen
INSERT INTO ProductPerAllergeen (Id, ProductId, AllergeenId) VALUES
(1,  1,  2),   -- Mintnopjes     → Gelatine
(2,  1,  1),   -- Mintnopjes     → Gluten
(3,  1,  3),   -- Mintnopjes     → AZO-Kleurstof
(4,  3,  4),   -- Honingdrop     → Lactose
(5,  6,  5),   -- Turtles        → Soja
(6,  9,  2),   -- Zoute Rijen    → Gelatine
(7,  9,  5),   -- Zoute Rijen    → Soja
(8,  10, 2),   -- Winegums       → Gelatine
(9,  12, 4),   -- Kruis Drop     → Lactose  (Scenario 01)
(10, 13, 4),   -- Zoute Ruitjes  → Lactose
(11, 4,  3),   -- Zure Beren     → AZO-Kleurstof
(12, 5,  4),   -- Cola Flesjes   → Lactose
(13, 14, 5);   -- Drop ninja's   → Soja     (Scenario 02 & 03)

-- 5. ProductPerLeverancier
INSERT INTO ProductPerLeverancier (Id, LeverancierId, ProductId, DatumLevering, Aantal, DatumEerstVolgendeLevering) VALUES
(1,  1, 1,  '2023-04-09', 23, '2023-04-16'),
(2,  1, 1,  '2023-04-18', 21, '2023-04-25'),
(3,  1, 2,  '2023-04-09', 12, '2023-04-16'),
(4,  1, 3,  '2023-04-10', 11, '2023-04-17'),
(5,  2, 4,  '2023-04-14', 16, '2023-04-21'),
(6,  2, 4,  '2023-04-21', 23, '2023-04-28'),
(7,  2, 5,  '2023-04-14', 45, '2023-04-21'),
(8,  2, 6,  '2023-04-14', 30, '2023-04-21'),
(9,  3, 7,  '2023-04-12', 12, '2023-04-19'),
(10, 3, 7,  '2023-04-19', 23, '2023-04-26'),
(11, 3, 8,  '2023-04-10', 12, '2023-04-17'),
(12, 3, 9,  '2023-04-11',  1, '2023-04-18'),
(13, 4, 10, '2023-04-16', 24, '2023-04-30'),
(14, 5, 11, '2023-04-10', 47, '2023-04-17'),
(15, 5, 11, '2023-04-19', 60, '2023-04-26'),
(16, 5, 12, '2023-04-11', 45, NULL),
(17, 5, 13, '2023-04-12', 23, NULL),
(18, 7, 14, '2023-04-14', 20, NULL);  -- Drop ninja's → Hom Ken Food (GEEN adres, Scenario 03)
