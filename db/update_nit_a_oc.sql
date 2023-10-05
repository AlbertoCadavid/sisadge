UPDATE `tbl_cotizaciones` SET `Str_nit` = 'nuevonit' WHERE `tbl_cotizaciones`.`N_cotizacion` = '';
 
UPDATE `tbl_cotiza_bolsa` SET `Str_nit` = 'nuevonit' WHERE `tbl_cotiza_bolsa`.`N_cotizacion` = '' AND `tbl_cotiza_bolsa`.`Str_nit` = 'viejonit'; 

 
UPDATE `tbl_cliente_referencia` SET `Str_nit` = 'nuevonit' WHERE `tbl_cliente_referencia`.`id_refcliente` = 28667; 

 
UPDATE `tbl_orden_compra` SET `str_nit_oc` = 'nuevonit' WHERE `tbl_orden_compra`.`str_numero_oc` = 'AC-7405';


UPDATE `tbl_orden_compra_historico` SET `str_nit_oc` = 'nuevonit' WHERE `tbl_orden_compra`.`str_numero_oc` = 'AC-7405'; 

 
UPDATE `tbl_orden_compra` SET `id_c_oc` = '4862' WHERE `tbl_orden_compra`.`str_numero_oc` = 'AC-7405';

UPDATE `tbl_remisiones` SET `int_remision` = '567511' WHERE `tbl_remisiones`.`id_r` = 46513;

UPDATE `tbl_remisiones` SET `int_remision` = '56754' WHERE `tbl_remisiones`.`id_r` = 46513;
UPDATE `tbl_remisiones` SET `b_borrado_r` = '0' WHERE `tbl_remisiones`.`id_r` = 46513;