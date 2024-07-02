CREATE OR REPLACE FUNCTION fun_update_linea( wid_linea	linea.lineaId%TYPE,
                                            wnom_linea	linea.lineaNom%TYPE,
                                            wuser_update linea.usr_update%TYPE,
                                            wuser_update_rol  linea.usr_update_rol%TYPE) RETURNS VARCHAR AS
$BODY$
    DECLARE wlinea 	linea.lineaNom%TYPE;
    DECLARE wmessage VARCHAR;
    BEGIN
        wmessage = '00000';
        SELECT lineaNom INTO wlinea FROM linea WHERE lineaId=wid_linea FOR UPDATE;
        SELECT lineaNom INTO wlinea FROM linea 
		WHERE lineaNom = wnom_linea AND lineaId != wid_linea;
		IF FOUND THEN
			wmessage = 'La línea ya se encuentra registrada';
			RETURN wmessage;
		END IF;
        UPDATE linea SET lineaNom       = wnom_linea,
                        usr_update     = wuser_update,
                        usr_update_rol = wuser_update_rol,
                        fec_update     = now()
        WHERE lineaId = wid_linea;
        IF FOUND THEN
            RETURN wmessage;
        ELSE
            wmessage = 'Error en la actualización';
            RETURN wmessage;
        END IF;
    END;
$BODY$
LANGUAGE PLPGSQL;