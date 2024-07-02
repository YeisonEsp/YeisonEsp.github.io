CREATE OR REPLACE FUNCTION fun_update_producto(wcod_producto producto.producCod%TYPE, wnom_producto producto.producNom%TYPE, 
												wpre_producto producto.producPre%TYPE, wsto_producto producto.producSto%TYPE,
                                                wuser_update producto.usr_update%TYPE, wuser_update_rol  producto.usr_update_rol%TYPE) RETURNS VARCHAR AS
$BODY$
    DECLARE wmessage VARCHAR;
    DECLARE wreg_producto RECORD;
    DECLARE diferencia INTEGER;
    BEGIN
        wmessage='00000';
        SELECT producSto, producMen INTO wreg_producto FROM producto WHERE producCod = wcod_producto FOR UPDATE;
        IF wsto_producto > wreg_producto.producSto OR wsto_producto < 0 THEN
            wmessage='Solo puede restar unidades al stock del producto y no puede haber unidades negativas';
            RETURN wmessage;
        END IF;
        -- SI EL NUEVO STOCK ES MENOR AL ANTERIOR, SE DEBE TOMAR ESA DIFERENCIA Y SUMARLA CON EL CONTADOR DE UNIDADES...
        -- RESTADAS A LA FUERZA
        diferencia = 0;
        IF wsto_producto < wreg_producto.producSto THEN
            diferencia = (wreg_producto.producSto - wsto_producto);
        END IF;
        wreg_producto.producMen = wreg_producto.producMen + diferencia;
        UPDATE producto SET     producNom       = wnom_producto,
                                producpre       = wpre_producto,
                                producSto       = wsto_producto,
                                producMen       = wreg_producto.producMen,
                                usr_update      = wuser_update,
                                usr_update_rol  = wuser_update_rol,
                                fec_update      = now()
        WHERE producCod = wcod_producto;
        IF FOUND THEN
            RETURN wmessage;
        ELSE
            wmessage='Error al actualizar';
            RETURN wmessage;
        END IF;
    END;
$BODY$
LANGUAGE PLPGSQL;