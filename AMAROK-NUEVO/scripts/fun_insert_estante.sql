CREATE OR REPLACE FUNCTION fun_insert_estante( wnom_estante	estante.estantNom%TYPE,
                                                wuser_insert estante.usr_insert%TYPE,
                                                wuser_insert_rol  estante.usr_insert_rol%TYPE) RETURNS VARCHAR AS                                           
$BODY$
    DECLARE wmessage VARCHAR;
	DECLARE 
		westante 	estante.estantNom%TYPE;
    BEGIN
		wmessage='00000';
		SELECT estantNom INTO westante from estante 
		WHERE estantNom = wnom_estante;
		IF FOUND THEN
			wmessage = 'El estante de productos ya se encuentra registrado';
			RETURN wmessage;
		END IF;
        INSERT INTO estante(estantNom, usr_insert, usr_insert_rol) VALUES(wnom_estante, wuser_insert, wuser_insert_rol);
        IF FOUND THEN
            RETURN wmessage;
        ELSE
            wmessage='Error al insertar';
            RETURN wmessage;
        END IF;
    END;
$BODY$
LANGUAGE PLPGSQL;