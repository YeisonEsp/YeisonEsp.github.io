CREATE OR REPLACE FUNCTION fun_insert_marca( wnom_marca	marca.marcaNom%TYPE,
                                            wuser_insert marca.usr_insert%TYPE,
                                            wuser_insert_rol  marca.usr_insert_rol%TYPE) RETURNS VARCHAR AS                                           
$BODY$
	DECLARE 
		wmarca 	marca.marcaNom%TYPE;
		wcontador 		marca.marcaId%TYPE;
        wmessage VARCHAR;
    BEGIN
        wmessage = '00000';
		SELECT marcaNom INTO wmarca from marca 
		WHERE marcaNom = wnom_marca;
		IF FOUND THEN
			wmessage = 'La marca de producto ya se encuentra registrada';
			RETURN wmessage;
		END IF;
		SELECT max(marcaId) INTO wcontador FROM marca;
		IF wcontador IS NULL THEN
			wcontador = 0;
		END IF;
		wcontador = wcontador + 1;
        INSERT INTO marca(marcaId,marcaNom,usr_insert,usr_insert_rol) 
                    VALUES(wcontador, wnom_marca, wuser_insert, wuser_insert_rol);
        IF FOUND THEN
            RETURN wmessage;
        ELSE
            wmessage = 'Error en la inserción';
            RETURN wmessage;
        END IF;
    END;
$BODY$
LANGUAGE PLPGSQL;