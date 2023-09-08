UPDATE cliente SET nit_c='', id_c='' WHERE nit_c='';
UPDATE tbl_cliente_referencia SET str_nit='$nit_nuevo' WHERE str_nit='$nit_viejo'; -- no contiene ID
UPDATE tbl_cotizaciones SET Str_nit='$nit_nuevo' WHERE Str_nit='$nit_viejo'; -- no contiene ID
UPDATE tbl_cotiza_bolsa SET Str_nit='$nit_nuevo' WHERE Str_nit='$nit_viejo'; -- no contiene ID
UPDATE tbl_cotiza_bolsa_obs SET Str_nit='$nit_nuevo' WHERE Str_nit='$nit_viejo'; -- no contiene ID
UPDATE tbl_cotiza_laminas SET Str_nit='$nit_nuevo' WHERE Str_nit='$nit_viejo'; -- no contiene ID
UPDATE tbl_cotiza_materia_p SET Str_nit='$nit_nuevo' WHERE Str_nit='$nit_viejo'; -- no contiene ID
UPDATE tbl_cotiza_materia_p_obs SET Str_nit='$nit_nuevo' WHERE Str_nit='$nit_viejo'; -- no contiene ID
UPDATE tbl_cotiza_packing SET Str_nit='$nit_nuevo' WHERE Str_nit='$nit_viejo'; -- no contiene ID
UPDATE tbl_cotiza_packing_obs SET Str_nit='$nit_nuevo' WHERE Str_nit='$nit_viejo'; -- no contiene ID
UPDATE tbl_destinatarios SET nit='$nit_nuevo' WHERE nit='$nit_viejo'; -- no contiene ID
UPDATE tbl_orden_compra SET str_nit_oc='$nit_nuevo', id_c_oc='nuevoID' WHERE str_nit_oc='$nit_viejo'; -- no contiene ID 
UPDATE tbl_orden_compra_historico SET str_nit_oc='$nit_nuevo' WHERE str_nit_oc='$nit_viejo'; -- no contiene ID
UPDATE tbl_maestra_mp SET Str_nit='$nit_nuevo' WHERE Str_nit='$nit_viejo'; -- no contiene ID
UPDATE tbl_orden_produccion SET str_nit_op='$nit_nuevo' WHERE str_nit_op='$nit_viejo'; -- no contiene ID
UPDATE tbl_refcliente SET str_nit_rc='$nit_nuevo' WHERE str_nit_rc='$nit_viejo'; -- no contiene ID
UPDATE pedido SET nit_c_pedido='$nit_nuevo' WHERE nit_c_pedido='$nit_viejo'; -- no contiene ID
UPDATE tbl_despacho SET cliente_d='$nit_nuevo' WHERE cliente_d='$nit_viejo'; -- no contiene ID

 

UPDATE tbl_cliente_referencia SET str_nit='$nit_nuevo' WHERE str_nit='$nit_viejo';
UPDATE tbl_cotizaciones SET Str_nit='$nit_nuevo' WHERE Str_nit='$nit_viejo';
UPDATE tbl_cotiza_bolsa SET Str_nit='$nit_nuevo' WHERE Str_nit='$nit_viejo';
UPDATE tbl_cotiza_bolsa_obs SET Str_nit='$nit_nuevo' WHERE Str_nit='$nit_viejo';
UPDATE tbl_cotiza_laminas SET Str_nit='$nit_nuevo' WHERE Str_nit='$nit_viejo';
UPDATE tbl_cotiza_materia_p SET Str_nit='$nit_nuevo' WHERE Str_nit='$nit_viejo';
UPDATE tbl_cotiza_materia_p_obs SET Str_nit='$nit_nuevo' WHERE Str_nit='$nit_viejo';
UPDATE tbl_cotiza_packing SET Str_nit='$nit_nuevo' WHERE Str_nit='$nit_viejo';
UPDATE tbl_cotiza_packing_obs SET Str_nit='$nit_nuevo' WHERE Str_nit='$nit_viejo';
UPDATE tbl_destinatarios SET nit='$nit_nuevo' WHERE nit='$nit_viejo';
UPDATE tbl_orden_compra SET str_nit_oc='$nit_nuevo', id_c_oc='nuevoID' WHERE str_nit_oc='$nit_viejo'; 
UPDATE tbl_orden_compra_historico SET str_nit_oc='$nit_nuevo' WHERE str_nit_oc='$nit_viejo';
UPDATE tbl_maestra_mp SET Str_nit='$nit_nuevo' WHERE Str_nit='$nit_viejo';
UPDATE tbl_orden_produccion SET str_nit_op='$nit_nuevo' WHERE str_nit_op='$nit_viejo';
UPDATE tbl_refcliente SET str_nit_rc='$nit_nuevo' WHERE str_nit_rc='$nit_viejo';
UPDATE pedido SET nit_c_pedido='$nit_nuevo' WHERE nit_c_pedido='$nit_viejo';
UPDATE tbl_despacho SET cliente_d='$nit_nuevo' WHERE cliente_d='$nit_viejo';
