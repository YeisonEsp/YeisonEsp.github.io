CREATE OR REPLACE FUNCTION fun_insert_seccion(wnom_estante        seccion.nomEstant%TYPE, 
                                                wnum_bandeja       seccion.numBandeja%TYPE,
                                                wcod_seccion       seccion.seccionCod%TYPE,
                                                wuser_insert        seccion.usr_insert%TYPE,
                                                wuser_insert_rol    seccion.usr_insert_rol%TYPE) RETURNS VARCHAR AS                                           
$BODY$
    DECLARE wmessage VARCHAR;
	DECLARE 
		wseccion RECORD;
    BEGIN
		wmessage='00000';
		SELECT seccionCod, numBandeja, nomEstant INTO wseccion from seccion 
		WHERE seccionCod = wcod_seccion AND numBandeja = wnum_bandeja 
        AND nomEstant = wnom_estante;
		IF FOUND THEN
			wmessage = 'La sección de esta bandeja en este estante ya se encuentra registrada';
			RETURN wmessage;
		END IF;
        INSERT INTO seccion(nomEstant,numBandeja,seccionCod,usr_insert,usr_insert_rol) 
                        VALUES(wnom_estante, wnum_bandeja, wcod_seccion, wuser_insert, wuser_insert_rol);
        IF FOUND THEN
            RETURN wmessage;
        ELSE
            wmessage='Error al insertar';
            RETURN wmessage;
        END IF;
    END;
$BODY$
LANGUAGE PLPGSQL;