CREATE OR REPLACE FUNCTION fun_insert_bandeja(wnum_bandeja bandeja.bandejaNum%TYPE,
                                                wnom_estante bandeja.nomEstant%TYPE,
                                                wuser_insert bandeja.usr_insert%TYPE,
                                                wuser_insert_rol  bandeja.usr_insert_rol%TYPE) RETURNS VARCHAR AS                                           
$BODY$
	DECLARE wbandeja RECORD;
    DECLARE wmessage VARCHAR;
    BEGIN
		wmessage='00000';
		SELECT bandejaNum, nomEstant INTO wbandeja from bandeja 
		WHERE  bandejaNum = wnum_bandeja AND nomEstant = wnom_estante;
		IF FOUND THEN
			wmessage = 'La bandeja en este estante ya se encuentra registrada';
			RETURN wmessage;
		END IF;
        INSERT INTO bandeja(nomEstant,bandejaNum,usr_insert,usr_insert_rol) VALUES(wnom_estante, wnum_bandeja,wuser_insert,wuser_insert_rol);
        IF FOUND THEN
            RETURN wmessage;
        ELSE
            wmessage='Error al insertar';
            RETURN wmessage;
        END IF;
    END;
$BODY$
LANGUAGE PLPGSQL;