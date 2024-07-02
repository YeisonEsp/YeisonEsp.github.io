CREATE OR REPLACE FUNCTION fun_insert_linea( wnom_linea	linea.lineaNom%TYPE,
                                            wuser_insert linea.usr_insert%TYPE,
                                            wuser_insert_rol  linea.usr_insert_rol%TYPE) RETURNS VARCHAR AS                                           
$BODY$
	DECLARE 
		wlinea 	linea.lineaNom%TYPE;
		wcontador 		linea.lineaId%TYPE;
        wmessage VARCHAR;
    BEGIN
		wmessage='00000';
		SELECT lineaNom INTO wlinea from linea 
		WHERE lineaNom = wnom_linea;
		IF FOUND THEN
			wmessage = 'La línea de producto ya se encuentra registrada';
			RETURN wmessage;
		END IF;
		SELECT max(lineaId) INTO wcontador FROM linea;
		IF wcontador IS NULL THEN
			wcontador = 0;
		END IF;
		wcontador = wcontador + 1;
        INSERT INTO linea(lineaId,lineaNom,usr_insert,usr_insert_rol) 
					VALUES(wcontador, wnom_linea,wuser_insert,wuser_insert_rol);
        IF FOUND THEN
            RETURN wmessage;
        ELSE
            wmessage = 'Error en la inserción';
            RETURN wmessage;
        END IF;
    END;
$BODY$
LANGUAGE PLPGSQL;