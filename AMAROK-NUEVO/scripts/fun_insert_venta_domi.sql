CREATE OR REPLACE FUNCTION fun_insert_venta_domi(wdoc_cliente cliente.clientDoc%TYPE,
                                            wcod_producto VARCHAR[], wcan_producto DECIMAL(3,0)[],
                                            wciudad ciudad.ciudadId%TYPE, wdoc_recibe envio.envioDocDes%TYPE, wnom_recibe envio.envioNomDes%TYPE,
                                            wtel_recibe envio.envioTelDes%TYPE,
                                            wdir_recibe envio.envioDirDes%TYPE) RETURNS VARCHAR AS
$$
    DECLARE wmessage VARCHAR;
    DECLARE i INTEGER;
    DECLARE wnum_venta parametros.numFacFal%TYPE;
    DECLARE cantarray_prod INTEGER = array_length(wcod_producto, 1);
    DECLARE wreg_producto RECORD;
    DECLARE wreg_cliente RECORD;
    DECLARE wruta VARCHAR;
    DECLARE wvalorparcial detalleventa.detVentaValPar%TYPE;
    DECLARE wpendientes INTEGER;

    DECLARE wreg_ciudad RECORD;
    DECLARE wnum_envio envio.envioNum%TYPE;
    BEGIN
        wmessage = '00000';
        wruta = '../facturas_ventas/' || wdoc_cliente;
        SELECT cl.clientDoc, cl.clientAct, d.departNom, c.ciudadNom INTO wreg_cliente FROM cliente cl 
        JOIN ciudad c ON cl.idCiudad=c.ciudadId JOIN departamento d ON c.idDepart=d.departId 
        WHERE clientDoc=wdoc_cliente;
        IF wreg_cliente.clientDoc IS NULL THEN
            wmessage = 'El cliente no se encuentra registrado';         --VALIDAMOS QUE EL CLIENTE ESTÉ REGISTRADO
            RETURN wmessage;
        END IF;

        IF wreg_cliente.clientAct = FALSE THEN
            wmessage = 'El cliente no está activo';                     --VALIDAMOS QUE EL CLIENTE ESTÉ ACTIVO
            RETURN wmessage;
        END IF;

        SELECT COUNT(ventaNum) INTO wpendientes FROM venta WHERE ventaRec=false AND docClient=wdoc_cliente;
        IF wpendientes > 0 THEN
            wmessage = 'El cliente tiene un pedido pendiente por pagar'; --VALIDAMOS QUE EL CLIENTE NO DEBA NINGÚN PEDIDO
            RETURN wmessage;
        END IF;

        SELECT numFacFal INTO wnum_venta FROM parametros FOR UPDATE;               --TRAEMOS NÚMERO DE FACTURA ACTUAL
        IF NOT FOUND THEN
            wmessage = 'No se pudo encontrar el útimo número falso de factura registrado';
            RETURN wmessage;
        END IF;
        IF wnum_venta IS NULL THEN
            wmessage = 'Debe asignar un valor para arranque de las facturas falsas o temporales';
            RETURN wmessage;
        END IF;
        wnum_venta = wnum_venta - 1;

        SELECT ciudadId, precioDom INTO wreg_ciudad FROM ciudad WHERE ciudadId=wciudad;
        IF NOT FOUND THEN                                               --VERIFICAMOS EXISTENCIA DEL MUNICIPIO
            wmessage = 'Este municipio no se encuentra registrado';
            RETURN wmessage;
        END IF;

        SELECT max(envioNum) INTO wnum_envio FROM envio;
		IF wnum_envio IS NULL THEN
			wnum_envio = 0;
		END IF;
		wnum_envio = wnum_envio + 1;

        INSERT INTO venta(ventaNum, docClient, departamento, ciudad, tipopago, ventaDom, usr_insert, usr_insert_rol) 
                            VALUES(wnum_venta, wdoc_cliente, wreg_cliente.departNom, wreg_cliente.ciudadNom, 
                                    'Ninguno', TRUE, wdoc_cliente, 'Cliente');
        IF NOT FOUND THEN
            wmessage = 'Error en la inserción';                 --INSERCIÓN EN CASO DE QUE EL TIPO DE PAGO SEA NINGUNO
            RETURN wmessage;
        END IF;

        i=1;
        FOR i in 1..cantarray_prod LOOP     -- INICIO DEL CICLO DE DETALLES --
            SELECT pr.producCod, pr.producSto, pr.producPre, pr.producAct INTO wreg_producto FROM producto pr 
            WHERE pr.producCod = wcod_producto[i];
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

            wvalorparcial = wcan_producto[i] * wreg_producto.producPre;
            
            INSERT INTO detalleventa(numVenta, codProduc, detVentaCan, precioProduc, detVentaDes, detVentaValPar, usr_insert, usr_insert_rol) 
                        VALUES(wnum_venta, wcod_producto[i], wcan_producto[i], wreg_producto.producPre, 0, wvalorparcial, wdoc_cliente, 'Cliente');
            IF NOT FOUND THEN                                           --VALIDAMOS QUE SE HAYA HECHO LA INSERCIÓN DEL DETALLE DE VENTA
                wmessage = 'Error en la inserción del detalle de venta para el producto de referencia ' || wcod_producto[i];
                RETURN wmessage;
            END IF;
        END LOOP;   -- FIN DEL CICLO DE DETALLES --
        
        UPDATE parametros SET numFacFal = wnum_venta, usr_update=wdoc_cliente, usr_update_rol='Cliente';
        IF NOT FOUND THEN                                           --VALIDAMOS QUE LOS PUNTOS DEL CLIENTE SE HAYAN ACTUALIZADO
            wmessage = 'Error en la actualización del parámetro de número de factura actual';
            RETURN wmessage;
        END IF;
        INSERT INTO envio(envioNum, numVenta, idCiudad, envioDocDes, envioNomDes, envioDirDes, envioTelDes, envioPre, usr_insert, usr_insert_rol) 
                VALUES(wnum_envio, wnum_venta, wreg_ciudad.ciudadId, wdoc_recibe, wnom_recibe, wdir_recibe, wtel_recibe, wreg_ciudad.precioDom, wdoc_cliente, 'Cliente');
        IF NOT FOUND THEN                                           --VALIDAMOS QUE LOS PUNTOS DEL CLIENTE SE HAYAN ACTUALIZADO
            wmessage = 'Error en la inserción del envío';
            RETURN wmessage;
        END IF;
        RETURN wmessage;
    END;
$$

LANGUAGE PLPGSQL;