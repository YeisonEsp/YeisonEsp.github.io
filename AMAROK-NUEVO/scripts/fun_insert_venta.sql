CREATE OR REPLACE FUNCTION fun_insert_venta(wdoc_cliente cliente.clientDoc%TYPE, wdepartamento venta.departamento%TYPE, 
                                            wciudad venta.ciudad%TYPE,wtipopago venta.tipopago%TYPE, wpuntos_cliente cliente.clientPun%TYPE,
                                            wcod_producto VARCHAR[], wcan_producto DECIMAL(3,0)[], wprecio_producto DECIMAL(8,0)[],
                                            wdes_producto DECIMAL(6,0)[], wparcial_producto DECIMAL(8,0)[],
                                            wusr_insert venta.usr_insert%TYPE, wusr_insert_rol venta.usr_insert_rol%TYPE,
                                            wventa_dom venta.ventaDom%TYPE,
                                            wciudad_id ciudad.ciudadId%TYPE, wdoc_recibe envio.envioDocDes%TYPE, wnom_recibe envio.envioNomDes%TYPE,
                                            wtel_recibe envio.envioTelDes%TYPE,
                                            wdir_recibe envio.envioDirDes%TYPE) RETURNS VARCHAR AS
$$
    DECLARE wmessage VARCHAR;
    DECLARE i INTEGER;
    DECLARE wnum_venta parametros.numFacIni%TYPE;
    DECLARE cantarray_prod INTEGER = array_length(wcod_producto, 1);
    DECLARE wreg_producto RECORD;
    DECLARE wreg_cliente RECORD;
    DECLARE wruta VARCHAR;
    DECLARE wpendientes INTEGER;
    DECLARE wfactura_falsa parametros.numFacFal%TYPE;

    DECLARE wnum_envio envio.envioNum%TYPE;
    DECLARE wreg_ciudad RECORD;
    BEGIN
        wruta = '../facturas_ventas/' || wdoc_cliente;
        SELECT clientDoc, clientPun, clientAct INTO wreg_cliente FROM cliente WHERE clientDoc=wdoc_cliente FOR UPDATE;
        IF NOT FOUND THEN
            wmessage = 'El cliente no se encuentra registrado';         --VALIDAMOS EXISTENCIA DEL CLIENTE
            RETURN wmessage;
        END IF;

        IF wreg_cliente.clientAct = FALSE THEN
            wmessage = 'El cliente no está activo';                     --VALIDAMOS QUE EL CLIENTE ESTÉ ACTIVO
            RETURN wmessage;
        END IF;

        SELECT max(envioNum) INTO wnum_envio FROM envio;
        IF wnum_envio IS NULL THEN
            wnum_envio = 0;
        END IF;
        wnum_envio = wnum_envio + 1;
        

        i=1;
        CASE wtipopago
            WHEN 'Ninguno' THEN
                SELECT COUNT(ventaNum) INTO wpendientes FROM venta WHERE ventaRec=false AND docClient=wdoc_cliente;
                IF wpendientes > 0 THEN
                    wmessage = 'El cliente tiene un pedido pendiente por pagar'; --VALIDAMOS QUE EL CLIENTE NO DEBA NINGÚN PEDIDO
                    RETURN wmessage;
                END IF;
                SELECT numFacFal INTO wfactura_falsa FROM parametros FOR UPDATE;               --TRAEMOS NÚMERO DE FACTURA ACTUAL
                IF NOT FOUND THEN
                    wmessage = 'No se pudo encontrar el útimo número falso de factura registrado';
                    RETURN wmessage;
                END IF;
                IF wfactura_falsa IS NULL THEN
                    wmessage = 'Debe asignar un valor para arranque de las facturas falsas o temporales';
                    RETURN wmessage;
                END IF;
                wfactura_falsa = wfactura_falsa - 1;
                IF wventa_dom = FALSE THEN
                    INSERT INTO venta(ventaNum, docClient, departamento, ciudad, tipopago, usr_insert, usr_insert_rol) 
                            VALUES(wfactura_falsa, wdoc_cliente, wdepartamento, wciudad, wtipopago, wusr_insert, wusr_insert_rol);
                    IF NOT FOUND THEN
                        wmessage = 'Error en la inserción';                 --INSERCIÓN EN CASO DE QUE EL TIPO DE PAGO SEA NINGUNO
                        RETURN wmessage;
                    END IF;
                ELSE
                    INSERT INTO venta(ventaNum, docClient, departamento, ciudad, tipopago, ventaDom, usr_insert, usr_insert_rol) 
                            VALUES(wfactura_falsa, wdoc_cliente, wdepartamento, wciudad, wtipopago, wventa_dom, wusr_insert, wusr_insert_rol);
                    IF NOT FOUND THEN
                        wmessage = 'Error en la inserción';                 --INSERCIÓN EN CASO DE QUE EL TIPO DE PAGO SEA NINGUNO
                        RETURN wmessage;
                    END IF;
                    -- AQUI INICIA LA INSERCIÓN DE LOS DATOS DEL DOMICILIO --
                    SELECT ciudadId, precioDom INTO wreg_ciudad FROM ciudad WHERE ciudadId=wciudad_id;
                    IF NOT FOUND THEN                                               --VERIFICAMOS EXISTENCIA DEL MUNICIPIO
                        wmessage = 'Este municipio no se encuentra registrado';
                        RETURN wmessage;
                    END IF;
                    INSERT INTO envio(envioNum, numVenta, idCiudad, envioDocDes, envioNomDes, envioDirDes, envioTelDes, envioPre, usr_insert, usr_insert_rol) 
                            VALUES(wnum_envio, wfactura_falsa, wreg_ciudad.ciudadId, wdoc_recibe, wnom_recibe, wdir_recibe, wtel_recibe, wreg_ciudad.precioDom, wusr_insert, wusr_insert_rol);
                    IF NOT FOUND THEN                                           --VALIDAMOS QUE LOS PUNTOS DEL CLIENTE SE HAYAN ACTUALIZADO
                        wmessage = 'Error en la inserción del envío';
                        RETURN wmessage;
                    END IF;
                    -- AQUI TEMRINA LA INSERCIÓN DE LOS DATOS DEL DOMICILIO --
                END IF;
                FOR i in 1..cantarray_prod LOOP     -- INICIO DEL CICLO DE DETALLES --
                    SELECT pr.producCod, pr.producSto, pr.producAct INTO wreg_producto FROM producto pr 
                    WHERE pr.producCod = wcod_producto[i] FOR UPDATE;
                    IF NOT FOUND THEN
                        wmessage = 'El producto solicitado de referencia ' || wcod_producto[i] || ' no se ha encontrado';
                        RETURN wmessage;                                        --VALIDAMOS EXISTENCIA DEL PRODUCTO
                    END IF;
                    IF wreg_producto.producAct = FALSE THEN
                        wmessage = 'El producto de referencia ' || wcod_producto[i] || ' no se encuentra disponible para la venta';
                        RETURN wmessage;                                        --VALIDAMOS QUE EL PRODUCTO ESTÉ DISPONIBLE PARA LA VENTA
                    END IF;
                    IF wcan_producto[i] > wreg_producto.producSto THEN
                        wmessage = 'La cantidad solicitada del producto de referencia ' || wcod_producto[i] || ' sobrepasa las unidades disponibles';
                        RETURN wmessage;                                        --VALIDAMOS SUFICIENCIA DE STOCK DEL PRODUCTO SOLICITADO
                    END IF;
                    
                    INSERT INTO detalleventa(numVenta, codProduc, detVentaCan, precioProduc, detVentaDes, detVentaValPar, usr_insert, usr_insert_rol) 
                                VALUES(wfactura_falsa, wcod_producto[i], wcan_producto[i], wprecio_producto[i], wdes_producto[i], wparcial_producto[i], wusr_insert, wusr_insert_rol);
                    IF NOT FOUND THEN                                           --VALIDAMOS QUE SE HAYA HECHO LA INSERCIÓN DEL DETALLE DE VENTA
                        wmessage = 'Error en la inserción del detalle de venta para el producto de referencia ' || wcod_producto[i];
                        RETURN wmessage;
                    END IF;
                END LOOP;   -- FIN DEL CICLO DE DETALLES --
                UPDATE parametros SET numFacFal = wfactura_falsa, usr_update=wusr_insert, usr_update_rol=wusr_insert_rol;
                IF NOT FOUND THEN                                           --VALIDAMOS QUE LOS PUNTOS DEL CLIENTE SE HAYAN ACTUALIZADO
                    wmessage = 'Error en la actualización del parámetro de número de factura temporal actual';
                    RETURN wmessage;
                END IF;
                wmessage = '00000';
                RETURN wmessage;
            ELSE
                SELECT numFacIni INTO wnum_venta FROM parametros FOR UPDATE;               --TRAEMOS NÚMERO DE FACTURA ACTUAL
                IF NOT FOUND THEN
                    wmessage = 'No se pudo encontrar el útimo número de factura registrado';
                    RETURN wmessage;
                END IF;
                IF wnum_venta IS NULL THEN
                    wmessage = 'Debe asignar un valor para arranque de las facturas';
                    RETURN wmessage;
                END IF;
                wnum_venta = wnum_venta + 1;
                IF wventa_dom = FALSE THEN
                    INSERT INTO venta(ventaNum, docClient, departamento, ciudad, tipopago, ventaRutFac, ventaRec, usr_insert, usr_insert_rol) 
                            VALUES(wnum_venta, wdoc_cliente, wdepartamento, wciudad, wtipopago, wruta, TRUE, wusr_insert, wusr_insert_rol);
                    IF NOT FOUND THEN
                        wmessage = 'Error en la inserción';                 --INSERCIÓN EN CASO DE QUE EL TIPO DE PAGO SEA OTRO
                        RETURN wmessage;
                    END IF;
                ELSE
                    INSERT INTO venta(ventaNum, docClient, departamento, ciudad, tipopago, ventaRutFac, ventaRec, ventaDom, usr_insert, usr_insert_rol) 
                            VALUES(wnum_venta, wdoc_cliente, wdepartamento, wciudad, wtipopago, wruta, TRUE, wventa_dom, wusr_insert, wusr_insert_rol);
                    IF NOT FOUND THEN
                        wmessage = 'Error en la inserción';                 --INSERCIÓN EN CASO DE QUE EL TIPO DE PAGO SEA OTRO
                        RETURN wmessage;
                    END IF;
                    -- AQUI INICIA LA INSERCIÓN DE LOS DATOS DEL DOMICILIO --
                    SELECT ciudadId, precioDom INTO wreg_ciudad FROM ciudad WHERE ciudadId=wciudad_id;
                    IF NOT FOUND THEN                                               --VERIFICAMOS EXISTENCIA DEL MUNICIPIO
                        wmessage = 'Este municipio no se encuentra registrado';
                        RETURN wmessage;
                    END IF;
                    INSERT INTO envio(envioNum, numVenta, idCiudad, envioDocDes, envioNomDes, envioDirDes, envioTelDes, envioPre, usr_insert, usr_insert_rol) 
                            VALUES(wnum_envio, wnum_venta, wreg_ciudad.ciudadId, wdoc_recibe, wnom_recibe, wdir_recibe, wtel_recibe, wreg_ciudad.precioDom, wusr_insert, wusr_insert_rol);
                    IF NOT FOUND THEN                                           --VALIDAMOS QUE LOS PUNTOS DEL CLIENTE SE HAYAN ACTUALIZADO
                        wmessage = 'Error en la inserción del envío';
                        RETURN wmessage;
                    END IF;
                    -- AQUI TEMRINA LA INSERCIÓN DE LOS DATOS DEL DOMICILIO --
                END IF;
                FOR i in 1..cantarray_prod LOOP     -- INICIO DEL CICLO DE DETALLES --
                    SELECT pr.producCod, pr.producSto, pr.producAct INTO wreg_producto FROM producto pr 
                    WHERE pr.producCod = wcod_producto[i] FOR UPDATE;
                    IF NOT FOUND THEN
                        wmessage = 'El producto solicitado de referencia ' || wcod_producto[i] || ' no se ha encontrado';
                        RETURN wmessage;                                        --VALIDAMOS EXISTENCIA DEL PRODUCTO
                    END IF;
                    IF wreg_producto.producAct = FALSE THEN
                        wmessage = 'El producto de referencia ' || wcod_producto[i] || ' no se encuentra disponible para la venta';
                        RETURN wmessage;                                        --VALIDAMOS QUE EL PRODUCTO ESTÉ DISPONIBLE PARA LA VENTA
                    END IF;
                    IF wcan_producto[i] > wreg_producto.producSto THEN
                        wmessage = 'La cantidad solicitada del producto de referencia ' || wcod_producto[i] || ' sobrepasa las unidades disponibles';
                        RETURN wmessage;                                        --VALIDAMOS SUFICIENCIA DE STOCK DEL PRODUCTO SOLICITADO
                    END IF;
                    
                    INSERT INTO detalleventa(numVenta, codProduc, detVentaCan, precioProduc, detVentaDes, detVentaValPar, usr_insert, usr_insert_rol) 
                                VALUES(wnum_venta, wcod_producto[i], wcan_producto[i], wprecio_producto[i], wdes_producto[i], wparcial_producto[i], wusr_insert, wusr_insert_rol);
                    IF NOT FOUND THEN                                           --VALIDAMOS QUE SE HAYA HECHO LA INSERCIÓN DEL DETALLE DE VENTA
                        wmessage = 'Error en la inserción del detalle de venta para el producto de referencia ' || wcod_producto[i];
                        RETURN wmessage;
                    END IF;
                    wreg_producto.producSto = wreg_producto.producSto - wcan_producto[i];
                    UPDATE producto SET producSto = wreg_producto.producSto, usr_update=wusr_insert, usr_update_rol=wusr_insert_rol
                                        WHERE producCod = wcod_producto[i];
                    IF NOT FOUND THEN                                           --VALIDAMOS QUE EL STOCK DEL PRODUCTO SE HAYA ACTUALIZADO
                        wmessage = 'Error en la actualización del stock del producto de referencia ' || wcod_producto[i];
                        RETURN wmessage;
                    END IF;
                END LOOP;   -- FIN DEL CICLO DE DETALLES --
                wpuntos_cliente = wpuntos_cliente + wreg_cliente.clientPun;
                UPDATE cliente SET clientPun = wpuntos_cliente, usr_update=wusr_insert, usr_update_rol=wusr_insert_rol
                                WHERE clientDoc=wdoc_cliente;
                IF NOT FOUND THEN                                           --VALIDAMOS QUE LOS PUNTOS DEL CLIENTE SE HAYAN ACTUALIZADO
                    wmessage = 'Error en la actualización de los puntos del cliente de documento ' || wdoc_cliente;
                    RETURN wmessage;
                END IF;
                UPDATE parametros SET numFacIni = wnum_venta, usr_update=wusr_insert, usr_update_rol=wusr_insert_rol;
                IF NOT FOUND THEN                                           --VALIDAMOS QUE LOS PUNTOS DEL CLIENTE SE HAYAN ACTUALIZADO
                    wmessage = 'Error en la actualización del parámetro de número de factura temporal actual';
                    RETURN wmessage;
                END IF;
            wmessage = TO_CHAR(wnum_venta, 'FM99999');
            RETURN wmessage;
        END CASE;
        
    END;
$$

LANGUAGE PLPGSQL;