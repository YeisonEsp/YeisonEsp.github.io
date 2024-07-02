CREATE OR REPLACE FUNCTION fun_active_proveedor(wnit_proveedor proveedor.proveeNit%TYPE,
                                                wuser_update proveedor.usr_update%TYPE,
                                                wuser_update_rol  proveedor.usr_update_rol%TYPE) RETURNS VARCHAR AS
$BODY$

    DECLARE wproveedor proveedor.proveeNit%TYPE;
    DECLARE wmessage VARCHAR;
    BEGIN
        wmessage = '00000';
        SELECT proveeNit INTO wproveedor FROM proveedor WHERE proveeNit=wnit_proveedor FOR UPDATE;
        IF NOT FOUND THEN
            wmessage = 'El proveedor no se encuentra registrado';
            RETURN wmessage;
        END IF;
        UPDATE proveedor SET proveeAct=TRUE,
                            usr_update      = wuser_update,
                                usr_update_rol  = wuser_update_rol,
                                fec_update      = now()
        WHERE proveeNit = wnit_proveedor;
        IF FOUND THEN
            RETURN wmessage;
        ELSE
            wmessage = 'Error en la activación';
            RETURN wmessage;
        END IF;
    END;
$BODY$
LANGUAGE PLPGSQL;