
SELECT * FROM wp5s_trp_dictionary_es_es_en_us(nombres productos)
SELECT * FROM wp5s_trp_original_strings(nombres productos)
SELECT * FROM wp5s_users(usuarios en general)
SELECT * FROM wp5s_wc_customer_lookup(usuario actividad)
SELECT * FROM wp5s_wc_order_product_lookup(venta o compra..)
SELECT * FROM wp5s_wc_order_stats(venta o compra)
SELECT * FROM wp5s_wc_product_meta_lookup(productos)
SELECT * FROM wp5s_woocommerce_order_items(varios registros por cada orden)
SELECT * FROM wp5s_woo_shippment_provider(proveedores)
SELECT * FROM wp5s_postmeta(iNFORMACION VENTA)


SELECT * FROM wp5s_wc_customer_lookup WHERE first_name='Alvaro';  --8

SELECT * FROM wp5s_wc_order_product_lookup WHERE customer_id = 8
SELECT * FROM wp5s_wc_order_product_lookup WHERE customer_id = 7


SELECT * FROM wp5s_wc_order_stats WHERE `customer_id` = 8


-------------------------------------ACCESOS-----------------------
---------cpanel-------------
https://www.latinoamericahosting.com.co
alvarocadavid@acycia.com
Acr70556763$

pagina:  https://www.acycia.com/

-----------wordpRESS------------------
https://www.acycia.com/wp-login.php?utm_source=email&utm_medium=email
robinrt144@gmail.com
3M1THJFt$#9UZp9z

--------------------------------------------------------------------------------------------
SELECT * FROM wp5s_wc_order_stats WHERE `customer_id` = 8

SELECT  * FROM wp5s_postmeta WHERE  POST_ID = 3317

SELECT * FROM  wp5s_postmeta WHERE post_id= 5119

--SELECT * FROM wp5s_wc_order_stats  where order_id in(5107, 5119);

--SELECT * FROM wp5s_wc_order_product_lookup  WHERE order_id in(5107, 5119);

SELECT * from wp5s_woocommerce_order_items where order_id in(5107, 5119);

--SELECT * FROM wp5s_wc_order_product_lookup ORDER BY date_created DESC

SELECT nombre.meta_value as nombre FROM wp5s_postmeta cl
join wp5s_postmeta nombre on(nombre.meta_id = cl.meta_id and cl.meta_key ='_shipping_last_name')
where cl.post_id=5105

SELECT META_VALUE, SUM(1) AS TOTAL FROM wp5s_postmeta  WHERE META_KEY = '_billing_first_name' GROUP BY META_VALUE;
b71cff4704f89b8840492e5c2487f4d3
658 order item id
wp5s_woocommerce_order_itemmeta

SELECT * FROM `wp5s_woocommerce_order_items` where order_id = 4003

SELECT * FROM `wp5s_woocommerce_order_items` where `order_item_name` = 'Bolsas de E-Commerce &#038; Mensajería - 19cm x 25cm'

SELECT
POST_ID,
MAX(CASE WHEN META_KEY = '_billing_first_name' THEN meta_value END) AS NOMBRE,
MAX(CASE WHEN META_KEY = '_shipping_last_name' THEN meta_value END) AS APELLIDO,
MAX(CASE WHEN META_KEY = '_billing_city' THEN meta_value END) AS CITY,
MAX(CASE WHEN META_KEY = '_completed_date' THEN meta_value END) AS FECHA
FROM  wp5s_postmeta WHERE post_id  IN(5105, 5119) GROUP BY POST_ID;

SELECT * FROM (
SELECT 
POST_ID AS ORDEN,
MAX(CASE WHEN META_KEY = '_billing_wooccm11' THEN meta_value END) AS CEDULA,
MAX(CASE WHEN META_KEY = '_billing_first_name' THEN meta_value END) AS NOMBRE,
MAX(CASE WHEN META_KEY = '_shipping_last_name' THEN meta_value END) AS APELLIDO,
MAX(CASE WHEN META_KEY = '_billing_city' THEN meta_value END) AS CIUDAD,
MAX(CASE WHEN META_KEY = '_completed_date' THEN meta_value END) AS FECHA_SOLICITUD,
MAX(CASE WHEN META_KEY = '_completed_date' THEN meta_value END) AS FECHA_COMPLETADA,
MAX(CASE WHEN META_KEY = '_billing_phone' THEN meta_value END) AS TELEFONO,
MAX(CASE WHEN META_KEY = '_billing_address_1' THEN meta_value END) AS DIRECCION_1,
MAX(CASE WHEN META_KEY = '_billing_address_2' THEN meta_value END) AS DIRECCION_2,
MAX(CASE WHEN META_KEY = '_payment_method' THEN meta_value END) AS METODO_PAGO,
MAX(CASE WHEN META_KEY = '_billing_email' THEN meta_value END) AS EMAIL,
MAX(CASE WHEN META_KEY = '_order_tax' THEN meta_value END) AS IVA,
MAX(CASE WHEN META_KEY = '_order_total' THEN meta_value END) AS TOTAL,
MAX(CASE WHEN META_KEY = '_p2p_status' THEN meta_value END) AS ESTADO,
MAX(CASE WHEN META_KEY = '_billing_company' THEN meta_value END) AS EMPRESA
FROM  wp5s_postmeta  GROUP BY POST_ID) T 
LEFT JOIN acycia_ventas V ON(T.ORDEN = V.ORDER_ID)
WHERE T.FECHA_COMPLETADA LIKE  '%2020-08-05%' AND T.ESTADO = 'APPROVED' AND V.ORDER_ID IS NULL;

tabla_aux 
ID
ORDEN
FECHA


SELECT * FROM wp5s_wc_order_stats WHERE customer_id =0

SELECT * FROM wp5s_wc_order_product_lookup WHERE product_id IN(3317)

SELECT * FROM wp5s_woocommerce_order_items WHERE ORDER_ID = 5122

SELECT * FROM wp5s_wc_product_meta_lookup where sku = '059-00'

SELECT * FROM wp5s_trp_original_strings 

SELECT * FROM wp5s_trp_dictionary_es_es_en_us

producto id  3317
order id item id 2707

SELECT * FROM wp5s_wc_order_stats ORDER BY date_created  DESC WHERE ORDER_ID= 5107


3033
3034
3035


SELECT * FROM `wp5s_woocommerce_order_itemmeta` where order_item_id  =2718


product id 3096

SELECT * FROM `wp5s_wc_product_meta_lookup` where product_id  = 3312
-------------------------------------------------------------------
select * from wp5s_woocommerce_order_items where order_id =5264

2707
SELECT * FROM `wp5s_woocommerce_order_itemmeta` where order_item_id  =3138

SELECT * FROM `wp5s_wc_product_meta_lookup` where product_id  = 3318

SELECT * FROM wp5s_woocommerce_order_items WHERE ORDER_ID = 5119 AND order_item_type  ='line_item';

select * from wp5s_woocommerce_order_itemmeta  where order_item_id  = 2707

SELECT P.SKU FROM wp5s_woocommerce_order_itemmeta O
JOIN wp5s_wc_product_meta_lookup P ON(O.meta_value = P.product_id )
WHERE O.ORDER_ITEM_ID = 2707 AND O.meta_key  ='_variation_id';

SELECT* FROM wp5s_wc_product_meta_lookup WHERE product_id  = 3276

-----------------------------------------


