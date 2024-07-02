CREATE OR REPLACE FUNCTION fun_insert_contactenos( wnom_contactenos	contactenos.contacNom%TYPE,
                                                    wtel_contactenos	contactenos.contacTel%TYPE,
                                                    wema_contactenos	contactenos.contacEma%TYPE,
                                                    wasu_contactenos	contactenos.contacAsu%TYPE) RETURNS VARCHAR AS                                           
$BODY$
	DECLARE 
		wcontador 		contactenos.contacId%TYPE;
		wmessage		VARCHAR;
    BEGIN
		wmessage = '00000';
		SELECT max(contacId) INTO wcontador FROM contactenos;
		IF wcontador IS NULL THEN
			wcontador = 0;
		END IF;
		wcontador = wcontador + 1;
        INSERT INTO contactenos VALUES(wcontador, wnom_contactenos, wtel_contactenos, wema_contactenos, wasu_contactenos);
        IF FOUND THEN
            RETURN wmessage;
        ELSE
			wmessage = 'Error en la inserción';
            RETURN wmessage;
        END IF;
    END;
$BODY$
LANGUAGE PLPGSQL;