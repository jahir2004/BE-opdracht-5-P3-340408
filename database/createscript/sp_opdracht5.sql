DROP PROCEDURE IF EXISTS GetGeleverdeProductenInTijdvak;
DELIMITER $$

CREATE PROCEDURE GetGeleverdeProductenInTijdvak(
    IN startDatum DATE,
    IN eindDatum DATE
)
BEGIN
    SELECT
        p.Id AS ProductId,
        p.Naam AS ProductNaam,
        l.Naam AS LeverancierNaam,
        SUM(ppl.Aantal) AS TotaalGeleverd
    FROM ProductPerLeverancier ppl
    JOIN Product p ON ppl.ProductId = p.Id
    JOIN Leverancier l ON ppl.LeverancierId = l.Id
    WHERE ppl.DatumLevering BETWEEN startDatum AND eindDatum
    GROUP BY p.Id, l.Id
    ORDER BY l.Naam ASC, p.Naam ASC;
END$$

DELIMITER ;