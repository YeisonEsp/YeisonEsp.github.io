CREATE OR REPLACE FUNCTION fun_update_marca( wid_marca	marca.marcaId%TYPE,
                                                    wnom_marca	marca.marcaNom%TYPE,
                                                    wuser_update marca.usr_update%TYPE,
                                                    wuser_update_rol marca.usr_update_rol%TYPE) RETURNS VARCHAR AS
$BODY$
    DECLARE wmessage VARCHAR;
    DECLARE wmarca 	marca.marcaNom%TYPE;
    BEGIN
        wmessage = '00000';
        SELECT marcaNom INTO wmarca FROM marca WHERE marcaId=wid_marca FOR UPDATE; 
        SELECT marcaNom INTO wmarca FROM marca 
		WHERE marcaNom = wnom_marca AND marcaId != wid_marca;
		IF FOUND THEN
			wmessage = 'La marca ya se encuentra registrada';
			RETURN wmessage;
		END IF;
        UPDATE marca SET marcaNom   = wnom_marca,
                        usr_update     = wuser_update,
                        usr_update_rol = wuser_update_rol,
                        fec_update     = now()
        WHERE marcaId = wid_marca;
        IF FOUND THEN
            RETURN wmessage;
        ELSE
            wmessage = 'Error en la actualización';
            RETURN wmessage;
        END IF;
    END;
$BODY$
LANGUAGE PLPGSQL;