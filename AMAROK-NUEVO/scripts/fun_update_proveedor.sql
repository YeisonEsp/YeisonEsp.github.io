CREATE OR REPLACE FUNCTION fun_update_proveedor(wnit_proveedor proveedor.proveeNit%TYPE,
												wid_ciudad ciudad.ciudadId%TYPE,
												wnom_proveedor proveedor.proveeNom%TYPE,
                                                wdir_proveedor proveedor.proveeDir%TYPE,
												wtel_proveedor proveedor.proveeTel%TYPE,
												wema_proveedor proveedor.proveeEma%TYPE,
                                                wuser_update proveedor.usr_update%TYPE,
                                                wuser_update_rol proveedor.usr_update_rol%TYPE) RETURNS VARCHAR AS
$BODY$
    DECLARE wmessage VARCHAR;
    DECLARE wciudad ciudad.ciudadId%TYPE;
    DECLARE wproveedor proveedor.proveeNit%TYPE;
    BEGIN
        wmessage = '00000';
        SELECT proveeNit INTO wproveedor FROM proveedor WHERE proveeNit = wnit_proveedor FOR UPDATE;
        SELECT ciudadId INTO wciudad FROM ciudad WHERE ciudadId=wid_ciudad;
        IF NOT FOUND THEN
            wmessage = 'La ciudad no se encuentra registrada';
            RETURN wmessage;
        END IF;
        UPDATE proveedor SET    proveeNit       = wnit_proveedor,
                                idCiudad		= wid_ciudad,
                                proveeNom       = wnom_proveedor,
                                proveeDir       = wdir_proveedor,
                                proveeTel       = wtel_proveedor,
                                proveeEma       = wema_proveedor,
                                usr_update       = wuser_update,
                                usr_update_rol   = wuser_update_rol,
                                fec_update       = now()
        WHERE proveeNit = wnit_proveedor;
        IF FOUND THEN
            RETURN wmessage;
        ELSE
            wmessage = 'Error en la actualización';
            RETURN wmessage;
        END IF;
    END;
$BODY$
LANGUAGE PLPGSQL;