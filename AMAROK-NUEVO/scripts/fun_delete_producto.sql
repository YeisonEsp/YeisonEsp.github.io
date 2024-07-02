CREATE OR REPLACE FUNCTION fun_delete_producto(wcod_producto producto.producCod%TYPE,
                                                wuser_update producto.usr_update%TYPE,
                                                wuser_update_rol  producto.usr_update_rol%TYPE) RETURNS VARCHAR AS
$BODY$

    DECLARE wproducto producto.producCod%TYPE;
    DECLARE wpedido detallepedido.codProduc%TYPE;
    DECLARE wventa detalleventa.codProduc%TYPE;
    DECLARE wmessage VARCHAR;
    BEGIN
        wmessage = '00000';
        SELECT producCod INTO wproducto FROM producto WHERE producCod=wcod_producto FOR UPDATE;
        IF NOT FOUND THEN
            wmessage = 'El producto no se encuentra registrado';
            RETURN wmessage;
        END IF;
        SELECT codProduc INTO wpedido FROM detallepedido WHERE codProduc=wcod_producto;
        SELECT codProduc INTO wventa FROM detalleventa WHERE codProduc=wcod_producto;
        IF wpedido IS NULL AND wventa IS NULL THEN
            DELETE FROM producto
            WHERE producCod = wcod_producto;
            IF FOUND THEN
                RETURN wmessage;
            ELSE
                wmessage = 'Error en la eliminación';
                RETURN wmessage;
            END IF;
        ELSE
            UPDATE producto SET producAct = FALSE, 
                                usr_update      = wuser_update,
                                usr_update_rol  = wuser_update_rol,
                                fec_update      = now()
            WHERE producCod = wcod_producto;
            IF FOUND THEN
                RETURN wmessage;
            ELSE
                wmessage = 'Error en la desactivación';
                RETURN wmessage;
            END IF;
        END IF;
    END;
$BODY$
LANGUAGE PLPGSQL;