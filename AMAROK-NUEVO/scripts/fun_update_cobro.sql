CREATE OR REPLACE FUNCTION fun_update_cobro(wnum_venta	venta.ventaNum%TYPE,
                                            wtipo_pago venta.tipopago%TYPE,
                                            wusr_insert venta.usr_insert%TYPE,
                                            wusr_insert_rol  venta.usr_insert_rol%TYPE) RETURNS VARCHAR AS
$BODY$
    DECLARE wmessage VARCHAR;
    DECLARE wreg_venta RECORD;
    DECLARE i INTEGER;
    DECLARE wventa_num parametros.numFacIni%TYPE;
    DECLARE wreg_producto RECORD;
    DECLARE wreg_cliente RECORD;
    DECLARE cur refcursor;
    DECLARE fila RECORD;
    DECLARE wruta VARCHAR;
    DECLARE wpuntos_cliente INTEGER;
    
    DECLARE wventa_envio envio.numVenta%TYPE;
    BEGIN
        wpuntos_cliente = 0;
        SELECT ventaNum, docClient, ventaDom INTO wreg_venta from venta 
		WHERE ventaNum= wnum_venta FOR UPDATE;
		IF NOT FOUND THEN
			wmessage = 'La venta temporal no se encuentra registrada';
			RETURN wmessage;
		END IF;
        SELECT cl.clientDoc, cl.clientAct, cl.clientPun, d.departNom, c.ciudadNom INTO wreg_cliente FROM cliente cl 
        JOIN ciudad c ON cl.idCiudad=c.ciudadId JOIN departamento d ON c.idDepart=d.departId 
        WHERE clientDoc=wreg_venta.docClient FOR UPDATE;
        IF wreg_cliente.clientDoc IS NULL THEN
            wmessage = 'El cliente no se encuentra registrado';         --VALIDAMOS QUE EL CLIENTE ESTÉ REGISTRADO
            RETURN wmessage;
        END IF;
        IF wreg_cliente.clientAct = FALSE THEN
            wmessage = 'El cliente no está activo';                     --VALIDAMOS QUE EL CLIENTE ESTÉ ACTIVO
            RETURN wmessage;
        END IF;
        wruta = '../facturas_ventas/' || wreg_cliente.clientDoc;

        SELECT numFacIni INTO wventa_num FROM parametros;               --TRAEMOS NÚMERO DE FACTURA ACTUAL
        IF NOT FOUND THEN
            wmessage = 'No se pudo encontrar el útimo número de factura registrado';
            RETURN wmessage;
        END IF;
        IF wventa_num IS NULL THEN
            wmessage = 'Debe asignar un valor para arranque de las facturas';
            RETURN wmessage;
        END IF;
        wventa_num = wventa_num + 1;
        
        IF wtipo_pago != 'Efectivo' AND wtipo_pago != 'Tarjeta' AND wtipo_pago != 'Transferencia Banco' THEN
            wmessage = 'Modo de cobro no válido';
            RETURN wmessage;
        END IF;
        

        /* AQUI EMPIEZA LA LOCURA */ 

        IF wreg_venta.ventaDom = TRUE THEN
            INSERT INTO venta(ventaNum, docClient, departamento, ciudad, tipopago, ventaRutFac, ventaRec, ventaDom, usr_insert, usr_insert_rol) 
                            VALUES(wventa_num, wreg_cliente.clientDoc, wreg_cliente.departNom, wreg_cliente.ciudadNom, 
                                    wtipo_pago, wruta, TRUE, TRUE, wusr_insert, wusr_insert_rol);
            IF NOT FOUND THEN
                wmessage = 'Error en la inserción';                
                RETURN wmessage;
            END IF;
        ELSE
            INSERT INTO venta(ventaNum, docClient, departamento, ciudad, tipopago, ventaRutFac, ventaRec, usr_insert, usr_insert_rol) 
                            VALUES(wventa_num, wreg_cliente.clientDoc, wreg_cliente.departNom, wreg_cliente.ciudadNom, 
                                    wtipo_pago, wruta, TRUE, wusr_insert, wusr_insert_rol);
            IF NOT FOUND THEN
                wmessage = 'Error en la inserción';                
                RETURN wmessage;
            END IF;
        END IF;

        OPEN cur FOR SELECT * FROM detalleVenta WHERE numVenta = wnum_venta;
            IF NOT FOUND THEN
                wmessage = 'No se pudieron leer los productos en esta venta';
                CLOSE cur;
                RETURN wmessage;
            END IF;
            i=1;

            FETCH cur INTO fila;
            WHILE (FOUND) LOOP
                SELECT pr.producCod, pr.producSto, pr.producAct INTO wreg_producto FROM producto pr 
                WHERE pr.producCod = fila.codproduc FOR UPDATE;
                IF NOT FOUND THEN
                    wmessage = 'El producto solicitado de referencia ' || fila.codproduc || ' no se ha encontrado';
                    CLOSE cur;
                    RETURN wmessage;                                        --VALIDAMOS EXISTENCIA DEL PRODUCTO
                END IF;
                IF wreg_producto.producAct = FALSE THEN
                    wmessage = 'El producto de referencia ' || fila.codproduc || ' no se encuentra disponible para la venta';
                    CLOSE cur;
                    RETURN wmessage;
                END IF;

                IF fila.detventacan > wreg_producto.producSto THEN
                    wmessage = 'La cantidad solicitada del producto de referencia ' || fila.codproduc || ' sobrepasa las unidades disponibles';
                    CLOSE cur;
                    RETURN wmessage;                                        --VALIDAMOS SUFICIENCIA DE STOCK DEL PRODUCTO SOLICITADO
                END IF;

                INSERT INTO detalleventa(numVenta, codProduc, detVentaCan, precioProduc, detVentaDes, detVentaValPar, usr_insert, usr_insert_rol) 
                            VALUES(wventa_num, wreg_producto.producCod, fila.detventacan, fila.precioproduc, fila.detventades, fila.detventavalpar, wusr_insert, wusr_insert_rol);
                IF NOT FOUND THEN                                           --VALIDAMOS QUE SE HAYA HECHO LA INSERCIÓN DEL DETALLE DE VENTA
                    wmessage = 'Error en la inserción del detalle de venta para el producto de referencia ' || fila.codProduc;
                    CLOSE cur;
                    RETURN wmessage;
                END IF;
                wreg_producto.producSto = wreg_producto.producSto - fila.detventacan;
                UPDATE producto SET producSto = wreg_producto.producSto, usr_update=wusr_insert, usr_update_rol=wusr_insert_rol
                                    WHERE producCod = fila.codproduc;
                IF NOT FOUND THEN                                           --VALIDAMOS QUE EL STOCK DEL PRODUCTO SE HAYA ACTUALIZADO
                    wmessage = 'Error en la actualización del stock del producto de referencia ' || fila.codproduc;
                    CLOSE cur;
                    RETURN wmessage;
                END IF;
                wpuntos_cliente = wpuntos_cliente + (fila.detventavalpar / 1000);
                FETCH cur INTO fila;
            END LOOP;
        CLOSE cur;
        
        -- FIN DEL CICLO DE DETALLES --
        wpuntos_cliente = wpuntos_cliente + wreg_cliente.clientPun;
        UPDATE cliente SET clientPun = wpuntos_cliente, usr_update=wusr_insert, usr_update_rol=wusr_insert_rol
                        WHERE clientDoc=wreg_cliente.clientDoc;
        IF NOT FOUND THEN                                           --VALIDAMOS QUE LOS PUNTOS DEL CLIENTE SE HAYAN ACTUALIZADO
            wmessage = 'Error en la actualización de los puntos del cliente de documento ' || wreg_cliente.clientDoc;
            RETURN wmessage;
        END IF;
        UPDATE parametros SET numFacIni = wventa_num, usr_update=wusr_insert, usr_update_rol=wusr_insert_rol;
        IF NOT FOUND THEN                                           --VALIDAMOS QUE LOS PUNTOS DEL CLIENTE SE HAYAN ACTUALIZADO
            wmessage = 'Error en la actualización del parámetro de número de factura actual';
            RETURN wmessage;
        END IF;
        SELECT numVenta INTO wventa_envio FROM envio WHERE numVenta=wnum_venta;
        IF wventa_envio IS NULL THEN
            DELETE FROM venta WHERE ventaNum=wnum_venta;
            IF NOT FOUND THEN
                wmessage = 'Error en la eliminación de la factura temporal';
                RETURN wmessage;
            END IF;
        ELSE
            UPDATE envio SET numVenta = wventa_num WHERE numVenta=wnum_venta;
            IF NOT FOUND THEN
                wmessage = 'Error en la actualización del envio';
                RETURN wmessage;
            END IF;
            DELETE FROM venta WHERE ventaNum=wnum_venta;
            IF NOT FOUND THEN
                wmessage = 'Error en la eliminación de la factura temporal';
                RETURN wmessage;
            END IF;
        END IF;
        wmessage = TO_CHAR(wventa_num, 'FM99999');
        RETURN wmessage;
        /* AQUI TERMINA LA LOCURA */
    END;
$BODY$
LANGUAGE PLPGSQL;