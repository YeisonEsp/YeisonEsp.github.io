CREATE OR REPLACE FUNCTION fun_delete_proveedor(wnit_proveedor proveedor.proveeNit%TYPE,
                                                wuser_update proveedor.usr_update%TYPE,
                                                wuser_update_rol  proveedor.usr_update_rol%TYPE) RETURNS VARCHAR AS
$BODY$

    DECLARE wproveedor proveedor.proveeNit%TYPE;
    DECLARE wpedido pedidoproveedor.nitProvee%TYPE;
    DECLARE wmessage VARCHAR;
    BEGIN
        wmessage = '00000';
        SELECT proveeNit INTO wproveedor FROM proveedor WHERE proveeNit=wnit_proveedor FOR UPDATE;
        IF NOT FOUND THEN
            wmessage = 'El proveedor no se encuentra registrado';
            RETURN wmessage;
        END IF;
        SELECT nitProvee INTO wpedido FROM pedidoproveedor WHERE nitProvee=wnit_proveedor;
        IF wpedido IS NULL THEN
            DELETE FROM proveedor
            WHERE proveeNit = wnit_proveedor;
            IF FOUND THEN
                RETURN wmessage;
            ELSE
                wmessage = 'Error en la eliminación';
                RETURN wmessage;
            END IF;
        ELSE
            UPDATE proveedor SET proveeAct = FALSE,
                                usr_update      = wuser_update,
                                usr_update_rol  = wuser_update_rol,
                                fec_update      = now()
            WHERE proveeNit = wnit_proveedor;
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