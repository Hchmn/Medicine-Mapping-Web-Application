SELECT DISTINCT
`medicine`.`ID` as `medicineId`,
`medicine`.`FORM` as `medicineForm`
FROM `drug_classification`
INNER JOIN `classification` ON `classification`.`DRUG_CLASSIFICATION_ID` = `drug_classification`.`ID`
INNER JOIN `medicine` ON `medicine`.`ID` = `classification`.`MEDICINE_ID`
INNER JOIN `medicine_form` ON `medicine`.`FORM` = `medicine_form`.`ID`
WHERE `drug_classification`.`GENERAL_CLASSIFICATION_ID` IN (2)
AND
`medicine_form`.`ID` IN (1)


SELECT
`pharma_inventory`.`ID` as `invID`,
`pharma_inventory`.`PHARMACY_ID` as `pharmaId`,
`medicine`.`ID` as `medId`,
`medicine`.`BRAND_NAME` as `medBrandName`
FROM `pharma_inventory`
INNER JOIN `medicine` ON `medicine`.`ID` = `pharma_inventory`.`MEDICINE_ID`
WHERE `pharma_inventory`.`PHARMACY_ID` = 1

SELECT
`pharma_inventory`.`ID` as `invID`,
`pharma_inventory`.`PHARMACY_ID` as `pharmaId`,
`pharma_inventory`.`IS_STOCK` as `isStock`,
`pharma_inventory`.`RETAIL_PRICE` as `price`
FROM
`pharma_inventory`
WHERE `pharma_inventory`.`MEDICINE_ID` = 1
