-- Contactpersonen
INSERT INTO Contact (Id, Straat, Huisnummer, Postcode, Stad) VALUES
(1, 'Hoofdstraat', 1, '1234AB', 'Amsterdam'),
(2, 'Dorpsweg', 2, '2345BC', 'Rotterdam'),
(3, 'Laan', 3, '3456CD', 'Utrecht'),
(4, 'Plein', 4, '4567DE', 'Den Haag'),
(5, 'Singel', 5, '5678EF', 'Eindhoven'),
(6, 'Kanaal', 6, '6789FG', 'Groningen'),
(7, 'Dijk', 7, '7890GH', 'Maastricht');

-- Leveranciers
INSERT INTO Leverancier (Id, Naam, ContactPersoon, LeverancierNummer, Mobiel, ContactId) VALUES
(1, 'Snoep BV', 'Jan Jansen', 'L001', '0612345678', 1),
(2, 'Zoetwaren NV', 'Piet Pietersen', 'L002', '0623456789', 2),
(3, 'Candy Corp', 'Kees Klaassen', 'L003', '0634567890', 3),
(4, 'Sweeties BV', 'Anna Bakker', 'L004', '0645678901', 4),
(5, 'Dropjes BV', 'Lisa de Vries', 'L005', '0656789012', 5),
(6, 'Choco NV', 'Tom Smits', 'L006', '0667890123', 6),
(7, 'Gum BV', 'Eva Janssen', 'L007', '0678901234', 7);

-- Producten
INSERT INTO Product (Id, Naam, Barcode) VALUES
(1, 'Winegums', '1234567890123'),
(2, 'Drop', '2345678901234'),
(3, 'Lollies', '3456789012345'),
(4, 'Kauwgom', '4567890123456'),
(5, 'Mintnopjes', '5678901234567'),
(6, 'Toffees', '6789012345678'),
(7, 'Chocolade', '7890123456789'),
(8, 'Zure Matten', '8901234567890'),
(9, 'Spekjes', '9012345678901'),
(10, 'Fruittella', '0123456789012'),
(11, 'Mentos', '1123456789012'),
(12, 'Kersenbonbons', '2123456789012'),
(13, 'Pepermunt', '3123456789012'),
(14, 'Dropstaafjes', '4123456789012');

-- ProductPerLeverancier (jouw data)
INSERT INTO ProductPerLeverancier (Id, LeverancierId, ProductId, DatumLevering, Aantal, DatumEerstVolgendeLevering) VALUES
(1,1,1,'2023-04-09',23,'2023-04-16'),
(2,1,1,'2023-04-18',21,'2023-04-25'),
(3,1,2,'2023-04-09',12,'2023-04-16'),
(4,1,3,'2023-04-10',11,'2023-04-17'),
(5,2,4,'2023-04-14',16,'2023-04-21'),
(6,2,4,'2023-04-21',23,'2023-04-28'),
(7,2,5,'2023-04-14',45,'2023-04-21'),
(8,2,6,'2023-04-14',30,'2023-04-21'),
(9,3,7,'2023-04-12',12,'2023-04-19'),
(10,3,7,'2023-04-19',23,'2023-04-26'),
(11,3,8,'2023-04-10',12,'2023-04-17'),
(12,3,9,'2023-04-11',1,'2023-04-18'),
(13,4,10,'2023-04-16',24,'2023-04-30'),
(14,5,11,'2023-04-10',47,'2023-04-17'),
(15,5,11,'2023-04-19',60,'2023-04-26'),
(16,5,12,'2023-04-11',45,NULL),
(17,5,13,'2023-04-12',23,NULL),
(18,7,14,'2023-04-14',20,NULL);
