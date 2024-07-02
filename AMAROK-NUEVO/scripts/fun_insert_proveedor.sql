CREATE OR REPLACE FUNCTION fun_insert_proveedor(wnit_proveedor proveedor.proveeNit%TYPE,
												wid_ciudad ciudad.ciudadId%TYPE,
												wnom_proveedor proveedor.proveeNom%TYPE,
                                            	wdir_proveedor proveedor.proveeDir%TYPE,
												wtel_proveedor proveedor.proveeTel%TYPE,
												wema_proveedor proveedor.proveeEma%TYPE,
                                                wuser_insert proveedor.usr_insert%TYPE,
                                                wuser_insert_rol proveedor.usr_insert_rol%TYPE) RETURNS VARCHAR AS
$BODY$
	DECLARE wmessage VARCHAR;
	DECLARE wproveedor proveedor.proveeNit%TYPE;
    BEGIN
		wmessage = '00000';
		SELECT proveeNit into wproveedor from proveedor WHERE proveeNit = wnit_proveedor;
		IF FOUND THEN
			wmessage = 'El proveedor ya se encuentra registrado';
			RETURN wmessage;
		END IF;
        INSERT INTO proveedor(proveeNit,idciudad,proveeNom,proveeDir,proveeTel,proveeEma,usr_insert,usr_insert_rol) 
        VALUES(wnit_proveedor, wid_ciudad, wnom_proveedor, wdir_proveedor,wtel_proveedor, wema_proveedor,wuser_insert,wuser_insert_rol);
        IF FOUND THEN
            RETURN wmessage;
        ELSE
			wmessage = 'Error en la inserción';
            RETURN wmessage;
        END IF;
    END;
$BODY$
LANGUAGE PLPGSQL;