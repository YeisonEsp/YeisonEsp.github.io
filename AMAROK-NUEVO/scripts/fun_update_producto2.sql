CREATE OR REPLACE FUNCTION fun_update_producto(wcod_producto producto.producCod%TYPE,
                                            wnom_producto producto.producNom%TYPE,
											wmod_producto producto.producMod%TYPE,
                                            wpre_producto producto.producPre%TYPE,wid_categoria producto.idTipoPro%TYPE,
											wid_linea producto.idLinea%TYPE, wid_marca producto.idMarca%TYPE,
                                            wbod_producto producto.producBod%TYPE, west_producto producto.producEst%TYPE,
                                            wmos_producto producto.producMos%TYPE,wuser_update producto.usr_update%TYPE,
                                            wuser_update_rol  producto.usr_update_rol%TYPE) RETURNS VARCHAR AS
$BODY$
    DECLARE wubicacion  producto.nomEstant%TYPE;
    DECLARE wmessage VARCHAR;
    DECLARE wproducto producto.producCod%TYPE;
    BEGIN
        wmessage='00000';
        SELECT producCod INTO wproducto FROM producto WHERE producCod = wcod_producto FOR UPDATE;
        SELECT nomEstant INTO wubicacion FROM producto
        WHERE producCod=wcod_producto;
        IF FOUND THEN
            UPDATE producto SET producNom       = wnom_producto,
								producMod		= wmod_producto,
                                producPre       = wpre_producto,
                                idTipoPro       = wid_categoria,
                                idLinea         = wid_linea,
                                idMarca         = wid_marca,
                                producBod       = wbod_producto,
                                producEst       = west_producto,
                                producMos       = wmos_producto,
                                nomEstant = null,
                                numBandeja = null,
                                codSeccion = null,
                                usr_update       = wuser_update,
                                usr_update_rol   = wuser_update_rol,
                                fec_update       = now()
            WHERE producCod = wcod_producto;
            IF FOUND THEN
                RETURN wmessage;
            ELSE
                wmessage='Error al actualizar';
                RETURN wmessage;
            END IF;
        ELSE
            UPDATE producto SET producNom       = wnom_producto,
								producMod		= wmod_producto,
                                producPre       = wpre_producto,
                                idTipoPro       = wid_categoria,
                                idLinea         = wid_linea,
                                idMarca         = wid_marca,
                                producBod       = wbod_producto,
                                producEst       = west_producto,
                                producMos       = wmos_producto,
                                usr_update       = wuser_update,
                                usr_update_rol   = wuser_update_rol,
                                fec_update       = now()
            WHERE producCod = wcod_producto;
            IF FOUND THEN
                RETURN wmessage;
            ELSE
                wmessage='Error al actualizar';
                RETURN wmessage;
            END IF;
        END IF;
    END;
$BODY$
LANGUAGE PLPGSQL;