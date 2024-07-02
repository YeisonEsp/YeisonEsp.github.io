CREATE OR REPLACE FUNCTION fun_update_ciudad(  wcod_ciudad      ciudad.ciudadId%TYPE, 
                                                wdom_ciudad      ciudad.precioDom%TYPE,
                                                wuser_update ciudad.usr_update%TYPE,
                                                wuser_update_rol  ciudad.usr_update_rol%TYPE) RETURNS VARCHAR AS
$BODY$
	DECLARE wmessage VARCHAR;
    DECLARE wciudad ciudad.ciudadId%TYPE;
    BEGIN
		wmessage='00000';
        SELECT ciudadId INTO wciudad FROM ciudad WHERE ciudadId = wcod_ciudad FOR UPDATE;
        UPDATE ciudad SET precioDom         = wdom_ciudad,
                            usr_update      = wuser_update,
                            usr_update_rol  = wuser_update_rol,
                            fec_update      = now()
        WHERE ciudadId = wcod_ciudad;
        IF FOUND THEN
            RETURN wmessage;
        ELSE
			wmessage='Error en la actualización';
            RETURN wmessage;
        END IF;
    END;
$BODY$
LANGUAGE PLPGSQL;