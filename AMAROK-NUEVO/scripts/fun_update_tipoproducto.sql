CREATE OR REPLACE FUNCTION fun_update_tipoproducto( wid_tipoproducto	tipoproducto.tipoProId%TYPE,
                                                    wnom_tipoproducto	tipoproducto.tipoProNom%TYPE,
                                                    wuser_update tipoproducto.usr_update%TYPE,
                                                    wuser_update_rol tipoproducto.usr_update_rol%TYPE) RETURNS VARCHAR AS
$BODY$
    DECLARE wmessage VARCHAR;
    DECLARE wtipoproducto 	tipoproducto.tipoProNom%TYPE;
    BEGIN
        wmessage = '00000';
        SELECT tipoProNom INTO wtipoproducto FROM tipoproducto WHERE tipoProId = wid_tipoproducto FOR UPDATE;
        SELECT tipoProNom INTO wtipoproducto FROM tipoproducto 
		WHERE tipoProNom = wnom_tipoproducto AND tipoProId != wid_tipoproducto;
		IF FOUND THEN
			wmessage = 'La categoría ya se encuentra registrada';
			RETURN wmessage;
		END IF;
        UPDATE tipoproducto SET tipoProNom   = wnom_tipoproducto,
                                usr_update       = wuser_update,
                                usr_update_rol   = wuser_update_rol,
                                fec_update       = now()
        WHERE tipoProId = wid_tipoproducto;
        IF FOUND THEN
            RETURN wmessage;
        ELSE
            wmessage = 'Error en la actualización';
            RETURN wmessage;
        END IF;
    END;
$BODY$
LANGUAGE PLPGSQL;