-- ========================================
-- Stored Procedures voor BE-opdracht-4
-- Snoepshop Allergenen Management
-- ========================================

USE jamin_be_opdr4;

-- ========================================
-- 1. Get all allergenen for dropdown
-- ========================================
DROP PROCEDURE IF EXISTS sp_GetAllAllergensForDropdown;

DELIMITER $$
CREATE PROCEDURE sp_GetAllAllergensForDropdown()
BEGIN
    SELECT 
        Id, 
        Naam, 
        Omschrijving 
    FROM Allergeen 
    WHERE IsActief = 1
    ORDER BY Naam ASC;
END$$
DELIMITER ;

-- ========================================
-- 2. Get all products with allergies
-- ========================================
DROP PROCEDURE IF EXISTS sp_GetAllProductsWithAllergies;

DELIMITER $$
CREATE PROCEDURE sp_GetAllProductsWithAllergies()
BEGIN
    SELECT DISTINCT
        p.Id,
        p.Naam AS ProductNaam,
        p.Barcode,
        a.Naam AS AllergeenNaam,
        a.Omschrijving AS AllergeenOmschrijving
    FROM Product p
    INNER JOIN ProductPerAllergeen ppa ON p.Id = ppa.ProductId
    INNER JOIN Allergeen a ON ppa.AllergeenId = a.Id
    WHERE p.IsActief = 1 AND a.IsActief = 1
    ORDER BY p.Naam ASC;
END$$
DELIMITER ;

-- ========================================
-- 3. Get products by specific allergen
-- ========================================
DROP PROCEDURE IF EXISTS sp_GetProductsByAllergen;

DELIMITER $$
CREATE PROCEDURE sp_GetProductsByAllergen(IN allergeenNaam VARCHAR(100))
BEGIN
    SELECT DISTINCT
        p.Id,
        p.Naam AS ProductNaam,
        p.Barcode,
        a.Naam AS AllergeenNaam,
        a.Omschrijving AS AllergeenOmschrijving
    FROM Product p
    INNER JOIN ProductPerAllergeen ppa ON p.Id = ppa.ProductId
    INNER JOIN Allergeen a ON ppa.AllergeenId = a.Id
    WHERE a.Naam = allergeenNaam 
      AND p.IsActief = 1 
      AND a.IsActief = 1
    ORDER BY p.Naam ASC;
END$$
DELIMITER ;

-- ========================================
-- 4. Get supplier info with address check
-- ========================================
DROP PROCEDURE IF EXISTS sp_GetSupplierInfoWithAddressCheck;

DELIMITER $$
CREATE PROCEDURE sp_GetSupplierInfoWithAddressCheck(IN productId INT)
BEGIN
    SELECT 
        p.Naam AS ProductNaam,
        l.Naam AS LeverancierNaam,
        l.ContactPersoon,
        l.Mobiel,
        c.Straat,
        c.Huisnummer,
        c.Postcode,
        c.Stad,
        CASE 
            WHEN c.Id IS NULL THEN 1 
            ELSE 0 
        END AS NoAddressData
    FROM Product p
    INNER JOIN ProductPerLeverancier ppl ON p.Id = ppl.ProductId
    INNER JOIN Leverancier l ON ppl.LeverancierId = l.Id
    LEFT JOIN Contact c ON l.ContactId = c.Id
    WHERE p.Id = productId 
      AND p.IsActief = 1 
      AND l.IsActief = 1
    LIMIT 1;
END$$
DELIMITER ;

-- ========================================
-- Test stored procedures (optional)
-- ========================================

-- Test 1: Get all allergens
-- CALL sp_GetAllAllergensForDropdown();

-- Test 2: Get all products with allergies  
-- CALL sp_GetAllProductsWithAllergies();

-- Test 3: Get products by allergen
-- CALL sp_GetProductsByAllergen('Lactose');

-- Test 4: Get supplier info
-- CALL sp_GetSupplierInfoWithAddressCheck(12);
