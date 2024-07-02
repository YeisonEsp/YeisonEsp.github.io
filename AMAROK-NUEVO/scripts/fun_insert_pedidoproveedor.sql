CREATE OR REPLACE FUNCTION fun_insert_pedidoproveedor(wnum_pedido pedidoproveedor.pedidoNum%TYPE, wnit_proveedor proveedor.proveeNit%TYPE,
                                                    wtipopago pedidoproveedor.tipopago%TYPE, wtotal_pedido pedidoproveedor.pedidoTotal%TYPE,
                                                    wcod_producto VARCHAR[], wnom_producto VARCHAR[], wmod_producto VARCHAR[], wpre_producto DECIMAL(8,0)[],
                                                    wcat_producto DECIMAL(2,0)[], wlin_producto DECIMAL(2,0)[], wmar_producto DECIMAL(3,0)[],
                                                    wcan_producto DECIMAL(3,0)[], wcos_producto DECIMAL(7,0)[], wparcial_producto DECIMAL(8,0)[],
                                                    wuser_insert pedidoproveedor.usr_insert%TYPE,
                                                    wuser_insert_rol  pedidoproveedor.usr_insert_rol%TYPE) RETURNS VARCHAR AS
$$
    DECLARE wmessage VARCHAR;
    DECLARE wpedido  record;
    DECLARE wproveedor proveedor.proveeNit%TYPE;
    DECLARE i INTEGER;
    DECLARE cantarray_prod INTEGER = array_length(wcod_producto, 1);
    DECLARE wreg_producto RECORD;
    DECLARE wnewStock INTEGER;
    DECLARE wporcentaje parametros.porcenIva%TYPE;
    DECLARE wiva pedidoproveedor.pedidoIva%TYPE;

    BEGIN
        wmessage='00000';
        SELECT pedidoNum, nitProvee INTO wpedido FROM pedidoproveedor
        WHERE pedidoNum = wnum_pedido AND nitProvee=wnit_proveedor;         --Verificar la no existenia del número de pedido a ese proveedor
        IF FOUND THEN
            wmessage = 'El número de pedido ya se encuentra registrado';
            RETURN wmessage;
        END IF;
        SELECT p.proveeNit INTO wproveedor FROM proveedor p
        WHERE p.proveeNit = wnit_proveedor;                                  --Verificar existencia del proveedor
        IF NOT FOUND THEN
            wmessage = 'El proveedor no se encuentra registrado';
            RETURN wmessage;
        END IF;
        SELECT porcenIva INTO wporcentaje FROM parametros;                   --extraer porcentaje iva actual en Colombia
        IF NOT FOUND THEN
            wmessage = 'El porcentaje de iva no se encontró';
            RETURN wmessage;
        END IF;
        wiva = (wtotal_pedido * wporcentaje)/100;

        IF wtipopago != 'Ninguno' THEN
            INSERT INTO pedidoproveedor(pedidoNum, nitProvee, tipopago, pedidoTotal, pedidoIva, pedidoPag, usr_insert, usr_insert_rol) 
                        VALUES(wnum_pedido, wnit_proveedor, wtipopago, wtotal_pedido, wiva, TRUE, wuser_insert, wuser_insert_rol);
            IF NOT FOUND THEN
                wmessage = 'El número de pedido % al proveedor % no se ha insertado', wnum_pedido, wnit_proveedor;
                RETURN wmessage;
            END IF;
        ELSE
            INSERT INTO pedidoproveedor(pedidoNum, nitProvee, tipopago, pedidoTotal, pedidoIva, pedidoPag, usr_insert,usr_insert_rol) 
            VALUES(wnum_pedido, wnit_proveedor, wtipopago, wtotal_pedido, wiva, FALSE, wuser_insert, wuser_insert_rol);
            IF NOT FOUND THEN
                wmessage = 'El número de pedido % al proveedor % no se ha insertado', wnum_pedido, wnit_proveedor;
                RETURN wmessage;
            END IF;
        END IF;

        i=1;
        wnewStock = 0;
        FOR i in 1..cantarray_prod LOOP
            SELECT pr.producCod, pr.producNom, pr.producMod, pr.producPre, pr.producSto into wreg_producto FROM producto pr
            WHERE pr.producCod = wcod_producto[i] FOR UPDATE;
            IF NOT FOUND THEN
                insert into producto(producCod, idTipoPro, idLinea, idMarca, producNom, producMod, producSto, producPre, usr_insert,usr_insert_rol) VALUES(
                    wcod_producto[i], wcat_producto[i], wlin_producto[i], wmar_producto[i], wnom_producto[i], wmod_producto[i],0,
                    wpre_producto[i], wuser_insert, wuser_insert_rol);
                IF NOT FOUND THEN
                    wmessage = 'El producto % no se ha podido registrar', wcod_producto[i];
                    ROLLBACK;
                    RETURN wmessage;
                END IF;
            END IF;
            INSERT INTO detallepedido(numpedido, nitProvee, codProduc, detPedCan, detPedCos, detPedValPar,usr_insert,usr_insert_rol) VALUES(
                wnum_pedido, wnit_proveedor, wcod_producto[i], wcan_producto[i], wcos_producto[i], wparcial_producto[i],
                wuser_insert, wuser_insert_rol
            );
            IF NOT FOUND THEN
                wmessage = 'El producto % no se ha podido insertar en el pedido % al proveedor %', wcod_producto[i], wnum_pedido, wnit_proveedor;
                ROLLBACK;
                RETURN wmessage;
            END IF;
            IF wreg_producto.producSto IS NULL THEN
                wreg_producto.producSto = 0;
            END IF;
            wnewStock = wreg_producto.producSto + wcan_producto[i];
            UPDATE producto SET producSto = wnewStock, usr_update=wuser_insert, usr_update_rol=wuser_insert_rol,fec_update=now() 
            WHERE producCod=wcod_producto[i];
            IF NOT FOUND THEN
                wmessage = 'No se ha podido actualizar el inventario del producto %', wcod_producto[i];
                ROLLBACK;
                RETURN wmessage;
            END IF;
        END LOOP;
        RETURN wmessage;
    END;
$$
LANGUAGE PLPGSQL;