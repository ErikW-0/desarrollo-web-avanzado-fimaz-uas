-- Ejecuta esto en tu base de datos para migrar a imágenes en Base64
ALTER TABLE productos MODIFY imagen LONGTEXT;
