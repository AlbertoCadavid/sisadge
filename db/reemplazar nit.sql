UPDATE tbl_orden_compra SET str_nit_oc='9013941806', id_c_oc='5210' WHERE str_nit_oc='901394180';

UPDATE tbl_cliente_referencia SET str_nit='9013941806' WHERE str_nit='901394180';
UPDATE tbl_cotizaciones SET Str_nit='9013941806' WHERE Str_nit='901394180';
UPDATE tbl_cotiza_bolsa SET Str_nit='9013941806' WHERE Str_nit='901394180';
UPDATE tbl_cotiza_bolsa_obs SET Str_nit='9013941806' WHERE Str_nit='901394180';
UPDATE tbl_cotiza_laminas SET Str_nit='9013941806' WHERE Str_nit='901394180';
UPDATE tbl_cotiza_materia_p SET Str_nit='9013941806' WHERE Str_nit='901394180';
UPDATE tbl_cotiza_materia_p_obs SET Str_nit='9013941806' WHERE Str_nit='901394180';
UPDATE tbl_cotiza_packing SET Str_nit='9013941806' WHERE Str_nit='901394180';
UPDATE tbl_cotiza_packing_obs SET Str_nit='9013941806' WHERE Str_nit='901394180';
UPDATE tbl_destinatarios SET nit='9013941806' WHERE nit='901394180';
UPDATE tbl_orden_compra_historico SET str_nit_oc='9013941806' WHERE str_nit_oc='901394180';
UPDATE tbl_maestra_mp SET Str_nit='9013941806' WHERE Str_nit='901394180';
UPDATE tbl_orden_produccion SET str_nit_op='9013941806' WHERE str_nit_op='901394180';
UPDATE tbl_refcliente SET str_nit_rc='9013941806' WHERE str_nit_rc='901394180';
UPDATE pedido SET nit_c_pedido='9013941806' WHERE nit_c_pedido='901394180';
UPDATE tbl_despacho SET cliente_d='9013941806' WHERE cliente_d ='901394180';

 
UPDATE cliente SET nit_c='', id_c='' WHERE nit_c='';

SELECT `id_c`,`nit_c`,`nombre_c`,`fecha_ingreso_c`,`registrado_c` COUNT(*) Total FROM cliente GROUP BY nombre_c HAVING COUNT(*) > 1

UPDATE tbl_cliente_referencia SET str_nit='1114825869' WHERE str_nit='98557393'; -- no contiene ID
UPDATE tbl_cotizaciones SET Str_nit='1114825869' WHERE Str_nit='98557393'; -- no contiene ID
UPDATE tbl_cotiza_bolsa SET Str_nit='1114825869' WHERE Str_nit='98557393'; -- no contiene ID
UPDATE tbl_cotiza_bolsa_obs SET Str_nit='1114825869' WHERE Str_nit='98557393'; -- no contiene ID
UPDATE tbl_cotiza_laminas SET Str_nit='1114825869' WHERE Str_nit='98557393'; -- no contiene ID
UPDATE tbl_cotiza_materia_p SET Str_nit='1114825869' WHERE Str_nit='98557393'; -- no contiene ID
UPDATE tbl_cotiza_materia_p_obs SET Str_nit='1114825869' WHERE Str_nit='98557393'; -- no contiene ID
UPDATE tbl_cotiza_packing SET Str_nit='1114825869' WHERE Str_nit='98557393'; -- no contiene ID
UPDATE tbl_cotiza_packing_obs SET Str_nit='1114825869' WHERE Str_nit='98557393'; -- no contiene ID
UPDATE tbl_destinatarios SET nit='1114825869' WHERE nit='98557393'; -- no contiene ID
UPDATE tbl_orden_compra SET str_nit_oc='1114825869', id_c_oc='nuevoID' WHERE str_nit_oc='98557393'; -- no contiene ID 
UPDATE tbl_orden_compra_historico SET str_nit_oc='1114825869' WHERE str_nit_oc='98557393'; -- no contiene ID
UPDATE tbl_maestra_mp SET Str_nit='1114825869' WHERE Str_nit='98557393'; -- no contiene ID
UPDATE tbl_orden_produccion SET str_nit_op='1114825869' WHERE str_nit_op='98557393'; -- no contiene ID
UPDATE tbl_refcliente SET str_nit_rc='1114825869' WHERE str_nit_rc='98557393'; -- no contiene ID
UPDATE pedido SET nit_c_pedido='1114825869' WHERE nit_c_pedido='98557393'; -- no contiene ID
UPDATE tbl_despacho SET cliente_d='1114825869' WHERE cliente_d='98557393'; -- no contiene ID