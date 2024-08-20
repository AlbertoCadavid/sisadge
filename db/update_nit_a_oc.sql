UPDATE `tbl_cotizaciones` SET `Str_nit` = 'nuevonit' WHERE `tbl_cotizaciones`.`N_cotizacion` = '';
 
UPDATE `tbl_cotiza_bolsa` SET `Str_nit` = 'nuevonit' WHERE `tbl_cotiza_bolsa`.`N_cotizacion` = '' AND `tbl_cotiza_bolsa`.`Str_nit` = 'viejonit'; 

 
UPDATE `tbl_cliente_referencia` SET `Str_nit` = 'nuevonit' WHERE `tbl_cliente_referencia`.`id_refcliente` = 28667; 

 
UPDATE `tbl_orden_compra` SET `str_nit_oc` = 'nuevonit' WHERE `tbl_orden_compra`.`str_numero_oc` = 'AC-7405';


UPDATE `tbl_orden_compra_historico` SET `str_nit_oc` = 'nuevonit' WHERE `tbl_orden_compra`.`str_numero_oc` = 'AC-7405'; 

 
UPDATE `tbl_orden_compra` SET `id_c_oc` = '4862' WHERE `tbl_orden_compra`.`str_numero_oc` = 'AC-7405';

UPDATE `tbl_remisiones` SET `int_remision` = '567511' WHERE `tbl_remisiones`.`id_r` = 46513;

UPDATE `tbl_remisiones` SET `int_remision` = '56754' WHERE `tbl_remisiones`.`id_r` = 46513;
UPDATE `tbl_remisiones` SET `b_borrado_r` = '0' WHERE `tbl_remisiones`.`id_r` = 46513;








 

 update tbl_reg_tiempo desp
  join tblextruderrollo ext
  on desp.op_rt=ext.id_op_r
  set desp.id_rollo=ext.id_r
  WHERE ext.rollo_r=desp.int_rollo_rt AND ext.fechaI_r=desp.fecha_rt and desp.id_proceso_rt='1';

 update tbl_reg_tiempo desp
  join tblimpresionrollo ext
  on desp.op_rt=ext.id_op_r
  set desp.id_rollo=ext.id_r
  WHERE ext.rollo_r=desp.int_rollo_rt AND ext.fechaI_r=desp.fecha_rt and desp.id_proceso_rt='2';

 update tbl_reg_tiempo desp
  join tblselladorollo ext
  on desp.op_rt=ext.id_op_r
  set desp.id_rollo=ext.id_r
  WHERE ext.rollo_r=desp.int_rollo_rt AND ext.fechaI_r=desp.fecha_rt and desp.id_proceso_rt='4';



  update tbl_reg_tiempo_preparacion desp
   join tblextruderrollo ext
   on desp.op_rtp=ext.id_op_r
   set desp.id_rollo=ext.id_r
   WHERE ext.rollo_r=desp.int_rollo_rtp AND ext.fechaI_r=desp.fecha_rtp and desp.id_proceso_rtp='1';

  update tbl_reg_tiempo_preparacion desp
   join tblimpresionrollo ext
   on desp.op_rtp=ext.id_op_r
   set desp.id_rollo=ext.id_r
   WHERE ext.rollo_r=desp.int_rollo_rtp AND ext.fechaI_r=desp.fecha_rtp and desp.id_proceso_rtp='2';

  update tbl_reg_tiempo_preparacion desp
   join tblselladorollo ext
   on desp.op_rtp=ext.id_op_r
   set desp.id_rollo=ext.id_r
   WHERE ext.rollo_r=desp.int_rollo_rtp AND ext.fechaI_r=desp.fecha_rtp and desp.id_proceso_rtp='4';



  update tbl_reg_desperdicio desp
  join tblextruderrollo ext
  on desp.op_rd=ext.id_op_r
  set desp.id_rollo=ext.id_r
  WHERE ext.rollo_r=desp.int_rollo_rd AND ext.fechaI_r=desp.fecha_rd and desp.id_proceso_rd='1';

 update tbl_reg_desperdicio desp
  join tblimpresionrollo ext
  on desp.op_rd=ext.id_op_r
  set desp.id_rollo=ext.id_r
  WHERE ext.rollo_r=desp.int_rollo_rd AND ext.fechaI_r=desp.fecha_rd and desp.id_proceso_rd='2';

 update tbl_reg_desperdicio desp
  join tblselladorollo ext
  on desp.op_rd=ext.id_op_r
  set desp.id_rollo=ext.id_r
  WHERE ext.rollo_r=desp.int_rollo_rd AND ext.fechaI_r=desp.fecha_rd and desp.id_proceso_rd='4';


 

  update Tbl_reg_kilo_producido materia
  join tbl_reg_produccion liquid
  on materia.op_rp=liquid.id_op_rp
  set materia.id_rp=liquid.id_rp
  WHERE liquid.fecha_ini_rp=materia.fecha_rkp AND liquid.id_proceso_rp='1';


 update tblextruderrollo materia
  join tbl_reg_produccion liquid
  on materia.id_op_r=liquid.id_op_rp
  set materia.id_rp=liquid.id_rp
  WHERE liquid.fecha_ini_rp=materia.fechaI_r ;
 




ALTER TABLE `tbl_orden_compra` ADD `str_numero_oc2` VARCHAR(50) NULL AFTER `str_numero_oc`;
UPDATE `tbl_orden_compra` SET  `str_numero_oc2`= `str_numero_oc` ;
ALTER TABLE `tbl_orden_compra` DROP `str_numero_oc`;
ALTER TABLE `tbl_orden_compra` CHANGE `str_numero_oc2` `str_numero_oc` VARCHAR(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL;

ALTER TABLE `tbl_remisiones` ADD `id_pedido_oc` INT(11) NULL AFTER `comprobante_file`;

update tbl_remisiones
  join tbl_orden_compra
  on tbl_orden_compra.str_numero_oc=tbl_remisiones.str_numero_oc_r
  set tbl_remisiones.id_pedido_oc=tbl_orden_compra.id_pedido ;


SELECT
  cl.nit_c,
  cl.nombre_c,
  cl.pais_c,
  cl.ciudad_c,
  cl.contacto_c,
  cl.telefono_c,
  cl.telefono_contacto_c,
  cl.celular_contacto_c,
  cl.email_comercial_c,
  toc.str_nit_oc,
  toc.id_pedido,
  max(toc.fecha_ingreso_oc) as fecha_ingreso_oc,
  tio.int_cod_ref_io,
  tio.int_vendedor_io,
  tio.int_precio_io,
  ref.tipo_formula
FROM
  cliente cl
LEFT JOIN
  tbl_orden_compra toc ON cl.nit_c = toc.str_nit_oc
LEFT JOIN
  tbl_items_ordenc tio ON toc.id_pedido = tio.id_pedido_io
LEFT JOIN
  tbl_referencia ref ON ref.cod_ref = tio.int_cod_ref_io
WHERE
  toc.fecha_ingreso_oc BETWEEN '2012-01-01' AND '2018-12-31' AND tio.int_precio_io > '0.00'
GROUP BY
  tio.int_cod_ref_io
ORDER BY
  toc.fecha_ingreso_oc DESC

SELECT
  cl.nit_c,
  cl.nombre_c,
  cl.pais_c,
  cl.ciudad_c,
  cl.contacto_c,
  cl.telefono_c,
  cl.telefono_contacto_c,
  cl.celular_contacto_c,
  cl.email_comercial_c,
  toc.str_nit_oc,
  toc.id_pedido,
  max(toc.fecha_ingreso_oc) as fecha_ingreso_oc, 
  tio.int_cod_ref_io,
  tio.int_vendedor_io,
  tio.int_precio_io,
  ref.tipo_formula
FROM
  cliente cl
LEFT JOIN
  tbl_orden_compra toc ON cl.nit_c = toc.str_nit_oc
LEFT JOIN
  tbl_items_ordenc tio ON toc.id_pedido = tio.id_pedido_io
LEFT JOIN
  tbl_referencia ref ON ref.cod_ref = tio.int_cod_ref_io
WHERE
  toc.fecha_ingreso_oc BETWEEN '2019-01-01' AND '2024-12-31' AND tio.int_precio_io > '0.00'
GROUP BY
  tio.int_cod_ref_io
ORDER BY
  toc.fecha_ingreso_oc DESC


 
SELECT 
  count(tio.id_item_io) as items,
  tio.int_cod_ref_io,
  tio.int_vendedor_io,
  tio.int_precio_io,toc.str_nit_oc,
  toc.id_pedido,
  toc.fecha_ingreso_oc
  FROM tbl_orden_compra toc  
  LEFT JOIN
  tbl_items_ordenc tio ON toc.id_pedido = tio.id_pedido_io order by `id_items` asc

SELECT 
  tio.id_items ,
  tio.int_cod_ref_io,
  tio.int_vendedor_io,
  tio.int_precio_io,toc.str_nit_oc,
  toc.id_pedido,
  toc.fecha_ingreso_oc
  FROM tbl_orden_compra toc  
  LEFT JOIN
  tbl_items_ordenc tio ON toc.id_pedido = tio.id_pedido_io 
  WHERE toc.fecha_ingreso_oc <= '2020-12-31'
  order by tio.id_items asc


  SELECT 
  tio.id_items ,
  tio.int_cod_ref_io,
  tio.int_vendedor_io,
  tio.int_precio_io,toc.str_nit_oc,
  toc.id_pedido,
  toc.fecha_ingreso_oc
  FROM tbl_orden_compra toc  
  LEFT JOIN
  tbl_items_ordenc tio ON toc.id_pedido = tio.id_pedido_io 
  WHERE toc.fecha_ingreso_oc BETWEEN '2021-01-01' and '2022-01-01'
  order by tio.id_items asc

  SELECT 
  tio.id_items ,
  tio.int_cod_ref_io,
  tio.int_vendedor_io,
  tio.int_precio_io,toc.str_nit_oc,
  toc.id_pedido,
  toc.fecha_ingreso_oc
  FROM tbl_orden_compra toc  
  LEFT JOIN
  tbl_items_ordenc tio ON toc.id_pedido = tio.id_pedido_io 
  WHERE toc.fecha_ingreso_oc BETWEEN '2022-01-01' and '2022-12-31'
  order by tio.id_items asc


ALTER TABLE `tbl_orden_compra_historico` ADD `pago_pendiente` VARCHAR(2) NULL AFTER `comprobante_ent`; 
ALTER TABLE `tbl_orden_compra_historico` ADD `proforma_oc` VARCHAR(60) NULL AFTER `pago_pendiente`;
--ALTER TABLE `tbl_orden_compra_historico` ADD `estado_cartera` VARCHAR(40) NULL AFTER `proforma_oc`;
--ALTER TABLE `tbl_orden_compra_historico` ADD `tipo_pago_cartera` VARCHAR(60) NULL AFTER `estado_cartera`;
--ALTER TABLE `tbl_orden_compra_historico` ADD `valor_cartera` VARCHAR(60) NULL AFTER `tipo_pago_cartera`;
ALTER TABLE `tbl_orden_compra_historico` ADD `cobra_flete` INT(1) NULL AFTER `valor_cartera`; 
ALTER TABLE `tbl_orden_compra_historico` ADD `precio_flete` VARCHAR(10) NULL AFTER `cobra_flete`; 
ALTER TABLE `tbl_orden_compra_historico` ADD `tipo_despacho` VARCHAR(12) NULL AFTER `precio_flete`; 
ALTER TABLE `tbl_orden_compra_historico` ADD `fecha_autoriza` VARCHAR(26) NULL AFTER `tipo_despacho`;
ALTER TABLE `tbl_orden_compra_historico` ADD `notaweb` mediumtext NULL AFTER `modifico`;   
ALTER TABLE `tbl_orden_compra_historico` ADD `especialweb` TINYINT NULL AFTER `notaweb`; 





UPDATE Tbl_orden_produccion SET id_op='12412',str_numero_oc_op='91518823', int_cod_ref_op='1486', id_ref_op='2446', str_nit_op='8909157566', int_cliente_op='73', b_borrado_op='0' WHERE id_op='12244';
UPDATE TblExtruderRollo SET id_op_r='12412', ref_r='1486', id_c_r='73' WHERE id_op_r='12244';
UPDATE TblImpresionRollo SET id_op_r='12412', ref_r='1486', id_c_r='73' WHERE id_op_r='12244';
UPDATE TblSelladoRollo SET id_op_r='12412', ref_r='1486' WHERE id_op_r='12244';
UPDATE Tbl_reg_kilo_producido SET op_rp = '12412' WHERE op_rp = '12244';
UPDATE Tbl_reg_tiempo_preparacion SET op_rtp = '12412' WHERE op_rtp='12244';
UPDATE Tbl_reg_desperdicio SET op_rd = '12412' WHERE op_rd ='12244';
UPDATE Tbl_reg_tiempo SET op_rt = '12412' WHERE op_rt ='12244';
UPDATE Tbl_reg_produccion SET id_op_rp='12412', id_ref_rp='2446', int_cod_ref_rp='1486' WHERE id_op_rp='12244' and id_proceso_rp='1';
UPDATE Tbl_reg_produccion SET id_op_rp='12412', id_ref_rp='2446', int_cod_ref_rp='1486' WHERE id_op_rp='12244' and id_proceso_rp='2';
UPDATE Tbl_reg_produccion SET id_op_rp='12412', id_ref_rp='2446', int_cod_ref_rp='1486' WHERE id_op_rp='12244' and id_proceso_rp='4';
 

 

 ALTER TABLE `tbl_orden_produccion` ADD `sinnumeracion` INT(1) NULL DEFAULT '0' AFTER `coextrusion`;


update tbl_orden_compra
  join tbl_items_ordenc
  on tbl_orden_compra.id_pedido=tbl_items_ordenc.id_pedido_io
  set tbl_orden_compra.b_borrado_oc='1'
  WHERE 
  tbl_orden_compra.b_estado_oc =5 AND
  tbl_orden_compra.fecha_ingreso_oc<= '2018-12-31' AND 
  (tbl_items_ordenc.int_cantidad_rest_io <= '0' or tbl_items_ordenc.int_cantidad_rest_io <= '0.00');


update tbl_orden_compra
  join tbl_items_ordenc
  on tbl_orden_compra.id_pedido=tbl_items_ordenc.id_pedido_io
  set tbl_orden_compra.b_borrado_oc='1'
  WHERE 
  tbl_orden_compra.b_estado_oc =5 AND
  tbl_orden_compra.fecha_ingreso_oc<= '2018-12-31' AND 
  (tbl_items_ordenc.int_cantidad_rest_io >= '0' or tbl_items_ordenc.int_cantidad_rest_io >= '0.00');




  UPDATE TblExtruderRollo SET id_op_r='12461'  WHERE id_op_r='12584';
   

  UPDATE TblImpresionRollo SET id_op_r='12461'  WHERE id_op_r='12584';
 

  UPDATE TblSelladoRollo SET id_op_r='12461'  WHERE id_op_r='12584';
  

  UPDATE Tbl_reg_kilo_producido SET op_rp = '12461' WHERE op_rp = '12584';
  

  UPDATE Tbl_reg_tiempo_preparacion SET op_rtp = '12461' WHERE op_rtp='12584';
   

  UPDATE Tbl_reg_desperdicio SET op_rd = '12461' WHERE op_rd ='12584';
  

  UPDATE Tbl_reg_tiempo SET op_rt = '12461' WHERE op_rt ='12584';

/*  update tbl_orden_compra
  join tbl_items_ordenc
  on tbl_orden_compra.id_pedido=tbl_items_ordenc.id_pedido_io
  set tbl_orden_compra.b_borrado_oc='1'
  WHERE 
  tbl_orden_compra.b_estado_oc >=4 AND
  tbl_orden_compra.fecha_ingreso_oc<= '2017-12-31'; 
*/

