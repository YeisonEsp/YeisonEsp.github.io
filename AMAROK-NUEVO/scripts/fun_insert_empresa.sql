CREATE OR REPLACE FUNCTION fun_insert_empresa(	wnit_empresa empresatransporte.empreTraNit%TYPE, 
                                                wnom_empresa empresatransporte.empreTraNom%TYPE, 
												wtel_empresa empresatransporte.empreTraTel%TYPE,wuser_insert empresatransporte.usr_insert%TYPE,
                                                wuser_insert_rol  empresatransporte.usr_insert_rol%TYPE) RETURNS VARCHAR AS         
$BODY$
	DECLARE wempresa empresatransporte.empreTraNit%TYPE;
	DECLARE wmessage VARCHAR;
    BEGIN
		wmessage = '00000';
		SELECT empreTraNit into wempresa from empresatransporte WHERE empreTraNit = wnit_empresa;
		IF FOUND THEN
			wmessage = 'La empresa de transporte ya se encuentra registrada';
			RETURN wmessage;
		END IF;
        INSERT INTO empresatransporte(empreTraNit, empreTraNom, empreTraTel, usr_insert, usr_insert_rol, fec_insert) 
                                    VALUES(wnit_empresa, wnom_empresa, wtel_empresa, wuser_insert, wuser_insert_rol, now());
        IF FOUND THEN
            RETURN wmessage;
        ELSE
            wmessage = 'Error en la inserción';
            RETURN wmessage;
        END IF;
    END;
$BODY$
LANGUAGE PLPGSQL;