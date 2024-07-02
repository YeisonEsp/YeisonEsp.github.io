CREATE OR REPLACE FUNCTION fun_insert_tipoproducto( wnom_tipoproducto	tipoproducto.tipoProNom%TYPE,
                                                    wuser_insert tipoproducto.usr_insert%TYPE,
                                                    wuser_insert_rol tipoproducto.usr_insert_rol%TYPE) RETURNS VARCHAR AS                                           
$BODY$
	DECLARE 
		wtipoproducto 	tipoproducto.tipoProNom%TYPE;
		wcontador 		tipoproducto.tipoProId%TYPE;
        wmessage VARCHAR;
    BEGIN
		wmessage='00000';
		SELECT tipoProNom INTO wtipoproducto from tipoproducto 
		WHERE tipoProNom = wnom_tipoproducto;
		IF FOUND THEN
			wmessage = 'La categoría de producto ya se encuentra registrada';
			RETURN wmessage;
		END IF;
		SELECT max(tipoProId) INTO wcontador FROM tipoproducto;
		IF wcontador IS NULL THEN
			wcontador = 0;
		END IF;
		wcontador = wcontador + 1;
        INSERT INTO tipoproducto VALUES(wcontador, wnom_tipoproducto, wuser_insert, wuser_insert_rol);
        IF FOUND THEN
            RETURN wmessage;
        ELSE
            wmessage = 'Error en la inserción';
            RETURN wmessage;
        END IF;
    END;
$BODY$
LANGUAGE PLPGSQL;